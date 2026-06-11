#!/usr/bin/env python3
"""Build the open-source backend online update package."""

from __future__ import annotations

import argparse
import hashlib
import json
import os
from pathlib import Path
from zipfile import ZIP_DEFLATED, ZipFile


REPO_ROOT = Path(__file__).resolve().parents[1]
ADMIN_DIR = REPO_ROOT / "weimenjin_admin"
UPDATES_DIR = ADMIN_DIR / "public" / "updates"

EXCLUDED_DIRS = {
    ".git",
    "__pycache__",
    "runtime",
    "backup",
    "public/upload",
    "public/uploads",
    "public/qrdata",
    "public/updates",
    "extend/utils/wechart/zcerts",
}

EXCLUDED_FILES = {
    ".env",
    "env",
    "config/database.php",
    "config/my.php",
}

UPDATE_ARTIFACT_PREFIXES = (
    "weimenjin_update_",
    "weimenjin_delta_",
    "baseline_",
)

UPDATE_ARTIFACT_SUFFIXES = (
    ".zip",
    ".json",
)


def normalize(path: Path) -> str:
    return path.as_posix().strip("/")


def is_excluded(relative: str) -> bool:
    relative = normalize(Path(relative))
    if relative in EXCLUDED_FILES:
        return True
    for excluded in EXCLUDED_DIRS:
        if relative == excluded or relative.startswith(excluded + "/"):
            return True
    return False


def iter_admin_files() -> list[Path]:
    files: list[Path] = []
    for root, dirs, names in os.walk(ADMIN_DIR):
        root_path = Path(root)
        rel_root = normalize(root_path.relative_to(ADMIN_DIR))
        dirs[:] = [
            name
            for name in dirs
            if not is_excluded(normalize(Path(rel_root) / name))
        ]
        for name in names:
            path = root_path / name
            rel = normalize(path.relative_to(ADMIN_DIR))
            if not is_excluded(rel):
                files.append(path)
    return sorted(files, key=lambda item: normalize(item.relative_to(REPO_ROOT)))


def collect_sql_files() -> list[str]:
    sql_files: list[Path] = []
    # Legacy config SQL writes Chinese labels/content. Older updaters split SQL
    # using a Unicode newline token that can corrupt UTF-8 bytes before the new
    # updater code is loaded, so runtime/app configs are now reconciled in PHP.
    safe_sql_names = {
        "database/update_20260606_10.sql",
        "database/updates/20260606_19_sync_schema.sql",
        "database/updates/20260606_23_fix_sidebar_logo.sql",
    }
    sql_files.extend(
        sorted(
            item for item in (ADMIN_DIR / "database").glob("update_*.sql")
            if normalize(item.relative_to(ADMIN_DIR)) in safe_sql_names
        )
    )
    sql_files.extend(
        sorted(
            item for item in (ADMIN_DIR / "database" / "updates").glob("*.sql")
            if normalize(item.relative_to(ADMIN_DIR)) in safe_sql_names
        )
    )
    return [normalize(Path("weimenjin_admin") / item.relative_to(ADMIN_DIR)) for item in sql_files]


def sha256_file(path: Path) -> str:
    digest = hashlib.sha256()
    with path.open("rb") as handle:
        for chunk in iter(lambda: handle.read(1024 * 1024), b""):
            digest.update(chunk)
    return digest.hexdigest()


def build_baseline(version: str, files: list[Path]) -> tuple[str, str, dict]:
    safe_version = version.replace(".", "_")
    baseline_name = f"baseline_{safe_version}.json"
    baseline_path = UPDATES_DIR / baseline_name
    items = []
    for path in files:
        archive_name = normalize(Path("weimenjin_admin") / path.relative_to(ADMIN_DIR))
        items.append({
            "path": archive_name,
            "size": path.stat().st_size,
            "sha256": sha256_file(path),
        })
    baseline = {
        "version": version,
        "root": "weimenjin_admin",
        "file_count": len(items),
        "files": items,
    }
    baseline_path.write_text(
        json.dumps(baseline, ensure_ascii=False, indent=2) + "\n",
        encoding="utf-8",
        newline="\n",
    )
    return baseline_name, sha256_file(baseline_path), baseline


def load_baseline(path: Path) -> dict:
    return json.loads(path.read_text(encoding="utf-8"))


def baseline_map(baseline: dict) -> dict[str, dict]:
    return {str(item["path"]): item for item in baseline.get("files", [])}


def archive_files(package_path: Path, files: list[Path]) -> None:
    if package_path.exists():
        package_path.unlink()
    with ZipFile(package_path, "w", compression=ZIP_DEFLATED, allowZip64=True) as archive:
        for path in files:
            archive_name = normalize(Path("weimenjin_admin") / path.relative_to(ADMIN_DIR))
            archive.write(path, archive_name)


def changed_files(files: list[Path], old_baseline: dict) -> list[Path]:
    old = baseline_map(old_baseline)
    changed: list[Path] = []
    for path in files:
        archive_name = normalize(Path("weimenjin_admin") / path.relative_to(ADMIN_DIR))
        item = old.get(archive_name)
        if item is None or item.get("sha256") != sha256_file(path) or int(item.get("size", -1)) != path.stat().st_size:
            changed.append(path)
    return changed


def deleted_paths(new_baseline: dict, old_baseline: dict) -> list[str]:
    new_paths = set(baseline_map(new_baseline))
    return sorted(path for path in baseline_map(old_baseline) if path not in new_paths)


def referenced_update_artifacts(manifest: dict) -> set[str]:
    keep = {"manifest.json"}
    candidates = [manifest, *manifest.get("packages", [])]
    for item in candidates:
        if not isinstance(item, dict):
            continue
        for key in ("package_url", "baseline_url", "from_baseline_url"):
            value = str(item.get(key, "")).strip()
            if value and not value.startswith(("http://", "https://", "/")):
                keep.add(Path(value).name)
    return keep


def prune_update_artifacts(manifest: dict) -> list[str]:
    keep = referenced_update_artifacts(manifest)
    removed: list[str] = []
    for path in UPDATES_DIR.iterdir():
        if not path.is_file() or path.name in keep:
            continue
        if not path.name.startswith(UPDATE_ARTIFACT_PREFIXES) or not path.name.endswith(UPDATE_ARTIFACT_SUFFIXES):
            continue
        path.unlink()
        removed.append(path.name)
    return sorted(removed)


def build(version: str, notes: str, force: bool = False, from_baselines: list[str] | None = None, prune: bool = True) -> dict:
    UPDATES_DIR.mkdir(parents=True, exist_ok=True)
    safe_version = version.replace(".", "_")
    package_name = f"weimenjin_update_{safe_version}.zip"
    package_path = UPDATES_DIR / package_name

    files = iter_admin_files()
    baseline_name, baseline_sha256, baseline = build_baseline(version, files)
    archive_files(package_path, files)
    full_package = {
        "name": package_name,
        "version": version,
        "to_version": version,
        "package_url": package_name,
        "sha256": sha256_file(package_path),
        "package_type": "full_admin",
        "strategy": "full_admin_preserve_runtime",
        "baseline_url": baseline_name,
        "baseline_sha256": baseline_sha256,
        "package_size": package_path.stat().st_size,
        "file_count": len(files),
        "delete_paths": [],
        "sql_files": collect_sql_files(),
    }

    packages = []
    top_package = full_package
    for from_baseline in (from_baselines or []):
        old_baseline_path = Path(from_baseline)
        if not old_baseline_path.is_absolute():
            old_baseline_path = UPDATES_DIR / from_baseline
        old_baseline = load_baseline(old_baseline_path)
        delta_files = changed_files(files, old_baseline)
        from_version = str(old_baseline.get("version", ""))
        delta_name = f"weimenjin_delta_{from_version.replace('.', '_')}_to_{safe_version}.zip"
        delta_path = UPDATES_DIR / delta_name
        archive_files(delta_path, delta_files)
        delta_package = {
            "name": delta_name,
            "version": version,
            "from_version": from_version,
            "from_baseline_url": old_baseline_path.name,
            "to_version": version,
            "package_url": delta_name,
            "sha256": sha256_file(delta_path),
            "package_type": "delta_admin",
            "strategy": "baseline_delta",
            "baseline_url": baseline_name,
            "baseline_sha256": baseline_sha256,
            "package_size": delta_path.stat().st_size,
            "file_count": len(delta_files),
            "delete_paths": deleted_paths(baseline, old_baseline),
            "sql_files": collect_sql_files(),
        }
        packages.append(delta_package)
    packages.append(full_package)

    manifest = {
        "version": version,
        "package_url": top_package["package_url"],
        "sha256": "",
        "notes": notes,
        "force": force,
        "package_type": top_package["package_type"],
        "strategy": top_package["strategy"],
        "baseline_url": baseline_name,
        "baseline_sha256": baseline_sha256,
        "package_size": top_package["package_size"],
        "file_count": top_package["file_count"],
        "delete_paths": top_package["delete_paths"],
        "sql_files": top_package["sql_files"],
        "packages": packages,
    }
    manifest_path = UPDATES_DIR / "manifest.json"
    manifest_path.write_text(
        json.dumps(manifest, ensure_ascii=False, indent=4) + "\n",
        encoding="utf-8",
        newline="\n",
    )
    if prune:
        removed = prune_update_artifacts(manifest)
        if removed:
            manifest["pruned_artifacts"] = removed
    return manifest


def main() -> None:
    parser = argparse.ArgumentParser(description="Build Weimenjin online update package")
    parser.add_argument("--version", required=True, help="Release version, for example 2026.06.06.30")
    parser.add_argument("--notes", required=True, help="User-facing update notes")
    parser.add_argument("--force", action="store_true", help="Mark this update as forced")
    parser.add_argument(
        "--from-baseline",
        action="append",
        default=[],
        help="Previous baseline JSON for building a delta package. Can be passed multiple times.",
    )
    parser.add_argument("--no-prune", action="store_true", help="Do not remove old unreferenced update artifacts")
    args = parser.parse_args()

    manifest = build(args.version, args.notes, args.force, args.from_baseline, not args.no_prune)
    print(json.dumps(manifest, ensure_ascii=False, indent=2))


if __name__ == "__main__":
    main()

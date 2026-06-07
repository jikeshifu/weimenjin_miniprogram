#!/usr/bin/env python3
"""Build the open-source backend online update package.

The package is intentionally a complete backend release instead of a narrow
delta. Runtime data, uploaded files, database credentials, and previous update
packages are excluded; the installer also preserves those paths on the target.
"""

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
    sql_files.extend(sorted((ADMIN_DIR / "database").glob("update_*.sql")))
    sql_files.extend(sorted((ADMIN_DIR / "database" / "updates").glob("*.sql")))
    return [normalize(Path("weimenjin_admin") / item.relative_to(ADMIN_DIR)) for item in sql_files]


def sha256_file(path: Path) -> str:
    digest = hashlib.sha256()
    with path.open("rb") as handle:
        for chunk in iter(lambda: handle.read(1024 * 1024), b""):
            digest.update(chunk)
    return digest.hexdigest()


def build_baseline(version: str, files: list[Path]) -> tuple[str, str]:
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
    return baseline_name, sha256_file(baseline_path)


def build(version: str, notes: str, force: bool = False) -> dict:
    UPDATES_DIR.mkdir(parents=True, exist_ok=True)
    safe_version = version.replace(".", "_")
    package_name = f"weimenjin_update_{safe_version}.zip"
    package_path = UPDATES_DIR / package_name
    if package_path.exists():
        package_path.unlink()

    files = iter_admin_files()
    baseline_name, baseline_sha256 = build_baseline(version, files)
    with ZipFile(package_path, "w", compression=ZIP_DEFLATED, allowZip64=True) as archive:
        for path in files:
            archive_name = normalize(Path("weimenjin_admin") / path.relative_to(ADMIN_DIR))
            archive.write(path, archive_name)

    manifest = {
        "version": version,
        "package_url": package_name,
        "sha256": sha256_file(package_path),
        "notes": notes,
        "force": force,
        "package_type": "full_admin",
        "strategy": "full_admin_preserve_runtime",
        "baseline_url": baseline_name,
        "baseline_sha256": baseline_sha256,
        "package_size": package_path.stat().st_size,
        "file_count": len(files),
        "delete_paths": [],
        "sql_files": collect_sql_files(),
    }
    manifest_path = UPDATES_DIR / "manifest.json"
    manifest_path.write_text(
        json.dumps(manifest, ensure_ascii=False, indent=4) + "\n",
        encoding="utf-8",
        newline="\n",
    )
    return manifest


def main() -> None:
    parser = argparse.ArgumentParser(description="Build Weimenjin online update package")
    parser.add_argument("--version", required=True, help="Release version, for example 2026.06.06.30")
    parser.add_argument("--notes", required=True, help="User-facing update notes")
    parser.add_argument("--force", action="store_true", help="Mark this update as forced")
    args = parser.parse_args()

    manifest = build(args.version, args.notes, args.force)
    print(json.dumps(manifest, ensure_ascii=False, indent=2))


if __name__ == "__main__":
    main()

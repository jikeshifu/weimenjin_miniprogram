#!/usr/bin/env python3
"""Check source files are UTF-8 and do not contain replacement mojibake."""

from pathlib import Path
import sys

if hasattr(sys.stdout, "reconfigure"):
    sys.stdout.reconfigure(encoding="utf-8", errors="backslashreplace")

ROOT = Path(__file__).resolve().parents[1]

TEXT_SUFFIXES = {
    ".php", ".html", ".htm", ".js", ".css", ".json", ".md", ".sql",
    ".vue", ".scss", ".txt", ".yml", ".yaml", ".env", ".ini", ".xml",
}

SKIP_DIR_NAMES = {
    ".git", "vendor", "node_modules", "runtime", "unpackage",
}

SKIP_PREFIXES = {
    "weimenjin_admin/public/updates",
    "weimenjin_admin/public/camweb/assets",
    "weimenjin_admin/public/static/js/ueditor",
    "weimenjin_admin/public/static/js/xheditor",
}

MOJIBAKE_MARKERS = (
    "\ufffd",
    "\u951f\u65a4\u62f7",
)


def should_skip(path: Path) -> bool:
    rel = path.relative_to(ROOT).as_posix()
    if any(part in SKIP_DIR_NAMES for part in path.relative_to(ROOT).parts):
        return True
    return any(rel == item or rel.startswith(item + "/") for item in SKIP_PREFIXES)


def iter_text_files():
    for path in ROOT.rglob("*"):
        if not path.is_file() or should_skip(path):
            continue
        if path.suffix.lower() in TEXT_SUFFIXES or path.name in {".editorconfig", ".gitattributes", ".gitignore"}:
            yield path


def main() -> int:
    problems = []
    for path in iter_text_files():
        rel = path.relative_to(ROOT).as_posix()
        try:
            text = path.read_text(encoding="utf-8")
        except UnicodeDecodeError as exc:
            problems.append(f"{rel}: not valid UTF-8 ({exc})")
            continue
        for marker in MOJIBAKE_MARKERS:
            if marker in text:
                problems.append(f"{rel}: contains mojibake marker {marker!r}")
                break

    if problems:
        print("Encoding check failed:")
        for item in problems:
            print(" - " + item)
        return 1

    print("Encoding check passed.")
    return 0


if __name__ == "__main__":
    sys.exit(main())

#!/usr/bin/env python3
from pathlib import Path
import sys

TEXT_EXTENSIONS = {
    ".css",
    ".htm",
    ".html",
    ".inc",
    ".js",
    ".lng",
    ".php",
    ".tpl",
    ".txt",
    ".xml",
}


def is_valid_utf8(data: bytes) -> bool:
    try:
        data.decode("utf-8")
        return True
    except UnicodeDecodeError:
        return False


def main() -> int:
    if len(sys.argv) != 2:
        print("Usage: convert-files-to-utf8.py <site-root>", file=sys.stderr)
        return 2

    root = Path(sys.argv[1]).resolve()
    if not root.is_dir():
        print(f"Not a directory: {root}", file=sys.stderr)
        return 2

    converted = 0
    skipped = 0
    already_utf8 = 0

    for path in sorted(root.rglob("*")):
        if not path.is_file() or path.suffix.lower() not in TEXT_EXTENSIONS:
            continue

        data = path.read_bytes()
        if is_valid_utf8(data):
            already_utf8 += 1
            continue

        try:
            text = data.decode("cp1251")
        except UnicodeDecodeError:
            skipped += 1
            print(f"skip: {path.relative_to(root)}", file=sys.stderr)
            continue

        path.write_bytes(text.encode("utf-8"))
        converted += 1

    print(f"converted={converted} already_utf8={already_utf8} skipped={skipped}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

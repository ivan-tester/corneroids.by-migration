#!/usr/bin/env bash
set -euo pipefail
ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
OUT_DIR="$ROOT_DIR/.local_migration/mysql-init"
mkdir -p "$OUT_DIR"
gzip -dc "$ROOT_DIR/db.sql.gz" > "$OUT_DIR/001-db.sql"
echo "Prepared $OUT_DIR/001-db.sql"

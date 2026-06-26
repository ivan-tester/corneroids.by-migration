#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "$0")/.."

source_dir="www"
target_dir="www_utf8"
target_db="corneroids_utf8"
tmp_dir=".tmp"
dump_cp1251="$tmp_dir/corneroids_cp1251.sql"
dump_utf8="$tmp_dir/corneroids_utf8_import.sql"

mkdir -p "$tmp_dir"
mkdir -p "$target_dir"
find "$target_dir" -mindepth 1 -maxdepth 1 -exec rm -rf -- {} +

if command -v rsync >/dev/null 2>&1; then
  rsync -a --exclude='engine/cache/*' --exclude='backup/*' "$source_dir/" "$target_dir/"
else
  cp -a "$source_dir/." "$target_dir/"
  rm -rf "$target_dir/engine/cache"/* "$target_dir/backup"/* 2>/dev/null || true
fi

python3 scripts/convert-files-to-utf8.py "$target_dir"

perl -0pi -e "s/define \\(\"DBNAME\", \"corneroids\"\\);/define (\"DBNAME\", \"$target_db\");/g; s/define \\(\"COLLATE\", \"cp1251\"\\);/define (\"COLLATE\", \"utf8mb4\");/g" \
  "$target_dir/engine/data/dbconfig.php"

perl -0pi -e "s/'charset' => 'windows-1251'/'charset' => 'utf-8'/g" \
  "$target_dir/engine/data/config.php"

find "$target_dir/language" -name '*.lng' -type f -print0 | xargs -0 perl -0pi -e \
  "s/'charset'(\\s*=>\\s*)[\"']windows-1251[\"']/'charset'\$1\"utf-8\"/g"

docker compose exec -T db mariadb-dump \
  -uroot -proot \
  --default-character-set=cp1251 \
  --skip-set-charset \
  --no-tablespaces \
  corneroids > "$dump_cp1251"

{
  printf "SET NAMES cp1251;\n"
  printf "DROP DATABASE IF EXISTS \`%s\`;\n" "$target_db"
  printf "CREATE DATABASE \`%s\` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n" "$target_db"
  printf "USE \`%s\`;\n" "$target_db"
  perl -pe '
    s/DEFAULT CHARSET=cp1251 COLLATE=cp1251_general_ci/DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci/g;
    s/CHARSET=cp1251/CHARSET=utf8mb4/g;
    s/COLLATE=cp1251_general_ci/COLLATE=utf8mb4_unicode_ci/g;
  ' "$dump_cp1251"
} > "$dump_utf8"

docker compose exec -T db mariadb -uroot -proot < "$dump_utf8"

docker compose exec -T db mariadb -uroot -proot -e \
  "GRANT ALL PRIVILEGES ON $target_db.* TO 'corneroids'@'%'; FLUSH PRIVILEGES;"

mkdir -p "$target_dir/engine/cache/system"

chmod -R u+rwX,g+rwX,o+rwX \
  "$target_dir/engine/cache" \
  "$target_dir/engine/data" \
  "$target_dir/backup" \
  "$target_dir/uploads" \
  "$target_dir/upload_forum/cache" \
  "$target_dir/upload_forum/logs" \
  "$target_dir/upload_forum/uploads" 2>/dev/null || true

docker compose exec -T db mariadb -uroot -proot -e \
  "SELECT COUNT(*) AS tables_count FROM information_schema.tables WHERE table_schema='$target_db'; SELECT COUNT(*) AS posts FROM $target_db.dle_post;"

echo "UTF-8 copy is ready: $target_dir + database $target_db"

#! /bin/sh
set -euo pipefail

echo $(printenv)

if [ "${BRANCH:-}" = "staging" ]; then
    echo "Not cloning branch on staging"
    exit 0
fi

SRC_DB="db_staging"
DST_DB="db_${BRANCH}"
MYSQL_ROOT_USER="${DB_ROOT_USER:-root}"

if [ -z "$MYSQL_ROOT_PWD" ]; then
  echo "MYSQL_ROOT_PWD is not set."
  exit 1
fi

echo "Cloning $SRC_DB -> $DST_DB (host: $DB_HOST)"

# recreate destination db
mariadb --skip-ssl -h "$DB_HOST" -P "$DB_PORT" -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PWD" \
  -e "DROP DATABASE IF EXISTS \`$DST_DB\`; CREATE DATABASE \`$DST_DB\`;"

# dump + restore
mariadb-dump --skip-ssl -h "$DB_HOST" -P "$DB_PORT" -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PWD" "$SRC_DB" \
  | mariadb --skip-ssl -h "$DB_HOST" -P "$DB_PORT" -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PWD" "$DST_DB"

mariadb --skip-ssl -h "$DB_HOST" -P "$DB_PORT" -u"$MYSQL_ROOT_USER" \
   -p"$MYSQL_ROOT_PWD" -e \
   "GRANT ALL PRIVILEGES ON $DST_DB.* TO '$DB_USERNAME'@'%';"

echo "Done."
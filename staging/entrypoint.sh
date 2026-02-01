#!/usr/bin/env bash
set -euo pipefail

# Make a safe branch name for DB naming
BRANCH="${COOLIFY_BRANCH//[\"\/]/_}"

# Only override if COOLIFY_BRANCH is set (optional safety)
if [ -z "${DB_DATABASE:-}" ]; then
  echo "Setting DB_DATABASE"
  export DB_DATABASE="db_${BRANCH}"
fi

exec "$@"
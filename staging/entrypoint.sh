#!/usr/bin/env bash
set -euo pipefail

# Make a safe branch name for DB naming
BRANCH="$(echo "$COOLIFY_BRANCH" | tr -d '"' | tr '/' '_')"

export BRANCH
if [ -z "${DB_DATABASE:-}" ]; then
  echo "Setting DB_DATABASE"
  export DB_DATABASE="db_${BRANCH}"
fi

exec "$@"
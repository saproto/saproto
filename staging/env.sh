# /var/www/html/staging/env.sh
# sourced automatically by sh when ENV is set

set -eu

# Only compute BRANCH if COOLIFY_BRANCH exists and BRANCH isn't already set
if [ -n "${COOLIFY_BRANCH:-}" ] && [ -z "${BRANCH:-}" ]; then
  BRANCH="$(printf '%s' "$COOLIFY_BRANCH" | tr -d '"' | tr '/' '_')"
  export BRANCH
fi

# Only set DB_DATABASE if we have a branch and it's not already set
if [ -n "${BRANCH:-}" ] && [ -z "${DB_DATABASE:-}" ]; then
  export DB_DATABASE="db_${BRANCH}"
fi
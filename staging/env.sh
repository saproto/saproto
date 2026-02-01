# /var/www/html/staging/env.sh
# sourced automatically by sh when ENV is set

set -eu

echo "Sourcing staging/env.sh"

# Only compute BRANCH if COOLIFY_BRANCH exists and BRANCH isn't already set
if [ -n "${COOLIFY_BRANCH:-}" ] && [ -z "${BRANCH:-}" ]; then
  BRANCH="$(printf '%s' "$COOLIFY_BRANCH" | tr -d '"' | tr '/' '_')"
  echo "Setting BRANCH to '$BRANCH'"
  export BRANCH
fi

# Only set DB_DATABASE if we have a branch and it's not already set
if [ -n "${BRANCH:-}" ] && [ -z "${DB_DATABASE:-}" ]; then
  echo "Setting DB_DATABASE to 'db_${BRANCH}'"
  export DB_DATABASE="db_${BRANCH}"
fi
#!/usr/bin/env bash

echo "Starting update...";

# Enable maintenance mode.
php artisan down

# Pull the new data.
git pull

# By default we update dependencies, but we can disable them.
if [ "$1" == --no-deps ] || [ "$2" == --no-deps ]; then
  echo "Not updateing dependencies.";
else
  composer install
  npm install
fi

# Always clear the cache.
php artisan cache:clear

# Generate all CSS and JS
gulp

# Should we update permissions?
if [ "$1" == --no-permissions ] || [ "$2" == --no-permissions ]; then
  echo "Not fixing permissions.";
else
  chmod -R ug+rwx storage bootstrap/cache
fi

# Do migrations.
php artisan migrate
php artisan app:migrate --no-confirmation

# Add necessary roles.
php artisan app:generateroles

# Disable maintenance mode.
php artisan up

# Notify end
echo "Done!";

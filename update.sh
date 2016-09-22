#!/usr/bin/env bash

echo "Starting update...";

# Enable maintenance mode.
php artisan down

# Always clear the cache.
php artisan cache:clear

# Pull the new data.
git pull

# Updating composer dependencies.
composer install

# Do migrations.
php artisan migrate

# Add necessary roles.
php artisan proto:generateroles

# Update bower dependencies.
if [ "$1" == --no-deps ] || [ "$2" == --no-deps ]; then
  echo "Not updating bower dependencies.";
else
  bower install
fi

# Fancy artisan stuff for the IDE.
php artisan clear-compiled
php artisan ide-helper:generate
php artisan ide-helper:models --nowrite
php artisan ide-helper:meta

# Optimize application.
php artisan optimize

# Reload worker queues.
php artisan queue:restart

# Disable maintenance mode.
php artisan up

# Notify end
echo "Done!";

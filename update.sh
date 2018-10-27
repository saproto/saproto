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

# Fancy artisan stuff for the IDE.
php artisan clear-compiled
php artisan ide-helper:generate
php artisan ide-helper:models --nowrite
php artisan ide-helper:meta

# Reload worker queues.
php artisan queue:restart

# Update packages.
npm install

# Generate assets
grunt

# Disable maintenance mode.
php artisan up

# Notify end
echo "Done!";

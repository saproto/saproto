#!/usr/bin/env bash

echo "Starting update...";

# Enable maintenance mode.
php artisan down

# Always clear the cache.
php artisan cache:clear

# Pull the new data.
git pull

# By default we update dependencies, but we can disable them.
if [ "$1" == --no-deps ] || [ "$2" == --no-deps ]; then
  echo "Not updateing dependencies.";
else
  composer install
fi

# Should we update permissions?
if [ "$1" == --no-permissions ] || [ "$2" == --no-permissions ]; then
  echo "Not fixing permissions.";
else
  chmod -R ug+rwx storage bootstrap/cache
fi

# Do migrations.
php artisan migrate

# Add necessary roles.
php artisan proto:generateroles

# Fancy artisan stuff for the IDE.
rm .phpstorm.meta.php
rm _ide_helper.php
rm _ide_helper_models.php

php artisan ide-helper:generate
php artisan ide-helper:models --nowrite
php artisan ide-helper:meta

# Optimize application.
php artisan optimize

# Disable maintenance mode.
php artisan up

# Notify end
echo "Done!";

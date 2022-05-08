#!/usr/bin/env bash

chown -R www-data:www-data storage;
chown -R www-data:www-data bootstrap/cache;
chmod -R 755 storage;
chmod -R 755 bootstrap/cache;

# Notify end
echo "Fixed directory permissions!";

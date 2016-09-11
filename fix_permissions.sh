#!/usr/bin/env bash

echo "Starting fix...";

chgrp -R www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

# Notify end
echo "Done!";

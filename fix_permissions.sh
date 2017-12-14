#!/usr/bin/env bash

echo "Starting fix...";

chmod -R 755 .
chmod -R 700 .env .git storage

# Notify end
echo "Done!";

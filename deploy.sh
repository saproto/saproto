#!/bin/bash

# First verify the checksum between uploaded and live code to see if deployment is necessary.
CURRENT_CHECKSUM=$(cat live/checksum.txt)
if [ $? -ne 0 ]; then
  echo "No current checksum found. Assuming deployment is necessary."
  CURRENT_CHECKSUM="NoCurrentChecksum"
fi

NEW_CHECKSUM=$(cat uploads/checksum.txt)
if [ $? -ne 0 ]; then
  echo "Can't find new checksum. Should be there though. Exiting."
  exit 1
fi

if [ "$CURRENT_CHECKSUM" == "$NEW_CHECKSUM" ]; then
  echo "Checksums are identical, no deployment necessary."
  exit 0
fi

# Clean-up
rm -rf previous_build

# Remove old storage symlink
rm live/storage

# Prepare new build
echo "Unzipping new build..."
unzip -q uploads/build.zip -d new_build
echo "Shuffling files..."
cp uploads/checksum.txt new_build
cp environment/.env new_build
echo "Bringing down builds..."
(cd new_build && php artisan down)
(cd live && php artisan down)

echo "Rotating builds..."
mv live previous_build
mv new_build live

echo "Symlinking storage..."
rm -rf live/storage
ln -s /path \
  /other/path

echo "Bringing new live build up..."
(cd live && php artisan migrate --force && php artisan up)

echo "Done!"

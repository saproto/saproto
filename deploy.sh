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
echo "Removing old build"
rm -rf previous_build

# Prepare new build
echo "Unzipping new build..."
unzip -q uploads/build.zip -d new_build
echo "Shuffling files..."
cp uploads/checksum.txt new_build
cp environment/.env new_build
echo "Fixing file permissions"
chmod +x new_build/vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64
chmod +x new_build/vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64
echo "Symlinking storage..."
ln -s /actual/path \
  /symlinked/path
echo "Bringing down builds..."
(cd new_build && php artisan down)
(cd live && php artisan down)

echo "Rotating builds..."
mv live previous_build
mv new_build live

echo "Bringing new live build up..."
(cd live && php artisan migrate --force && php artisan up)

echo "Done!"

#! /bin/bash

set -e pipefail

# Source the env file
export $(cat .env | grep -v '^#' | xargs)

# The garage command to interact with the garage container
GARAGE="docker exec -it garage /garage"

# Get the garage ID
GARAGE_ID="$($GARAGE status | awk '($1 ~ /^[0-9a-f]{16}$/){print $1; exit}')"

echo "Garage ID found: $GARAGE_ID"

LAYOUT_EXISTS="$($GARAGE layout show | grep -c 'dc1')"
LAYOUT_EXISTS="$($GARAGE layout show | grep -c 'dc1' || true)"

# Create layout if it doesn't exist
if [ "$LAYOUT_EXISTS" -eq "0" ]; then
    echo "Creating layout 'dc1'..."
    # Assign layout to the garage
    $GARAGE layout assign -z dc1 -c 1G $GARAGE_ID > /dev/null
    $GARAGE layout apply --version 1 > /dev/null
fi



# Create buckets
echo "Creating buckets..."

# Temporarily disable exit on error to check for bucket existence
set +e
$GARAGE bucket info "$GARAGE_BUCKET" > /dev/null
PRIVATE_BUCKET_EXISTS=$?

$GARAGE bucket info "$GARAGE_BUCKET_PUBLIC" > /dev/null
PUBLIC_BUCKET_EXISTS=$?
set -e

# If exist code was 0; it exists
if [ "$PRIVATE_BUCKET_EXISTS" -eq "0" ]; then
    echo "Bucket $GARAGE_BUCKET already exists. Deleting..."
    $GARAGE bucket delete $GARAGE_BUCKET --yes > /dev/null
fi

if [ "$PUBLIC_BUCKET_EXISTS" -eq "0" ]; then
    echo "Bucket $GARAGE_BUCKET_PUBLIC already exists. Deleting..."
    $GARAGE bucket delete $GARAGE_BUCKET_PUBLIC --yes > /dev/null
fi

# Delete all other keys
KEY_IDS="$($GARAGE key list | awk '/^GK[0-9a-f]+/ {print $1}')"
for id in $($GARAGE key list | awk '/^GK[0-9a-f]+/ {print $1}'); do
    $GARAGE key delete $id --yes > /dev/null
done

# Create a new key for laravel
KEYOUTPUT=$($GARAGE key create laravel-key)
KEY_ID=$(echo "$KEYOUTPUT"     | grep -m1 "Key ID:"      | awk -F': *' '{print $2}')
KEY_NAME=$(echo "$KEYOUTPUT"   | grep -m1 "Key name:"    | awk -F': *' '{print $2}')
SECRET_KEY=$(echo "$KEYOUTPUT" | grep -m1 "Secret key:"  | awk -F': *' '{print $2}')

echo
echo "Add the following to your .env file:"
echo "GARAGE_KEY=$KEY_ID"
echo "GARAGE_SECRET=$SECRET_KEY"
echo 


# Create buckets and set permissions
$GARAGE bucket create $GARAGE_BUCKET > /dev/null
$GARAGE bucket allow --read --write --owner $GARAGE_BUCKET --key laravel-key > /dev/null
echo "Created bucket: $GARAGE_BUCKET"


$GARAGE bucket create $GARAGE_BUCKET_PUBLIC > /dev/null
$GARAGE bucket allow --read --write --owner $GARAGE_BUCKET_PUBLIC --key laravel-key > /dev/null
# Allow public read access
$GARAGE bucket website --allow $GARAGE_BUCKET_PUBLIC > /dev/null
echo "Created bucket: $GARAGE_BUCKET_PUBLIC"

echo "Garage setup completed."
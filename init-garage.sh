BUCKET_NAME="laravel"
NODE_ID=$(docker compose exec garage /garage status 2>&1 | grep 'Connection established' | awk '{print $NF}')
docker compose exec garage /garage layout assign -z dc1 -c 1G $NODE_ID
docker compose exec garage /garage layout apply --version 1
docker compose exec garage /garage bucket create $BUCKET_NAME
docker compose exec garage /garage key create $BUCKET_NAME
docker compose exec garage /garage bucket allow --read --write --owner $BUCKET_NAME --key $BUCKET_NAME
docker compose exec garage /garage bucket website --allow $BUCKET_NAME
docker compose exec garage /garage bucket info $BUCKET_NAME

#!/usr/bin/env bash

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS protube;
    GRANT ALL PRIVILEGES ON \`protube%\`.* TO '$MYSQL_USER'@'%';
EOSQL

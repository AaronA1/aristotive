#!/usr/bin/env bash

# copy env
FILE='.env'
if [ -f $FILE ]; then
   echo "File $FILE exists."
else
   echo "File $FILE does not exist, copying .env.example."
   cp .env.example .env
fi

# build container & install packages
./vendor/bin/sail up -d
docker exec -it aristotive-app-1 composer install
docker exec -it aristotive-app-1 php artisan key:generate
docker exec -it aristotive-app-1 php artisan migrate:fresh --seed

docker exec -it aristotive-app-1 npm install
docker exec -it aristotive-app-1 npm run dev

echo "Open the app: http://0.0.0.0"
IP=$(ipconfig getifaddr en0)
echo "Access on the same LAN with this IP & Port: ${IP}:80"



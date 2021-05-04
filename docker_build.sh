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
docker-compose up --build --remove-orphans -d
docker-compose exec aristotive-app composer install
docker-compose exec aristotive-app php artisan key:generate
docker-compose exec aristotive-app php artisan migrate:fresh --seed

# npm
docker-compose run aristotive-node npm install
docker-compose run aristotive-node npm run dev

echo "Open the app: http://localhost:8084"
IP=$(ipconfig getifaddr en0)
echo "Students can connect via this address: ${IP}:8084"



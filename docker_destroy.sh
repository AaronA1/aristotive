#!/usr/bin/env bash
docker-compose down --volumes
docker rmi aristotive-app aristotive-web

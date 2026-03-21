#!/bin/bash
cd /home/ubuntu/.openclaw/workspace/trip-sorter
docker run --rm -v $(pwd):/app -w /app php:8.3-cli composer update --no-interaction

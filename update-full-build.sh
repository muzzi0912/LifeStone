#!/bin/bash

echo "Updating ERP backend-api from git repo...
"
git pull

echo "

Now updating composer autoload...
"
composer dump-autoload

echo "

Now executing possible migrations...
"
php artisan migrate

echo "

Now moving to frontend...
"
cd ../Life-Stone-Website

echo "

Updating ERP frontend from git repo...
"
git pull

echo "

Building distribution for live server: lifeStoneLive...
"
npm run build-lifeStoneLive

echo "

Build complete! moving back to backend...
"
cd ../LifeStone

echo "

Removing old distribution files...
"
cd public
rm -rf static
rm index.html
rm asset-manifest.json
rm service-worker.js
rm precache-*.js
cd ..

echo "

Copying new distribution files...
"
cp -a ../Life-Stone-Website/build/. ./public/

echo "

FINISHED!!!
"

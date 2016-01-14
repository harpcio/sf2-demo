#!/bin/bash

# -------------------
# Setup script
#
# To install into production environment, run:
#   ./deploy.sh prod
# -------------------

# make sure it's deleteable
sudo chmod -R 777 app/cache app/logs web/uploads
chmod 644 app/cache/.gitkeep app/logs/.gitkeep

if [ ! -f "composer.phar" ]; then
    # get latest composer.phar
    curl -s http://getcomposer.org/installer | /usr/bin/php
fi

if [ "$1" == "prod" ]; then
    echo "Prepping for prod:"

    # Install dependencies
    echo "Running composer install..."
    /usr/bin/php composer.phar install --no-dev --no-scripts --optimize-autoloader

    echo "Clearing cache..."
    /usr/bin/php app/console cache:clear --env=prod

    echo "Installing assets..."
    #/usr/bin/php app/console fos:js-routing:dump -e=prod
    /usr/bin/php app/console assets:install --env=prod
    /usr/bin/php app/console assetic:dump --env=prod
else
    echo "Running composer install..."
    /usr/bin/php composer.phar install

    echo "Refreshing for dev..."
    /usr/bin/php app/console cache:clear

    echo "Installing assets..."
    #/usr/bin/php app/console fos:js-routing:dump
    /usr/bin/php app/console assets:install --symlink
    /usr/bin/php app/console assetic:dump
fi


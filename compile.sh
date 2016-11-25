#!/bin/bash
set -e

# Install composer
curl -0 composer-setup.php https://getcomposer.org/installer
if [ "$(sha384sum composer-setup.php | cut -d" " -f1)" != "$(curl https://composer.github.io/installer.sig)" ]; then
    echo "Invalid signature"
    exit 1
fi
php composer-setup.php --install-dir=bin --filename=composer
rm composer-setup.php

# Get the composer dependencies
cd src
../bin/composer install
cd ..

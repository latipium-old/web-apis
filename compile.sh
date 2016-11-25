#!/bin/bash
set -e

# Get the composer dependencies
cd src
composer install
cd ..

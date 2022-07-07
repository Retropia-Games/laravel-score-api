#!/bin/bash
# Thanks to https://dev.to/kenean50/automate-your-laravel-app-deployment-with-github-actions-2g7j

set -e
if [ ! -f composer.json ]; then
    echo "Please run me from the root directory of Laravel! 😢"
    exit 1
else
    echo "Running deployment! 🥹"
fi

PHP_PATH="/usr/local/bin/php81"
COMPOSER_URL="https://getcomposer.org/download/latest-stable/composer.phar"
COMPOSER_PATH="./scripts/composer.phar"
COMPOSER_COMMAND="${PHP_PATH} ${COMPOSER_PATH}"

# Get Composer
wget ${COMPOSER_URL} -N -q -P "./scripts/"
chmod +x ${COMPOSER_PATH}

# Enter maintenance mode or return true
# if already is in maintenance mode
(${PHP_PATH} artisan down) || true

# Pull the latest version of the app
git stash
git stash drop
git pull origin production

# Install composer dependencies
${COMPOSER_COMMAND} install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Clear the old cache
${PHP_PATH} artisan clear-compiled

# Recreate cache
${PHP_PATH} artisan optimize

# Run database migrations
${PHP_PATH} artisan migrate --force

${PHP_PATH} artisan config:cache
${PHP_PATH} artisan route:cache
${PHP_PATH} artisan view:cache

# Exit maintenance mode
${PHP_PATH} artisan up

echo "Deployment finished! ✔️"

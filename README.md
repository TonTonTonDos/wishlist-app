<p align="center">
    <h1 align="center">Wish list project</h1>



A project to create a wish list



INSTALLATION
------------

### Install with Docker

Clone repository

    git clone https://github.com/TonTonTonDos/wishlist-app

Move to directory whislist-app

    cd wishlist-app

Start docker container

    docker-compose up --build

If /usr/bin/env: 'php\r': No such file or directory appears:

    docker-compose exec php /bin/bash
    find /var/www -type f -name "*.sh" -exec dos2unix {} \; \
    && find /var/www -type f -name "yii" -exec dos2unix {} \; \
    && chmod +x /var/www/yii

Install composer

    docker-compose exec php /bin/bash
    composer install --no-interaction && composer dump-autoload --optimize

Run migrations 

    docker-compose exec php /bin/bash
    ./yii migrate

You can then access the application through the following URL:

    http://127.0.0.1

You can then access the pgAdmin through the following URL:

    http://127.0.0.1:8080

default login: admin@example.com
default password: admin

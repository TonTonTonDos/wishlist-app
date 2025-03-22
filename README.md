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

Run migrations 

    docker-compose exec php /var/www/yii migrate

You can then access the application through the following URL:

    http://127.0.0.1

You can then access the pgAdmin through the following URL:

    http://127.0.0.1:8080

default login: admin@example.com
default password: admin

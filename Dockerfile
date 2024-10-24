FROM php:8.2-cli
COPY . /usr/src/app
WORKDIR /usr/src/app
CMD [ "php", "index.php" ]

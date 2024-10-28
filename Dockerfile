FROM php:8.3-cli
RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		libwebp-dev \
		libxpm-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --with-xpm \
	&& docker-php-ext-install -j$(nproc) gd
COPY . /usr/src/app
WORKDIR /usr/src/app
EXPOSE 9696
LABEL org.opencontainers.image.source=https://github.com/staifa/php-bandwidth-hero-proxy
CMD [ "php", "-S", "0.0.0.0:8000", "./index.php" ]

FROM mtmacdonald/docker-laravel:1.4.0
COPY nginx/nginx.conf /etc/nginx/sites-available/default
COPY .env.docker /share/.env
WORKDIR /share

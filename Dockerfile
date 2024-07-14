# Создайте аргументы для расширений PHP и пакетов PECL, которые нам нужно установить.
# Это упрощает установку пакетов,
# так как мы должны установить их в нескольких местах.
# Это помогает сохранить Dockerfiles DRY -> https://bit.ly/dry-code
# Вы можете увидеть список необходимых расширений для Laravel здесь: https://laravel.com/docs/8.x/deployment#server-requirements
ARG PHP_EXTS="bcmath ctype fileinfo mbstring pdo pdo_mysql pdo_pgsql dom pcntl gd zip opcache"
ARG PHP_PECL_EXTS="redis"
ARG PHP_EXT_DEPS="freetype-dev libjpeg-turbo-dev libwebp-dev libpng-dev libpq-dev libzip-dev zip"
ARG PHP_EXT_CONF="gd --enable-gd --with-freetype --with-jpeg --with-webp"
ARG PHP_EXT_ZIP_CONF="zip"

# Нам нужно создать базу Composer для повторного использования установленных нами пакетов.
FROM composer:2.5.5 as composer_base

# Нам нужно объявить, что мы хотим использовать аргументы на этом шаге сборки
ARG PHP_EXTS
ARG PHP_PECL_EXTS
ARG PHP_EXT_DEPS
ARG PHP_EXT_CONF
ARG PHP_EXT_ZIP_CONF

# Во-первых, создайте каталог приложения и несколько вспомогательных каталогов для скриптов и т.п.
RUN mkdir -p /opt/apps/app-source /opt/apps/app-source/bin

# Далее устанавливаем наш рабочий каталог
WORKDIR /opt/apps/app-source

RUN apk add --no-cache ${PHP_EXT_DEPS}

# Нам нужно создать группу композитора и пользователя, а также создать для него домашний каталог,
# чтобы сохранить остальную часть нашего образа в безопасности,
# И не запускать случайно вредоносные скрипты
RUN addgroup -S composer \
    && adduser -S composer -G composer \
    && chown -R composer /opt/apps/app-source \
    && apk add --virtual build-dependencies --no-cache ${PHPIZE_DEPS} ${PHP_EXT_DEPS} openssl ca-certificates libxml2-dev oniguruma-dev \
    && docker-php-ext-configure ${PHP_EXT_CONF} \
    && docker-php-ext-configure ${PHP_EXT_ZIP_CONF} \
    && docker-php-ext-install -j$(nproc) ${PHP_EXTS} \
    && pecl install ${PHP_PECL_EXTS} \
    && docker-php-ext-enable ${PHP_PECL_EXTS} ${PHP_EXT_ENABLE} \
    && apk del build-dependencies

# Далее мы хотим переключиться на пользователя композитора перед запуском установки.
# Это очень важно, поэтому любые дополнительные скрипты, которые хочет запустить композитор,
# у вас нет доступа к корневой файловой системе.
# Это особенно важно при установке пакетов из непроверенных источников.
USER composer

# Копируем наши файлы зависимостей.
# Мы хотим пока оставить остальную часть кода,
# чтобы Docker мог создать кеш этого слоя,
# и перестраивать только при изменении зависимостей нашего приложения.
COPY --chown=composer composer.json composer.lock ./

# Установите все зависимости без запуска каких-либо сценариев установки.
# Мы пропускаем скрипты, так как кодовая база еще не скопирована и скрипт, скорее всего, не работает,
# как `php artisan` пока доступен.
# Это также помогает нам кэшировать предыдущие прогоны и слои.
# Пока comoser.json и composer.lock не изменяются, установка будет кэшироваться.
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Скопируйте наш фактический исходный код, чтобы мы могли запустить нужные нам сценарии установки
# На данный момент все пакеты PHP установлены,
# и все, что осталось сделать, это запустить любые сценарии установки, которые зависят от кодовой базы
COPY --chown=composer . .

# Теперь, когда кодовая база и пакеты доступны,
# мы можем запустить установку еще раз, и пусть она запускает любые сценарии установки.
RUN composer install --no-dev --prefer-dist


# Для frontend мы хотим получить все файлы Laravel,
# и запускаем production компиляцию
FROM node:18.17.1 as frontend

# Нам нужно скопировать файлы Laravel,
# чтобы сделать все доступным для компиляции внешнего интерфейса.
COPY --from=composer_base /opt/apps/app-source /opt/apps/app-source

WORKDIR /opt/apps/app-source

# Мы хотим установить все пакеты NPM
# и скомпилировать их для производства
RUN npm install && npm run build


# Для запуска таких вещей, как миграции и задания в очереди,
# нам нужен контейнер CLI.
# Он содержит все пакеты Composer,
# и только основные "вещи" CLI для запуска команд,
# будь то очереди, миграции, тинкер и т.д.
FROM php:8.2.6-alpine as cli

# Нам нужно объявить, что мы хотим использовать аргументы на этом шаге сборки
ARG PHP_EXTS
ARG PHP_PECL_EXTS
ARG PHP_EXT_DEPS
ARG PHP_EXT_CONF
ARG PHP_EXT_ZIP_CONF

WORKDIR /opt/apps/app-source

RUN apk add --no-cache ${PHP_EXT_DEPS}

RUN cd /usr/local/etc/php/conf.d/ && \
  echo "memory_limit = -1" >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini && \
  echo "max_execution_time = 0" >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

# Нам нужно установить некоторые требования в наш образ,
# используется для компиляции наших расширений PHP, а также для установки самих расширений.
# Вы можете увидеть список необходимых расширений для Laravel здесь: https://laravel.com/docs/8.x/deployment#server-requirements
RUN apk add --virtual build-dependencies --no-cache ${PHPIZE_DEPS} ${PHP_EXT_DEPS} openssl ca-certificates libxml2-dev oniguruma-dev \
    && docker-php-ext-configure ${PHP_EXT_CONF} \
    && docker-php-ext-configure ${PHP_EXT_ZIP_CONF} \
    && docker-php-ext-install -j$(nproc) ${PHP_EXTS} \
    && pecl install ${PHP_PECL_EXTS} \
    && docker-php-ext-enable ${PHP_PECL_EXTS} ${PHP_EXT_ENABLE} \
    && apk del build-dependencies

# Далее мы должны скопировать нашу кодовую базу из нашей начальной сборки, которую мы установили на предыдущем этапе.
COPY --from=composer_base /opt/apps/app-source /opt/apps/app-source
COPY --from=frontend /opt/apps/app-source/public /opt/apps/app-source/public


# Нам нужен этап, который содержит FPM для фактического запуска и обработки запросов к нашему PHP-приложению.
FROM php:8.2.6-fpm-alpine as fpm_server

# Нам нужно объявить, что мы хотим использовать аргументы на этом шаге сборки
ARG PHP_EXTS
ARG PHP_PECL_EXTS
ARG PHP_EXT_DEPS
ARG PHP_EXT_CONF
ARG PHP_EXT_ZIP_CONF

WORKDIR /opt/apps/app-source

RUN apk add --no-cache ${PHP_EXT_DEPS}

RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

RUN apk add --virtual build-dependencies --no-cache ${PHPIZE_DEPS} ${PHP_EXT_DEPS} openssl ca-certificates libxml2-dev oniguruma-dev \
    && docker-php-ext-configure ${PHP_EXT_CONF} \
    && docker-php-ext-configure ${PHP_EXT_ZIP_CONF} \
    && docker-php-ext-install -j$(nproc) ${PHP_EXTS} \
    && pecl install ${PHP_PECL_EXTS} \
    && docker-php-ext-enable ${PHP_PECL_EXTS} ${PHP_EXT_ENABLE} \
    && apk del build-dependencies

# Поскольку FPM использует пользователя www-data при запуске нашего приложения,
# нам нужно убедиться, что мы также используем этого пользователя при запуске,
# чтобы наш пользователь "владел" приложением при запуске
USER  www-data

# Мы должны скопировать нашу кодовую базу из нашей начальной сборки, которую мы установили на предыдущем этапе.
COPY --from=composer_base --chown=www-data /opt/apps/app-source /opt/apps/app-source
COPY --from=frontend --chown=www-data /opt/apps/app-source/public /opt/apps/app-source/public

# Мы хотим кэшировать события, маршруты и представления, чтобы не пытаться их записывать, когда находимся в Kubernetes.
# Сборки Docker должны быть максимально неизменяемыми, и это избавляет от большей части написания живого приложения.
RUN php artisan event:cache && \
    php artisan route:cache && \
    php artisan view:cache


# Нам нужен контейнер nginx, который может передавать запросы в наш контейнер FPM,
# а также обслуживать любой статический контент.
FROM nginx:1.20-alpine as web_server

WORKDIR /opt/apps/app-source

# Нам нужно добавить наш шаблон NGINX в контейнер для запуска,
# и конфигурация.
COPY docker/template.nginx.conf /etc/nginx/templates/default.conf.template

# Скопируйте ТОЛЬКО публичный каталог нашего проекта.
# Здесь будут жить все статические ресурсы, которые нам будет обслуживать nginx.
COPY --from=frontend /opt/apps/app-source/public /opt/apps/app-source/public


# Нам нужен контейнер Очередей для Laravel.
# Мы начнем с контейнера CLI в качестве основы
FROM cli as supervisord
RUN apk update && apk add --no-cache supervisor && mkdir -p var/log/supervisor

WORKDIR /opt/apps/app-source

COPY docker/supervisord.conf /etc/supervisord.conf

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]


# Нам нужен контейнер CRON для планировщика Laravel.
# Мы начнем с контейнера CLI в качестве основы,
# так как нам нужно только переопределить CMD, с которой начинается контейнер, чтобы указать на cron
FROM cli as cron

WORKDIR /opt/apps/app-source

# Мы хотим создать файл laravel.cron с настройками Laravel cron, который мы можем импортировать в crontab,
# и запустите crond в качестве основной команды на переднем плане
RUN touch laravel.cron && \
    echo "* * * * * cd /opt/apps/app-source && php artisan schedule:run" >> laravel.cron && \
    crontab laravel.cron

CMD ["crond", "-l", "2", "-f"]


# Берем основной образ эластика
FROM docker.elastic.co/elasticsearch/elasticsearch:8.9.1 as elastic

# ставим плагин с русской морфологией
RUN bin/elasticsearch-plugin install https://github.com/nickyat/elasticsearch-analysis-morphology/releases/download/8.9.1/elasticsearch-analysis-morphology-8.9.1.zip


FROM cli

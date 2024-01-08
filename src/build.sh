#!/bin/bash
#Create laravel crontab
PHP_DIR=$(command -v php);
CRON_CMD="* * * * * cd /www && $PHP_DIR artisan schedule:run >> /dev/null 2>&1";
CRON_PATH="/var/spool/cron/crontabs/root";

crontab -l | grep -q "$CRON_CMD"  && \
echo 'crontab exists' || echo "$CRON_CMD" >> $CRON_PATH;

chmod 600 $CRON_PATH;
chown root:crontab $CRON_PATH;
service cron restart;

#Auto run after restart docker workspace
npm install cross-env && \
npm install && \
npm install --save vue && \
npm run prod && \
composer install && \
composer dumpautoload && \
php artisan migrate --force && \
#php artisan db:seed --force && \
php artisan key:generate --force && \
php artisan cache:clear && \
php artisan config:clear && \
php artisan event:clear && \
php artisan event:clear && \
php artisan optimize:clear && \
php artisan view:clear && \
composer dumpautoload && \
chown -R 33:33 /www && \
chmod -R 777 /www
php artisan queue:listen database --queue=\
upload-video-to-cloudflare \
queue-send-mail-template \
--timeout=1200 --memory=128 --sleep=3 --tries=3 --verbose

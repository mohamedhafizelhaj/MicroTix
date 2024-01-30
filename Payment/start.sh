#!/usr/bin/env bash

# run the migrations and start the gRPC workers through supervisor
php /var/www/html/artisan migrate && supervisord -n -c /etc/supervisor/supervisord.conf
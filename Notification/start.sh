#!/usr/bin/env bash

CONF_FILE='/etc/rabbitmqadmin/rabbitmqadmin.conf'
SECTION='host_normal'
QUEUE='notifications'
EXCHANGE='notifications_direct'

# get rabbitmqadmin cli tool so we can use it to create
# a queue, an exchange, an a bindinbg, so we can push
# event messages

wget -qO /usr/local/bin/rabbitmqadmin \
    https://raw.githubusercontent.com/rabbitmq/rabbitmq-server/v3.12.x/deps/rabbitmq_management/bin/rabbitmqadmin \
    && chmod +x /usr/local/bin/rabbitmqadmin

# create our queue, if it doesn't exist,
rabbitmqadmin -q --config "$CONF_FILE" -N "$SECTION" declare queue name="$QUEUE" durable=true || \
    rabbitmqadmin --config "$CONF_FILE" -N "$SECTION" declare queue name="$QUEUE" durable=true

# our exchange, if it doesn't exist,
rabbitmqadmin -q --config "$CONF_FILE" -N "$SECTION" declare exchange name="$EXCHANGE" type=direct || \
    rabbitmqadmin --config "$CONF_FILE" -N "$SECTION" declare exchange name="$EXCHANGE" type=direct

# and the binding, if it doesn't exist
rabbitmqadmin -q --config "$CONF_FILE" -N "$SECTION" declare binding source="$EXCHANGE" destination="$QUEUE" || \
    rabbitmqadmin --config "$CONF_FILE" -N "$SECTION" declare binding source="$EXCHANGE" destination="$QUEUE"

# lastly, run the migrations and start the gRPC workers through supervisor
php /var/www/html/artisan migrate && supervisord -n -c /etc/supervisor/supervisord.conf
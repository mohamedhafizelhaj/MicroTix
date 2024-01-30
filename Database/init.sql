CREATE DATABASE IF NOT EXISTS api_gateway;
GRANT ALL PRIVILEGES ON api_gateway.* TO 'mohamedhafizelhaj'@'%';

CREATE DATABASE IF NOT EXISTS event_management;
GRANT ALL PRIVILEGES ON event_management.* TO 'mohamedhafizelhaj'@'%';

CREATE DATABASE IF NOT EXISTS notifications;
GRANT ALL PRIVILEGES ON notifications.* TO 'mohamedhafizelhaj'@'%';

CREATE DATABASE IF NOT EXISTS payment;
GRANT ALL PRIVILEGES ON payment.* TO 'mohamedhafizelhaj'@'%';

CREATE DATABASE IF NOT EXISTS tickets;
GRANT ALL PRIVILEGES ON tickets.* TO 'mohamedhafizelhaj'@'%';

FLUSH PRIVILEGES;
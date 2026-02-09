CREATE DATABASE intermodular;
CREATE USER 'laravel_user'@'%' IDENTIFIED BY 'laravel_password';
GRANT ALL PRIVILEGES ON intermodular.* TO 'laravel_user'@'%';
FLUSH PRIVILEGES;
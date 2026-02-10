---
theme: uncover
paginate: true
class:
  - lead
  - invert
size: 16:9
footer: "[practica 6.3 docker con laravel y DNS](https://www.hashbangcode.com)"
marp: true
--- 
# Practica 6.3 Cesar
---

## Índice
- [Paso 1: Configuración del Servidor DNS (BIND9) en Docker](#paso-1-configuración-del-servidor-dns-bind9-en-docker)

2. [Paso 2: Configuración de las zonas DNS](#paso-2-configuración-de-las-zonas-dns)
3. [Configuraciom maria db](#configuracion-maria-db)
4. [Archivo compose-yml](#archivo-compose-yml)
---

## Indice

5. [Pagina de prueba php](#pagina-de-prueba-php)
6. [Construir y ejecutar contenedores]( #construir-y-ejecutar-los-contenedores)
7. [Verficar base de datos](#7-verificar-la-base-de-datos)
8. [Instalacion Composer](#8-instalacion-composer)

9. [Creacion proyecto laravel](#9-creacion-proyecto-laravel)
10. [Configurar phpMyAdmin](#10-configurar-phpmyadmin)
---

Creamos la estructura de carpetas que nos falta

```bash
mkdir -p nginx/ssl
mkdir -p bind
mkdir -p bind/zones
```
---
## Paso 1: Configuración del Servidor DNS (BIND9) en Docker
---
```yml
---
services:
  nginx:
    build: ./nginx
    container_name: nginx-container
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./www/html:/var/www/html
      - ./nginx/ssl:/etc/nginx/ssl
    depends_on:
      - php
    networks:
      default:
        ipv4_address: 10.1.0.20

  php:
    build: ./php
    container_name: php-container
    expose:
      - "9000"
    volumes:
      - ./www/html:/var/www/html
    networks:
      default:
        ipv4_address: 10.1.0.30

  mariadb:
    image: mariadb:latest
    container_name: mariadb-container
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: intermodular-gestion-profesores
      MYSQL_USER: laravel_user
      MYSQL_PASSWORD: laravel_password

    volumes:
      # Volumen persistente para los datos de la base de datos
      - mariadb_data:/var/lib/mysql
      # Volumen para scripts de inicialización
      - ./mariadb:/docker-entrypoint-initdb.d
    ports:
      - "3306:3306"
    networks:
      default:
        ipv4_address: 10.1.0.40
  dns:
    image: internetsystemsconsortium/bind9:9.18
    container_name: dns-container
    ports:
      - "53:53/udp"
      - "53:53/tcp"
    volumes:
      - ./bind:/etc/bind
    restart: 'no'
    networks:
      default:
        ipv4_address: 10.1.0.10
  phpmyadmin:
    image: phpmyadmin/phpmyadmin:latest
    container_name: phpmyadmin-container
    environment:
      PMA_HOST: mariadb
      MYSQL_ROOT_PASSWORD: root_password
    ports:
      - "8081:80"
    depends_on:
      - mariadb
    networks:
      default:
        ipv4_address: 10.1.0.50 
networks:
  default:
    driver: bridge
    ipam:
      config:
        - subnet: 10.1.0.0/24
# Declaración de volúmenes persistentes
volumes:
  mariadb_data:
```
---
Ejecutamos esto para contruir la imagen ya que la modificamos

```bash
docker compose up --build
```
---
## Paso 2: Configuración de las zonas DNS

Zona directa
```bash
$TTL 86400
@       IN SOA  ns1.daw.es. root.daw.es. (
                2024083001 ; Serial
                3600       ; Refresh
                1800       ; Retry
                1209600    ; Expire
                86400      ; Minimum TTL
                )

; Nameservers
@       IN NS   ns1.daw.es.

; Registros A
ns1     IN A    10.1.0.10
www     IN A    10.1.0.20
despliegue IN A 10.1.0.20
www.despliegue IN A 10.1.0.20
```
---

---
Zona inversa
```bash
$TTL 86400
@       IN SOA  ns1.daw.es. root.daw.es. (
                2024083001 ; Serial
                3600       ; Refresh
                1800       ; Retry
                1209600    ; Expire
                86400      ; Minimum TTL
                )

; Nameservers
@       IN NS   ns1.daw.es.

; Registros PTR (Reverse DNS)
10      IN PTR  ns1.daw.es.
20      IN PTR  www.daw.es.
20      IN PTR  www.despliegue.daw.es.
20      IN PTR  despliegue.daw.es.

```

# AAXISTEST PHP8 SYMFONY 7
This repository presents the management of APIS through JWT and the implementation of the Hexagonal architecture (DDD) in Symfony 7 with php 8.2.12.

<!--suppress HtmlDeprecatedAttribute -->
<p align="center">
    <img src="public/assets/hexagon.jpg" alt="hexagon">
</p>

## What's in the environment:

- [Nginx](https://www.nginx.com/)
- [Php Fpm](https://php.net/)
- [PgAdmin](https://www.pgadmin.org/)
- [PostgreSQL](https://www.postgresql.org/)
- [Symfony](https://symfony.com/)

## Prerequisites:

- [Install Docker](https://docs.docker.com/install/)
- [Install Docker Compose](https://docs.docker.com/compose/install/)

## How to use:

- Clone the repository
- Enter the repository folder
- Run the `docker-compose up` command
  - if you want to run in background mode, run the command `docker-compose up -d`

### 🔥 Application execution

1. Install the backend dependencies: `composer install`. 
2. Run command cp .env.test .env 
3. Create database & tables with `php bin/console d:d:c` then `php bin/console make:migration`
   and `php bin/console migration:migrate` or force with `php bin/console d:s:u -f`

4. Run command php bin/console aaxis:create-user

5. Access the address `http://localhost` to access the project

 Access the address `http://localhost:8081` to access pgadmin
  - user: admin@localhost.com
  - password: admin

## Persistent data:

- postgresql data: `./docker/postgresql/dbdata`


## Comments:
The credentials are added in the frontend for simplicity purposes only.
To do: create a login screen 

## License:

[MIT](https://opensource.org/licenses/MIT)

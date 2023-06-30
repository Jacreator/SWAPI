## How to Install and Run the Project

1. ```git clone git@github.com:hanieas/Docker-Laravel.git```
2. ```cd src```
3. ```composer install```
3. Copy ```.env.example``` to ```.env```
4. ```docker-compose build```
5. ```docker compose up -d```
6. ```docker-compose exec app php artisan migrate``` 
7. You can see the project on ```127.0.0.1:8080```

## How to use PostgreSQL as a database

1. Uncomment the PostgreSQL configuration inside the ```docker-compose.yml``` including: ```db``` and ```pgamdin```
2. Copy ```.env.example``` to ```.env```
3. Change ```DB_CONNECTION``` to ```pgsql```
4. Change ```DB_PORT``` to ```5432```
5. Open the ```pgAdmin``` on ```127.0.0.1:5050```
6. login Details on ```127.0.0.1:5050```
    - email: "jambone.james82@gmail.com"
    - password: password
7. And to create a new Server instance
   - username: postgres
   - password: password

## How to run Laravel Commands with Docker Compose

1. ```cd src```
2. ```docker-compose exec app php artisan {your command}``` 
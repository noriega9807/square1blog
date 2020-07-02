# Square1 Blog

Steps for running the project.

  - Rename .env.example to .env
  - Configure the following parameters in .env file to your own values:
    - DB_HOST
    - DB_PORT
    - DB_DATABASE
    - DB_USERNAME
    - DB_PASSWORD
  - In the terminal where the project is located at run the following commands
  ```sh
$ composer install
$ php artisan migrate && php artisan db:seed
```
  - (optional) Modify App/Constants to set the pagination number and cache remember time

# Additional notes

A few adjustments could be done in order to improve the project

  - Partition the database table entries
  - Cache the routes (with a lot of requests is faster, when there are few requests is slower) with the command:
```sh
$ php artisan route:cache
```

Additional technologies used:

  - jQuery
  - Tailwind css
  - Axios
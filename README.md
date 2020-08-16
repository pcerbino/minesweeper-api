# Minesweeper API
-------
Minesweepr classic game API developed in Laravel.

#### Install instructions

- Clone this repository.
- Create a MySQL database and update ```.env``` file with credentials.
- Run ``$ composer install``
- Execute migrations ``$ php artisan migrate``
- Generate key ``$ php artisan key:generate``
- Generate Passport keys ``$ php artisan passport:keys``
- And finally ```$ php artisan passport:client --personal```

## Documentation

Endpoints documentation was generated with **Postman** and it's available: 
[![Run in Postman](https://run.pstmn.io/button.svg)](https://documenter.getpostman.com/view/134204/T1LQfkDq?version=latest)

The API it's focused on resolve and deliver to client all the information clean and processed. Also it's secure in terms that hidden squares are delivered with hidden content.

API routes are secured with **Passport** to implement JWT.

#### Todos

- Implement Exceptions to handle errors.
- Develop testing

#### License
MIT
**Free Software, Hell Yeah!**

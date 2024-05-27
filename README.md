# User Management System

A simple yet robust web application that allows for managing user accounts. This includes functionalities for user registration, login, viewing, editing, and deleting user profiles.


## Technical Specifications

- Backend Framework: Laravel
- Frontend Framework: Vue.js with Vuetify
- Database: MySQL
- Authentication: Implements JWT for authentication.
- TDD Framework: PHPUnit


## Author

- [@Tonho1994](https://github.com/Tonho1994)


## Technologies

The following technologies are used for the correct operation of the project

- Apache2 => 2.4.59
- Bootstrap => 5.2.3
- Composer => 2.5.7
- Laravel Framework => 10.48.11
- MariaDB => 10.11.6
- NodeJs => 18.16.0
- Npm= > 9.5.1
- PHP => 8.1.28
- Vue => 3.2.37
- Vuetify => 3.6.7


## Deployment

Clone the repository
```bash
  git clone
```
Change to the Project directory
```bash
  cd managment_users
```
Proceed to install the packages that we will use in the application
```bash
  composer install
  npm install
  npm run build
```
Create your mysql or mariadb database and fill in the data in the .env

- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

Run migrations and seeders to populate the database.
```bash
  php artisan migrate:fresh --seed
```
Test the application by running the following command
```bash
  php artisan serve
```


## Colors

| Color             | Hex                                                                |
| ----------------- | ------------------------------------------------------------------ |
| Red | ![#9F2241](https://via.placeholder.com/10/9F2241?text=+) #9F2241 |
# Laravel based administration panel

### Install

1. cp .env.example .env
2. composer install
3. php artisan key:generate
4. php artisan migrate --seed
- creating user role and user admin
5. maybe, need create storage link:
- php artisan storage:link

### Admin panel

1. Login form: /login
- default user admin: admin@site.com / password
2. Registration form: /registration

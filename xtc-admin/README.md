# XTC-ADMIN

## Dev Installation

```bash
git clone https://github.com/femboy-fanclub/xtc-admin.git
cd xtc-admin/
composer install
npm install
copy .env.example .env
php artisan key:generate
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes

#The DB structure from XTC-AUTH is needed for XTC-ADMIN
php artisan migrate 
```

## To start
```bash
php artisan serve
```

## If you want to install a npm package 

STRG + C to stop the server

```bash
npm install package  --save
npm run dev
```
and make sure to add it in resources/js/bootstrap.js if you want to use it globally

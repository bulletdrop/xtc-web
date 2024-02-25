# XTC-ADMIN

## Dev Installation

```bash
git clone https://github.com/femboy-fanclub/xtc-auth.git
cd xtc-auth/
composer install
npm install
copy .env.example .env
php artisan key:generate

#The DB structure from XTC-AUTH is needed for XTC-ADMIN
php artisan migrate 
```

## To start
```bash
php artisan serve
```

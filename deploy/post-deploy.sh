#!/bin/bash
php artisan migrate --force
php artisan l5-swagger:generate
php artisan optimize
php artisan serve --host=0.0.0.0
#!/bin/bash
php artisan migrate --force
php artisan l5-swagger:generate
php artisan optimize
@echo off

REM Abre um novo terminal e executa o comando npm run dev
start cmd /k "npm run dev"

REM Agora, abra outro novo terminal e execute o comando php artisan serve
start cmd /k "php artisan serve"

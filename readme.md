# Laravel Ansible

## Quick Installation
`composer install`
## Config .env
`APP_ENV=local
 APP_DEBUG=true
 APP_KEY=appkey

 DB_HOST=localhost
 DB_DATABASE=ansible
 DB_USERNAME=user
 DB_PASSWORD=password

 CACHE_DRIVER=file
 SESSION_DRIVER=file
 QUEUE_DRIVER=database
`
## Config storage/roles/callback_plugins/human_log.py
`url="http://test.com/jobs/run/"`
## Install DB
`php artisan migrate`
## Run queue
`php artisan queue:listen --timeout=600`
## Run websocket
`php artisan websocket`
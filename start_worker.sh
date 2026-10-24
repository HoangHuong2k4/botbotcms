#!/bin/bash
docker exec -i -u 1000:1000 -w /www/sites/cms.cataishop.shop/index 1Panel-php8-k5vQ php artisan queue:work --tries=2 --timeout=900

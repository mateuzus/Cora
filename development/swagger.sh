#!/bin/bash

mkdir -p ../public/swagger

php ../vendor/bin/openapi --bootstrap ./swagger-variables.php --output ../public/swagger ./swagger-v1.php ../app/Http/Controllers/Api

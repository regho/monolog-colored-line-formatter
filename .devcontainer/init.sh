#!/bin/sh

sh -c "$(curl --location https://taskfile.dev/install.sh)" -- -d -b /bin
composer install
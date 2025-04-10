#!/usr/bin/sh

mariadb fast_food -uroot -psuperAdmin < /root/init.sql
echo "Restauration terminée"

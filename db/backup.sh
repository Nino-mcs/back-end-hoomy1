#!/usr/bin/sh
mariadb-dump fast_food -uroot -psuperAdmin > /root/init.sql
echo "Sauvegarde terminée"
#!/bin/bash
echo -n "Removing Lucene indexes... "
rm -rf data/*index
echo "done."
lib/wviola/bin/resettestfilesystem.sh
chmod g+w data/*index
symfony propel:data-load --env=dev --application=frontend
symfony propel:insert-sql --env=test --no-confirmation

mkdir /var/wviola/data/filesystem/sources/pictures/lnf
sudo chown www-data /var/wviola/data/filesystem/sources/pictures/lnf
sudo chmod 777 /var/wviola/data/filesystem/sources/pictures/lnf
sudo cp /etc/wviola/IMG*JPG /var/wviola/data/filesystem/sources/pictures/lnf
sudo chown matthew /var/wviola/data/filesystem/sources/pictures/lnf/*JPG

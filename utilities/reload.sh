#!/bin/bash
echo -n "Removing Lucene indexes... "
rm -rf data/*index
echo "done."
lib/wviola/bin/resettestfilesystem.sh
symfony propel:data-load --env=dev --application=frontend
symfony propel:insert-sql --env=test --no-confirmation

sudo mkdir -v /var/wviola/data/asset.{dev,prod,test}.index
sudo chgrp -v www-data /var/wviola/data/*.index
sudo chmod 770 -v /var/wviola/data/*.index

mkdir /var/wviola/data/filesystem/sources/pictures/lnf
sudo chown www-data /var/wviola/data/filesystem/sources/pictures/lnf
sudo chmod 777 /var/wviola/data/filesystem/sources/pictures/lnf
sudo cp /etc/wviola/IMG*JPG /var/wviola/data/filesystem/sources/pictures/lnf
sudo chown matthew /var/wviola/data/filesystem/sources/pictures/lnf/*JPG

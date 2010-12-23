#!/bin/bash
echo -n "Removing Lucene indexes... "
rm -rf data/*index
echo "done." 
symfony propel:data-load --env=dev --application=frontend
chmod g+w data/*index
lib/wviola/bin/resettestfilesystem.sh
symfony propel:insert-sql --env=test --no-confirmation

#touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000100a.zip
#touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000100b.zip
#touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000100c.zip
#touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000101a.zip
#touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000101b.zip
#touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000101c.zip
#touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000102a.zip
#touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000102b.zip
#touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000102c.zip
#touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000103a.zip
#touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000103b.zip
#touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000103c.zip

#cp /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_0000010*zip /var/wviola/data/filesystem/published/assets/

#cp /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_0000010*zip /var/wviola/data/filesystem/published/thumbnails/

mkdir /var/wviola/data/filesystem/sources/pictures/lnf
sudo chown www-data /var/wviola/data/filesystem/sources/pictures/lnf
sudo chmod 777 /var/wviola/data/filesystem/sources/pictures/lnf
sudo cp /etc/wviola/IMG*JPG /var/wviola/data/filesystem/sources/pictures/lnf
sudo chown matthew /var/wviola/data/filesystem/sources/pictures/lnf/*JPG

#!/bin/bash
echo -n "Removing Lucene indexes... "
rm -rf data/*index
echo "done." 
symfony propel:data-load --env=dev --application=frontend
chmod g+w data/*index
lib/wviola/bin/resettestfilesystem.sh
symfony propel:insert-sql --env=test --no-confirmation

touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000100a.zip
touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000100b.zip
touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000100c.zip
touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000101a.zip
touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000101b.zip
touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000101c.zip
touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000102a.zip
touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000102b.zip
touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000102c.zip
touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000103a.zip
touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000103b.zip
touch /var/wviola/data/filesystem/iso_images/cache/photoalbum2009_00000103c.zip


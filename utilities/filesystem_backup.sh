#!/bin/bash

FILENAME=filesystem$(date +%F_%H%M%S).tar.bz2

cd /home/loris/Importanti/Wviola
sudo find filesystem -type d -exec chmod -v 777 {} \;
sudo find filesystem -type f -exec chmod -v 666 {} \;
tar cpvjf $FILENAME filesystem
md5sum $FILENAME
mv -v ~/Importanti/Wviola/$FILENAME /etc/wviola/
ln -sf /etc/wviola/$FILENAME /etc/wviola/filesystem.tar.bz2

cd /etc/wviola
tar xpvjf filesystem.tar.bz2

# /var/wviola/utilities/googlecode_upload.py --summary='Binary data for tests (examples of videos and pictures)' --project=wviola /etc/wviola/filesystem.tar.bz2


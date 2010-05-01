#!/bin/bash

sudo /usr/bin/rsync -azv --perms --owner --group --delete /etc/wviola/filesystem /var/wviola/data/

WVIOLAFILE=$(stat -c '%i.yml' /var/wviola/data/filesystem/sources/videos/bigbuckbunny02.mpeg) 

rm -f /var/wviola/data/filesystem/sources/videos/.wviola/$WVIOLAFILE
cp -v /etc/wviola/wviola.yml /var/wviola/data/filesystem/sources/videos/.wviola/$WVIOLAFILE

chmod 777 /var/wviola/data/filesystem/sources/videos/.wviola/$WVIOLAFILE

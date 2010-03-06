#!/bin/bash

symfony cc

BASEDIR=/var/wviola

sudo find "$BASEDIR" ! -user loris -exec chown loris  {} \;
sudo find "$BASEDIR" ! -group www-data -exec chgrp www-data  {} \;

sudo find "$BASEDIR" -type d ! -perm 2770 -exec chmod  2770 {} \;
sudo find "$BASEDIR" -type f ! -perm 660 -exec chmod 660 {} \;

sudo find "$BASEDIR/data/filesystem" -type f ! -perm 444 -exec chmod 444 {} \;
sudo find "$BASEDIR/data/filesystem" -type d ! -perm 777 -exec chmod 777 {} \;

cd "$BASEDIR/utilities"
chmod +x *sh *py

cd "$BASEDIR/lib/wviola/bin"
chmod +x *

chmod +x  "$BASEDIR/symfony"

rm -rfv "$BASEDIR/data/filesystem"
#!/bin/bash

symfony cc

BASEDIR=/var/wviola

sudo find "$BASEDIR" ! -user loris -exec chown loris  {} \;
sudo find "$BASEDIR" ! -group www-data -exec chgrp www-data  {} \;

sudo find "$BASEDIR" -type d ! -perm 2770 -exec chmod  2770 {} \;
sudo find "$BASEDIR" -type f ! -perm 660 -exec chmod 660 {} \;

cd "$BASEDIR/utilities"
chmod +x *sh *py

cd "$BASEDIR/bin"
chmod +x *

chmod +x  "$BASEDIR/symfony"

rm -rf "$BASEDIR/data/filesystem/sources"
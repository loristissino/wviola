BASEDIR=/var/wviola

sudo find "$BASEDIR" ! -user loris -exec chown loris  {} \;
sudo find "$BASEDIR" ! -group www-data -exec chgrp www-data  {} \;

sudo find "$BASEDIR" -type d ! -perm 2770 -exec chmod  2770 {} \;
sudo find "$BASEDIR" -type f ! -perm 660 -exec chmod 660 {} \;

cd "$BASEDIR/utilities"
chmod +x *sh *php


chmod +x "$BASEDIR/symfony"

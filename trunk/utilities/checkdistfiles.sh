#!/bin/bash
MAINDIR="$1"
if [[ $# -ne 1 ]]; then
  echo "Usage:"
  echo $0 "wviola_installation_dir"
  exit 1
fi

cd "$MAINDIR"

LIST=$(find . -iname '*dist')
for FILE in $(echo $LIST); do 
#  echo    'Dist-file: ' $FILE
  REALNAME=${FILE%-dist}
  test -f "$REALNAME" && echo -n 'OK:         ' || echo -n 'MISSING:    '
  echo    $REALNAME
done

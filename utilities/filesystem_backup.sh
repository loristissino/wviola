#!/bin/bash

FILENAME=filesystem$(date +%F_%H%M%S).tar.bz2

cd /home/loris/Importanti/Wviola
tar cpvjf $FILENAME filesystem
md5sum $FILENAME
mv -v ~/Importanti/Wviola/$FILENAME /var/wviola/data
ln -sf /var/wviola/data/$FILENAME /var/wviola/data/filesystem.tar.bz2


# /var/wviola/utilities/googlecode-upload.py --summary='Binary data for tests (examples of videos and pictures)' --project=wviola /var/wviola/data/$FILENAME
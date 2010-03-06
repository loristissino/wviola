#!/bin/bash

FILENAME=$(ls /etc/wviola/filesystem2*.tar.bz2 | tail -1)

/var/wviola/utilities/googlecode_upload.py --summary='Binary data for tests (examples of videos and pictures)' --project=wviola "$FILENAME" -u=loris.tissino

#!/bin/bash

FILE=$1

B64=$(uuenview -b "$FILE" | tr '\n' '@' | sed 's/@//g')

echo '    thumbnail_from_base64:' $B64
identify -format '    thumbnail_width: %w' "$FILE"
identify -format '    thumbnail_height: %h' "$FILE"



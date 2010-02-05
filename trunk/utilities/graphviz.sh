#!/bin/bash

cd /var/wviola
symfony propel:graphviz

cd graph

TEMPFILE=$(mktemp)
dot -Tpng propel.schema.dot -o $TEMPFILE.png
convert $TEMPFILE.png -scale '50%x50%' propel.schema.png

mv -v propel.schema.png ~/Importanti/Wviola/wiki

rm -f $TEMPFILE{,.png}

#!/bin/bash
echo -n "Removing Lucene indexes... "
rm -rf data/*index
echo "done." 
symfony propel:data-load --env=dev --application=frontend
chmod g+w data/*index
lib/wviola/bin/resettestfilesystem.sh
symfony propel:insert-sql --env=test --no-confirmation

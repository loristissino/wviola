#!/bin/bash
symfony propel:data-load
lib/wviola/bin/resettestfilesystem.sh
symfony propel:insert-sql --env=test --no-confirmation

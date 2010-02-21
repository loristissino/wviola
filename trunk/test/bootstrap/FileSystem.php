<?php

include(dirname(__FILE__).'/unit.php');
 
echo "Extracting the files needed for the test to start with a clean directory...\n";
Generic::executeCommand('rm -rf "/var/wviola/data/filesystem"');
Generic::executeCommand('tar xvjf "/etc/wviola/filesystem.tar.bz2" --directory "/var/wviola/data" 2>/dev/null');
echo "... done\n'";


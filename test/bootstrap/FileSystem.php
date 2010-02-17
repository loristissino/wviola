<?php

include(dirname(__FILE__).'/unit.php');
 
echo "Copying the files needed for the test to start with a clean directory...\n";
Generic::executeCommand('rm -rf "/var/wviola/data/filesystem/sources"');
Generic::executeCommand('mkdir "/var/wviola/data/filesystem/sources"');
Generic::executeCommand('rsync -avz --progress "/var/wviola/data/filesystem/original_sources/" "/var/wviola/data/filesystem/sources"');
echo "... done\n'";


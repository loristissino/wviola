<?php

include(dirname(__FILE__).'/unit.php');
 
echo "Resetting the files needed for the test to start with a clean directory...\n";
Generic::executeCommand('resettestfilesystem.sh', true);
echo "... done\n'";


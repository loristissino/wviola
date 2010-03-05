<?php

include(dirname(__FILE__).'/unit.php');
 
echo "Resetting the files needed for the test to start with a clean directory...\n";
$info=Generic::executeCommand('resettestfilesystem.sh', true);
//print_r($info);
echo "... done\n'";


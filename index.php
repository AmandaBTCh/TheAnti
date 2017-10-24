<?php

require_once 'vendor/autoload.php';

use TheAnti\Match\Match;
use TheAnti\Match\Settings;

$matchSettings = new Settings();
$match = new Match($matchSettings);
$match->start();

print "Bye.\n";

?>
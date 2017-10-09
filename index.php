<?php

require_once 'vendor/autoload.php';

use TheAnti\Match\Settings as MatchSettings;
use TheAnti\Match\Match;

$matchSettings = new MatchSettings();
$matchSettings->setBlinds(5, 2);
$matchSettings->setStackSize(100);

$match = new Match($matchSettings);

print "All is well.";

?>
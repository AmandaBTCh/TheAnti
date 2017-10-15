<?php

require_once 'vendor/autoload.php';

use TheAnti\Range\Range;
use TheAnti\HandStrength\HandStrengthCalculator;

$range = new Range();
$range->importHands("all_hands.txt");
$handStrength = new HandStrengthCalculator([], $range);
$handStrength->calculate();

print "All is well.\n";

?>
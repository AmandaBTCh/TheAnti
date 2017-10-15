<?php

require_once 'vendor/autoload.php';

use TheAnti\HandStrength\HandStrengthCalculator;

$handStrength = new HandStrengthCalculator([]);
$handStrength->calculate();

print "All is well.\n";

?>
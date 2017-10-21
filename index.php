<?php

require_once 'vendor/autoload.php';

use TheAnti\Range\Range;
use TheAnti\HandAnalysis\HandAnalyzer;

$range = new Range();
$range->importHands("tool/ranges/all_hands.txt");

$suited = 0;
foreach($range->getHands() as $hand)
{
	$ha = new HandAnalyzer($hand);
	$suited += (int) $ha->isSuited();
}

print "$suited suited hand combos.\n";

print "All is well.\n";

?>
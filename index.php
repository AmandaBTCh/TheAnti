<?php

require_once 'vendor/autoload.php';

use TheAnti\Range\Range;
use TheAnti\HandAnalysis\HandAnalyzer;

$range = new Range();
$range->importHands("tool/ranges/all_hands.txt");

$suited = 0;
$paired = 0;
$highHands = 0;
$floppedStraights = 0;
foreach($range->getHands() as $hand)
{
	$ha = new HandAnalyzer($hand);
	$suited += (int) $ha->isSuited();
	$paired += (int) $ha->isPaired();
	if($ha->getHeight() == $ha::HIGH)
	{
		$highHands++;
	}
	$floppedStraights += $ha->getFlopConnectivity();
}

print "$suited suited hand combos.\n";
print "$paired paired hand combos.\n";
print "$highHands hands with a Q or higher.\n";
print "$floppedStraights possible flopped straights.\n";

print "All is well.\n";

?>
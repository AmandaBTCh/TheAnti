<?php

require_once 'vendor/autoload.php';

use TheAnti\Range\Range;
use TheAnti\HandStrength\HandStrengthCalculator;
use TheAnti\GameElement\Hand;
use TheAnti\GameElement\Card;

$range = new Range();
$range->importHands("tool/ranges/all_hands.txt");

$range->removeHandWeightsWithCards([

]);

$handStrength = new HandStrengthCalculator([

], $range);
$handStrength->calculate();

$rangeStrength = $handStrength->getRangeStrength();
foreach($rangeStrength as $handString => $equity)
{
	$hand = Hand::importFromString($handString);
	$strength = $handStrength->getHandStrength($hand);

	print "{$handString}: {$strength}\n";
}

print "All is well.\n";

?>
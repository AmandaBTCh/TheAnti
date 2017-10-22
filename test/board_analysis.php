<?php

chdir("../");

require_once 'vendor/autoload.php';

use TheAnti\BoardAnalysis\BoardAnalyzer;
use TheAnti\BoardAnalysis\BoardTexture\Paired;
use TheAnti\GameElement\Card;

print "Testing board analysis on several different board textures...\n";

$boards = [
	["As", "3s", "5s"],
	["7s", "8s", "9h"],
	["Ah", "7d", "Qs"],
	["Ac", "Kc", "Qc", "Qd", "Qs"],
	["2h", "3s", "2s", "3h"],
	["2h", "3s", "3c", "2s", "3h"]
];

foreach($boards as $board)
{
	$cards = [];
	foreach($board as $cardString)
	{
		$cards[] = Card::importFromString($cardString);
	}

	$ba = new BoardAnalyzer($cards);

	//Print out board
	print "Board:\n";
	print_r($board);

	//Get flush info
	$flushInfo = $ba->getFlushInfo();
	print "Flush Info:\n====================\n";
	print "Number of flushes: " . $flushInfo->getFlushes() . "\n";
	print "Number of flush draws: " . $flushInfo->getFlushDraws() . "\n";
	print "Number of cards needed to make a flush: " . $flushInfo->getCardsNeededForFlush() . "\n\n";

	//Get straight info
	$straightInfo = $ba->getStraightInfo();
	print "Straight Info:\n====================\n";
	print "Possible straights: " . $straightInfo->getStraights() . "\n\n";

	//Get pairing info
	$pairInfo = $ba->getPairedInfo();
	print "Paired Info:\n====================\n";
	print "Paired type: " . $pairInfo->getPairingTypeDesc() . "\n\n";
}

print "All is well.\n";
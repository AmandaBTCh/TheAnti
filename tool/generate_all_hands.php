<?php

require_once '../vendor/autoload.php';

use TheAnti\GameElement\Deck;
use TheAnti\GameElement\Hand;

/*
 * Script which generates all possible starting hand combos and saves them to a file.
 */

$deck = new Deck();
$cards = $deck->getCards(52);

$fileContents = "";

while($cards)
{
	$baseCard = array_shift($cards);
	foreach($cards as $card)
	{
		$fileContents .= (new Hand([$card, $baseCard]))->toString() . "\n";
	}
}

file_put_contents("ranges/all_hands.txt", $fileContents);

?>
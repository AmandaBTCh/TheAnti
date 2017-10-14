<?php

require_once '../vendor/autoload.php';

use TheAnti\GameElement\Deck;

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
		$fileContents .= $baseCard->toString() . $card->toString() . "\n";
	}
}

file_put_contents("all_hands.txt", $fileContents);

?>
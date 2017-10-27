<?php

namespace TheAnti\Match;

use TheAnti\GameElement\Board;
use TheAnti\GameElement\Deck;
use TheAnti\GameElement\Hand;
use TheAnti\Player\Player;

/*
 * This class represents a round of Texas Hold'em.
 */
class Round
{
	//@var Match The match we're in
	protected $match = NULL;

	/*
	 * @var array The action that has taken place this round.
	 * This is really only an array of integers, where each
	 * one represents the amount of money that a player put
	 * into the pot.
	 * [1, 2] is how it always starts as this is for the blinds.
	 * If one player puts money into the pot, and the next player puts in 0,
	 * that means they folded.
	 * If a player puts 0 in in other circmstances, it means
	 * that they checked.
	 */
	protected $actions = [];

	//@var Board The board.
	protected $board = NULL;

	//@var int The pot.
	protected $pot = 0;

	//@var Deck The deck for this round.

	/*
	 * Creates a new round.
	 */
	public function __construct(Match $match)
	{
		$this->match = $match;
		$this->board = new Board();
		$this->deck = new Deck();
	}

	/*
	 * Starts the round!
	 */
	public function start()
	{
		print "\n";

		print "Starting round...\n";

		//Shuffle the deck
		$this->deck->shuffle();

		//Post the blinds
		$this->postBlinds();

		//Deal cards
		$this->dealCards();

		//Get player action!
		//...

		//Update player positions
		$this->match->moveButton();

		print "Round over.\n";

		print "\n";
	}

	protected function postBlinds()
	{
		print "\n";

		//Get blinds
		$settings = $this->match->getSettings();
		$blinds = $settings->getBlinds();

		//Send messages to players
		$players = $this->match->getPlayers();
		$players[0]->broadcast("posts \${$blinds[1]} SB.");
		$players[1]->broadcast("posts \${$blinds[0]} BB.");

		//Add blinds from stack to pot
		$this->addToPot(
			$this->getMoneyFromPlayer($players[0], $blinds[1])
			+
			$this->getMoneyFromPlayer($players[1], $blinds[0])
		);

		//Update actions
		$this->actions[] = 1;
		$this->actions[] = 2;

		//Update status
		print "Pot is now \${$this->pot}.\n";

		print "\n";
	}

	/*
	 * Deals the cards.
	 */
	protected function dealCards()
	{
		//Get the hands
		$hands = [
			new Hand($this->deck->getCards(2)),
			new Hand($this->deck->getCards(2))
		];

		foreach($hands as $key => $hand)
		{
			$this->match->getPlayers()[$key]->broadcast("Gets dealt hand " . $hand->toString() . ".");
			$this->match->getPlayers()[$key]->setHand($hand);
		}
	}

	/*
	 * Adds money to the pot.
	 */
	protected function addToPot(int $amount): int
	{
		$this->pot += $amount;
		return $amount;
	}

	/*
	 * Gets money from a player.
	 */
	protected function getMoneyFromPlayer(Player $player, int $amount): int
	{
		$stack = $player->getStack();
		$stack -= $amount;
		$player->setStack($stack);
		return $amount;
	}
}
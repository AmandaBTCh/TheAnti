<?php

namespace TheAnti\Match;

use TheAnti\GameElement\Board;
use TheAnti\GameElement\Deck;
use TheAnti\GameElement\Hand;
use TheAnti\HandStrength\WinnerCalculator;
use TheAnti\Player\Player;

/*
 * This class represents a round of Texas Hold'em.
 */
class Round
{
	//@var Match The match we're in
	protected $match = NULL;

	/*
	 * @var Action The action that has taken place this round.
	 */
	protected $action = NULL;

	//@var Board The board.
	protected $board = NULL;

	//@var int The pot.
	protected $pot = 0;

	//@var Deck The deck for this round.
	protected $deck = NULL;

	/*
	 * Creates a new round.
	 */
	public function __construct(Match $match)
	{
		$this->match = $match;
		$this->board = new Board();
		$this->deck = new Deck();
		$this->action = new Action();
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

		//Preflop action
		while($this->isActionNeeded())
		{
			//$this->getAction();
		}

		//Flop action
		$this->burnAndTurn(3);
		while($this->isActionNeeded())
		{
			//$this->getAction();
		}

		//Turn action
		$this->burnAndTurn();
		while($this->isActionNeeded())
		{
			//$this->getAction();
		}

		//River action
		$this->burnAndTurn();
		while($this->isActionNeeded())
		{
			//$this->getAction();
		}

		//Award pot to winning player(s)
		$this->awardPot();

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
		$this->action->addAction(0, 0, $blinds[1]);
		$this->action->addAction(1, 0, $blinds[0]);

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
	 * Awards the pot to the winning player(s).
	 */
	public function awardPot()
	{
		//Get the players
		$players = $this->match->getPlayers();

		$winnerCalculator = new WinnerCalculator($players[0]->getHand(), $players[1]->getHand(), $this->board);
		$winner = $winnerCalculator->calculate();

		//It's a tie
		if($winner == -1)
		{
			foreach($this->match->getPlayers() as $player)
			{
				$stack = $player->getStack();
				$stack += $this->pot / 2;
				$player->setStack($stack);
				$player->broadcast("Wins $" . ($this->pot / 2) . ".");
			}
		}

		//The higher hand wins
		else
		{
			$stack = $players[$winner]->getStack();
			$stack += $this->pot;
			$players[$winner]->setStack($stack);
			$players[$winner]->broadcast("Wins $" . ($this->pot) . ".");
		}

		$this->pot = 0;
	}

	/*
	 * Burns and turns cards.
	 */
	public function burnAndTurn(int $cards = 1)
	{
		//Burn
		$this->deck->getCard();

		//Turn cards
		$this->board->addCards($this->deck->getCards($cards));

		//Display board
		print "Board: " . $this->board->toString() . "\n";
	}

	/*
	 * Determines if action is needed from a player.
	 * Action is needed if:
	 * 1. The action object says so.
	 * 2. The players are both in the hand.
	 * 3. And both players are not all-in.
	 */
	public function isActionNeeded(): bool
	{
		$players = $this->match->getPlayers();

		//Both are all-in
		if(!($players[0]->getStack() || $players[1]->getStack()))
		{
			return false;
		}

		//A player has folded
		else if($players[0]->isFolded() || $players[1]->isFolded())
		{
			return false;
		}

		//Defer to the action object
		else
		{
			return $this->action->isActionNeeded(count($this->board->getCards()));
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
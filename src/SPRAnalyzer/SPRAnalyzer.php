<?php

namespace TheAnti\SPRAnalyzer;

/*
 * Gets information about the Stack-to-Pot ratio
 * This includes the following information:
 * 1. Simple SPR for each player
 * 2. Simple fold equity for each player
 * 3. Bet-size needed to get us effectively all-in by river
 */
class SPRAnalyzer
{
	//@var Player[] The players.
	protected $players = [];

	//@var int The pot
	protected $pot = 0;

	//@var int The number of rounds of betting left
	protected $streetsLeft = 0;

	/*
	 * Constructs a new SPRAnalyzer.
	 */
	public function __construct(array $players, int $pot, int $streetsLeft = 0)
	{
		$this->players = $players;
		$this->pot = $pot;
		$this->streetsLeft = $streetsLeft;
	}

	/*
	 * Gets the SPR for a given player.
	 */
	public function getSPRForPlayer(int $player): float
	{
		return $this->players[$player]->getStack() / $this->pot;
	}

	/*
	 * Gets the fold equity for either player.
	 * This is determined by the SPR of both players.
	 * If player A can only bet 25% of the pot based on his
	 * stack-size, then he only has 25% fold equity.
	 * The same is true if his opponent only has 25% of the pot.
	 * So as far as these calculations go, a number between 0 and 1
	 * will be returned. 0 indicates that one of the players is all-in,
	 * while 1 means that both players can make/call a pot-sized bet.
	 * Both players always have the same fold equity.
	 */
	public function getFoldEquity(): float
	{
		//Get the minimum SPR
		$minSPR = min(
			$this->getSPRForPlayer(0),
			$this->getSPRForPlayer(1)
		);

		//Both players have at least a pot-sized bet behind
		if($minSPR >= 1.0)
		{
			return 1.0;
		}

		return $minSPR;
	}

	/*
	 * Based on the number of streets left, determines the bet-size needed
	 * in order to get all-in by the river.
	 * This number is a percentage of the pot and will allow for over-bets.
	 *
	 * This is the equation where:
	 * 	b = bet-size as percentage of pot
	 * 	n = number of players
	 * 	m = number of streets left
	 * 	s = minimum SPR of both players
	 * b = ((n*s + 1)1/m - 1)/n
	 */
	public function getAllInBetSize(): float
	{
		//No more betting
		if(!$this->streetsLeft)
		{
			return 0;
		}

		//Get the minimum SPR
		$minSPR = min(
			$this->getSPRForPlayer(0),
			$this->getSPRForPlayer(1)
		);

		//Get the number of players
		$numPlayers = count($this->players);

		return (pow(($numPlayers * $minSPR + 1), 0.33) - 1) / $numPlayers;
	}
}
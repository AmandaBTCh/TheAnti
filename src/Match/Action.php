<?php

namespace TheAnti\Match;

use TheAnti\Player\Player;

/*
 * Records the action that has taken place in the hand.
 */
class Action
{
	/*
	 * @var array The actions throughout this hand.
	 * 0 = preflop actions
	 * 3 = flop actions
	 * 4 = turn actions
	 * 5 = river actions
	 * On each street, the actions are an array of array
	 * where each array is setup like:
	 * [ playerIndex, betSize ]
	 */
	protected $actions = [
		0 => [],
		3 => [],
		4 => [],
		5 => []
	];

	/*
	 * Constructor.
	 */
	public function __construct()
	{

	}

	/*
	 * Adds an action for a player and street.
	 */
	public function addAction(int $player, int $street, int $betSize)
	{
		$this->actions[$street][] = [$player, $betSize];
	}

	/*
	 * Gets the actions for a street.
	 */
	public function getActions(int $street): array
	{
		return $this->actions[$street];
	}

	/*
	 * Get total amount bet for each player.
	 */
	public function getTotalBets(): array
	{
		$totals = [];
		foreach($this->actions as $streetActions)
		{
			foreach($streetActions as $streetAction)
			{
				if(isset($totals[$streetAction[0]]))
				{
					$totals[$streetAction[0]] = 0;
				}

				else
				{
					$totals[$streetAction[0]] += $streetAction[1];
				}
			}
		}
		return $totals;
	}

	/*
	 * Get amount needed to call for a player.
	 */
	public function getCallAmountForPlayer(int $player)
	{
		//Get how much the player bet
		$totals = $this->getTotalBets();
		$playerBet = $totals[$player];

		//Get the max bet
		$maxBet = max($totals);

		return $maxBet - $playerBet;
	}
}
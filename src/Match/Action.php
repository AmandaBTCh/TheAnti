<?php

namespace TheAnti\Match;

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
				if(!isset($totals[$streetAction[0]]))
				{
					$totals[$streetAction[0]] = $streetAction[1];
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
	public function getCallAmountForPlayer(int $player): int
	{
		//Get how much the player bet
		$totals = $this->getTotalBets();
		$playerBet = $totals[$player];

		//Get the max bet
		$maxBet = max($totals);

		return $maxBet - $playerBet;
	}

	/*
	 * Determines if any action is needed from our perspective.
	 * An action is needed if:
	 * 1. The total betsize for all players is not equal.
	 * 2. A player has taken no action on the latest street.
	 * This class, however, doesn't know if a player has folded,
	 * or if both are all-in, so this will have to be checked higher up.
	 */
	public function isActionNeeded(int $street): bool
	{
		$totals = $this->getTotalBets();

		//If the diff is non-zero, then someone needs to fold/call/raise
		if(max($totals) - min($totals))
		{
			return true;
		}

		//We need at least 2 actions in the street that we're in, 1+ for each player
		else
		{
			$streetActions = $this->getActions($street);

			//Preflop is special since all players have made actions by posting
			return count($streetActions) >= ($street == 0 ? 4 : 2);
		}
	}
}
<?php

namespace TheAnti\Player;

use TheAnti\Situation\Situation;
use TheAnti\Strategy\StrategyManager;
use TheAnti\WeightedDecision\WeightedDecision;

class TheAnti extends Computer
{
	public function makeDecision(Situation $situation): int
	{
		$callAmount = $situation->action->getCallAmountForPlayer($situation->playerIndex);

		$strategyManager = new StrategyManager($situation);
		$strategies = $strategyManager->getStrategies();

		if(!$strategies)
		{
			throw new \Exception("TheAnti doesn't know what to do!");
		}

		else
		{
			//Just grab the decision from the first strategy
			$weightedDecision = $strategies[0]->getWeightedDecision();
			$decision = $weightedDecision->getDecision();

			//Check/fold
			if($decision == WeightedDecision::CHECK || $decision == WeightedDecision::CHECK)
			{
				return 0;
			}

			//Call
			else if($decision == WeightedDecision::CALL)
			{
				return $callAmount;
			}

			//Raise
			else
			{
				return ($situation->pot + $callAmount * 2) / 0.7;
			}
		}
	}
}
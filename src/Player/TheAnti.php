<?php

namespace TheAnti\Player;

use TheAnti\Situation\Situation;
use TheAnti\Strategy\StrategyManager;

class TheAnti extends Computer
{
	public function makeDecision(Situation $situation): int
	{
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

			print "Made decision: " . $decision . ".\n";
		}

		//Super nit (fold/check)
		return 0;
	}
}
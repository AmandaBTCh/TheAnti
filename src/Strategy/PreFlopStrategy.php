<?php

namespace TheAnti\Strategy;

use TheAnti\GameElement\Board;
use TheAnti\WeightedDecision\WeightedDecision;

/*
 * *Complete* Preflop Strategy
 * Works basically as follows:
 * A. As the button: raise to 2.5x with top 70% of range
 * B. As the defender
 * 	1. Facing raise: standard raise-facing decision
 * 	2. Facing limp: standard raise situation
 */
class PreFlopStrategy extends Strategy
{
	function situationApplies(): bool
	{
		return ($this->situation->boardAnalyzer->getStreet() == Board::PREFLOP);
	}

	function getWeightedDecision(): WeightedDecision
	{
		$wd = new WeightedDecision();
		$wd->setDecision(WeightedDecision::FOLD, 1.0);
		return $wd;
	}
}
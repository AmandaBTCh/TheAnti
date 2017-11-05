<?php

namespace TheAnti\Strategy;

use TheAnti\GameElement\Board;
use TheAnti\Range\Range;
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
		/*
		 * If we're the aggressor preflop that means:
		 * A. button
		 * B. limped to us
		 */
		if($this->situation->player->isAggressor())
		{
			//Button: raise 70% of hands
			if($this->situation->playerIndex == 0)
			{
				$top70 = $this->situation->handStrengthCalculator->getHandsByStrength(0.3, 1.0);
				$range = new Range();
				$range->addHands($top70);

				//The player's hand is in the range of hands to raise
				if($range->getHandWeight($this->situation->player->getHand()))
				{
					$this->situation->player->setRange($range);
					$wd = new WeightedDecision();
					$wd->setDecision(WeightedDecision::RAISE, 1.0);
				}

				//Folding preflop
				else
				{
					$wd = new WeightedDecision();
					$wd->setDecision(WeightedDecision::FOLD, 1.0);
				}

				return $wd;
			}

			//Limp: make standard cbet
			else
			{
				$top50 = $this->situation->handStrengthCalculator->getHandsByStrength(0.5, 1.0);
				$range = new Range();
				$range->addHands($top50);

				//The player's hand is in the range of hands to raise
				if($range->getHandWeight($this->situation->player->getHand()))
				{
					$this->situation->player->setRange($range);
					$wd = new WeightedDecision();
					$wd->setDecision(WeightedDecision::RAISE, 1.0);
				}

				//Folding preflop
				else
				{
					$wd = new WeightedDecision();
					$wd->setDecision(WeightedDecision::CHECK, 1.0);
				}

				return $wd;
			}
		}

		//Facing raise/reraise
		else
		{
			//Get our continuing frequency (0.0 - 1.0)
			$cf = $this->situation->potOddsCalculator->getContinuingFrequency() / 100.0;

			//Raising range of top and bottom 10% of continuing range.
			$vrf = $brf = ($cf / 10);
			$top10 = $this->situation->handStrengthCalculator->getHandsByStrength(1.0 - $vrf, 1.0);
			$bottom10 = $this->situation->handStrengthCalculator->getHandsByStrength(1.0 - $brf, 1.0);
			$cfHands = $this->situation->handStrengthCalculator->getHandsByStrength(1.0 - $cf, 1.0);

			$raiseRange = new Range();
			$raiseRange->addHands($top10);
			$raiseRange->addHands($bottom10);

			$callRange = new Range();
			$callRange->addHands($cfHands);

			//The player's hand is in the value/bluff-raise range
			if($raiseRange->getHandWeight($this->situation->player->getHand()))
			{
				$this->situation->player->setRange($raiseRange);
				$wd = new WeightedDecision();
				$wd->setDecision(WeightedDecision::RAISE, 1.0);
			}

			//The player's hand is in the call-range
			else if($callRange->getHandWeight($this->situation->player->getHand()))
			{
				$this->situation->player->setRange($callRange);
				$wd = new WeightedDecision();
				$wd->setDecision(WeightedDecision::CALL, 1.0);
			}

			//Folding to the raise
			else
			{
				$wd = new WeightedDecision();
				$wd->setDecision(WeightedDecision::FOLD, 1.0);
			}

			return $wd;
		}
	}
}
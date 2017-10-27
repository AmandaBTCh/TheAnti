<?php

namespace TheAnti\WeightedDecision;

class WeightedDecision
{
	const RAISE = 2;
	const CALL = 1;
	const CHECK = 0;
	const FOLD = -1;

	//@var array The decisions we can make, indexed by decision constant.
	protected $decisions = [];

	/*
	 * Sets the percentage for a specific decision.
	 */
	public function setDecision(int $decision, float $percent)
	{
		$this->decisions[$decision] = $percent;
	}

	/*
	 * Gets the weighted decisions.
	 */
	public function getWeightedDecision(): array
	{
		return $this->decisions;
	}

	/*
	 * Uses RNG to get the decision based on the weights.
	 * Is extremely unhappy if the totals do not add up to 1.
	 */
	public function getDecision(): int
	{
		$total = array_sum($this->decisions);

		//Eh, it doesn't have to be perfect
		if($total > 1.05|| $total < 0.95)
		{
			throw new \Exception("Total percentage of $total in a weighted decision!");
		}

		foreach($this->decisions as $decision => $percent)
		{
			//This math really isn't perfect, but I don't care
			$rand = mt_rand(0, 100);

			//Adjust the percent based on the total
			$percent = round(($percent / $total), 2);
			if($rand <= ($percent * 100))
			{
				return $decision;
			}

			//In order for the math to work right, we have to adjust the total
			else
			{
				$total = $total - $percent;
			}
		}

		/*
		 * Since the math is super inexact, there is a tiny, tiny
		 * chance that we ended up not making any decision in which
		 * case, we need to execute one at random.
		 * To make it easy, we'll lean on the site of aggression.
		 *
		 * But for now I'm going to throw an exception since it shouldnot often
		 * happen and for testing/development, I want to make sure everything is
		 * okay.
		 */
		throw new \Exception("Didn't make a decision based on weights: " . print_r($this->decisions, true) );
	}
}
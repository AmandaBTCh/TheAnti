<?php

namespace TheAnti\Strategy;
use TheAnti\Situation\Situation;
use TheAnti\WeightedDecision\WeightedDecision;

/*
 * The strategy classes each are constructed with the current
 * Situation object and have a method to determine if the
 * situation applies.
 *
 * If the situation does apply, there is a method for returning a
 * weighted decision object which has percentages for checking,
 * calling, folding, and raising.
 */
abstract class Strategy
{
	//@var Situation The situation.
	protected $situation = NULL;

	/*
	 * Creates a new strategy object with the current situation.
	 */
	public function __construct(Situation $situation)
	{
		$this->situation = $situation;
	}

	abstract function situationApplies(): bool;

	abstract function getWeightedDecision(): WeightedDecision;
}
<?php

namespace TheAnti\Range;

use TheAnti\GameElement\Hand;

/*
 * The Range class represents a range of hands that a player will have
 * in any given situation.
 *
 * It will be updated according to the situation and action during the round.
 *
 * The point of this being an abstract class is that I would like to be able to
 * have different types of ranges, both ones which use weighting and ones which don't.
 *
 * A weighted range would indicate how likely it is we have a certain hand. For example,
 * if we have AK and based on the action, we decide to call with 50% of them and raise
 * with the other 50%, and we raised, then AK in our range will be 0.5 as we will have
 * it only half of the time.
 *
 * The static ranges will simply specify whether we have the hand or not.
 * This is the type that I will implement for the first version of TheAnti.
 */
abstract class Range
{
	//@var HandWeight[] Hands in our range with a weight.
	protected $hands = [];

	/*
	 * Determines if a given hand is in our range.
	 * @return double Between 0 and 1 depending on how likely it is to be in
	 * our range.
	 */
	abstract public function containsHand(Hand $hand): double;

	/*
	 * Get hands that might be in the range.
	 */
	public function getHands(): array
	{

	}

	/*
	 * Get weighted hands in range.
	 */
}
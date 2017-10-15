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
class Range
{
	//@var HandWeight[] Hands in our range with a weight.
	protected $weightedHands = [];

	/*
	 * Gets the weight of a specific hand within our range.
	 * @return double Between 0 and 1 depending on how likely it is to be in
	 * our range.
	 */
	public function getHandWeight(Hand $hand): double
	{
		$handHash = $hand->toString();

		if(isset($this->weightedHands[$handHash]))
		{
			return $this->weightedHands[$handHash]->getWeight();
		}

		else
		{
			return 0.0;
		}
	}

	/*
	 * Gets weighted hands in our range.
	 * TODO: Figure out whether or not we should auto-remove hands with a weight of 0.
	 */
	public function getWeightedHands(): array
	{
		return $this->weightedHands;
	}

	/*
	 * Gets all hands that might be in our range.
	 * @return Hand[]
	 */
	public function getHands(): array
	{
		$hands = [];
		foreach($this->weightedHands as $weightedHand)
		{
			if($weightedHand->getWeight())
			{
				$hands[] = $weightedHand->getHand();
			}
		}
		return $hands;
	}

	/*
	 * Adds a hand weight to our range.
	 * Will overwrite what's already in the range.
	 */
	protected function addWeightedHand(WeightedHand $weightedHand)
	{
		$handHash = $weightedHand->getHand()->toString();
		$this->weightedHands[$handHash] = $weightedHand;
	}

	/*
	 * Removes a hand from the range.
	 */
	protected function removeWeightedHand(WeightedHand $weightedHand)
	{
		$handHash = $weightedHand->getHand()->toString();
		unset($this->weightedHands[$handHash]);
	}

	/*
	 * Adds a number of hand weights to our range.
	 */
	public function addWeightedHands(array $weightedHands)
	{
		foreach($weightedHands as $weightedHand)
		{
			$this->addWeightedHand($weightedHand);
		}
	}

	/*
	 * Removes an array of hands from the range.
	 */
	public function removeWeightedHands(array $weightedHands)
	{
		foreach($weightedHands as $weightedHand)
		{
			$this->removeWeightedHand($weightedHand);
		}
	}

	/*
	 * Removes hands with a specific card in them.
	 * Used to remove impossible combos from our range.
	 */
	public function removeHandWeightsWithCards(array $cards)
	{
		foreach($cards as $card)
		{
			foreach($this->weightedHands as $weightedHand)
			{
				$hand = $weightedHand->getHand();
				if($hand->hasCard($card))
				{
					$this->removeWeightedHand($weightedHand);
				}
			}
		}
	}

	/*
	 * Imports hands from file to range.
	 */
	public function importHands(string $file)
	{
		$contents = file_get_contents($file);
		$lines = explode("\n", $contents);

		foreach($lines as $line)
		{

		}
	}
}
<?php

namespace TheAnti\Range;

use TheAnti\GameElement\Hand;

/*
 * This class is used to indicate how likely it is we'll have a hand in our range.
 * A weight of 1.0 indicates we will always have the hand.
 * A weight of 0.0 indicates we will never have the hand.
 * All other values in between are effectively percentages of the likelihood we'll
 * have the hand in our range.
 */
class WeightedHand
{
	//@var Hand The hand.
	protected $hand = NULL;

	//@var double The weight indicating how likely it is we have this hand in our range.
	protected $weight = 0.0;

	/*
	 * Creates a weighted hand based on Hand and weight.
	 */
	public function __construct(Hand $hand, double $weight)
	{
		$this->hand = $hand;

		$this->setWeight($weight);
	}

	/*
	 * Gets the weight.
	 */
	public function getWeight(): double
	{
		return $this->weight;
	}

	/*
	 * Gets the hand.
	 */
	public function getHand(): Hand
	{
		return $this->hand;
	}

	/*
	 * Sets/adjusts the weight of the hand.
	 */
	public function setWeight(double $weight)
	{
		if($this->weight < 0 || $this->weight > 1)
		{
			throw new \Exception("Invalid hand weight: weight must be between 0 and 1 inclusive!");
		}

		else
		{
			$this->weight = $weight;
		}
	}
}
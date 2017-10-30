<?php

namespace TheAnti\PotOdds;

/*
 * Calculates pot-odds and continuing frequencies based on
 * pot and bet-size info.
 */
class PotOddsCalculator
{
	//@var int The pot
	protected $pot = 0;

	//@var int The bet
	protected $bet = 0;

	/*
	 * Sets up the pot and bet size for the calculator.
	 */
	public function __construct(int $pot, int $bet)
	{
		if($pot < 0)
		{
			throw new \Exception("The pot size cannot be negative!");
		}

		if($bet < 0)
		{
			throw new \Exception("The bet size cannot be negative!");
		}

		$this->pot = $pot;
		$this->bet = $bet;
	}

	/*
	 * Gets the pot odds--that is the percentage of times one has to
	 * be right in order to make a call.
	 */
	public function getPotOdds(): float
	{
		return $this->bet / ($this->pot + $this->bet * 2);
	}

	/*
	 * Gets the percentage of our range which we should continue with
	 * in order to be mathematically "unexploitable".
	 * I'm not sure this really works, but we'll see.
	 * Example A:
	 * Pot is $100
	 * Opponent bets $50
	 * We only need 25% equity to call profitably,
	 * so we call with the top 50% of our range.
	 *
	 * Example B:
	 * Pot is $100
	 * Opponent bets $500
	 * We need 45% equity to call profitably,
	 * so we call with the top 10% of our range.
	 */
	public function getContinuingFrequency(): float
	{
		return 100.0 - ($this->getPotOdds() * 2);
	}
}
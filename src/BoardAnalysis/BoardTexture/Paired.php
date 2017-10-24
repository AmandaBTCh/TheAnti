<?php

namespace TheAnti\BoardAnalysis\BoardTexture;

use TheAnti\GameElement\Board;

/*
 * Gets info about the different pairings on the board.
 * 1. Tells whether the board is paired or not.
 * 2. Returns one of several constants indicating the exact
 * board pairing type.
 */
class Paired extends BoardTexture
{
	//Board pairing constants
	const UNPAIRED = 0;
	const PAIRED = 1;
	const TRIPS = 3;
	const DOUBLE_PAIRED = 2;
	const QUADS = 4;
	const BOAT = 5;

	//Descriptions for constants (for testing)
	const DESCRIPTIONS = [
		self::UNPAIRED			=> "Unpaired",
		self::PAIRED			=> "Paired",
		self::TRIPS				=> "Trips",
		self::DOUBLE_PAIRED		=> "Double paired",
		self::QUADS				=> "Quads",
		self::BOAT				=> "Boat"
	];

	//@var array Analysis of board pairings.
	protected $pairings = [];

	public function __construct(Board $board)
	{
		parent::__construct($board);
		$this->analyzePairs();
	}

	/*
	 * Analyzes the board pairings.
	 */
	public function analyzePairs()
	{
		foreach($this->board->getCards() as $card)
		{
			$rank = $card->getRank();
			if(!isset($this->pairings[$rank]))
			{
				$this->pairings[$rank] = 1;
			}

			else
			{
				$this->pairings[$rank]++;
			}
		}
	}

	/*
	 * Determines if the board is paired.
	 * This will return true if there is any duplication of cards,
	 * even if there are quads on the board.
	 */
	public function isPaired(): bool
	{
		//This works because self::UNPAIRED is 0
		return (bool) $this->getPairingType();
	}

	/*
	 * Get the pairing type of the board.
	 * Will be one of:
	 * 1. Unpaired
	 * 2. Paired
	 * 3. Trips
	 * 4. Double Paired
	 * 5. Quads
	 * 6. Boat
	 */
	public function getPairingType(): int
	{
		//Order from low to high
		$pairs = 0;
		$trips = 0;
		$quads = 0;

		foreach($this->pairings as $num)
		{
			if($num == 2)
			{
				$pairs++;
			}

			else if($num == 3)
			{
				$trips++;
			}

			else if($num == 4)
			{
				$quads++;
			}
		}

		if($quads)
		{
			return self::QUADS;
		}

		else if($trips)
		{
			if($pairs)
			{
				return self::BOAT;
			}

			else
			{
				return self::TRIPS;
			}
		}

		else if($pairs)
		{
			if($pairs == 1)
			{
				return self::PAIRED;
			}

			else
			{
				return self::DOUBLE_PAIRED;
			}
		}

		else
		{
			return self::UNPAIRED;
		}
	}

	/*
	 * Gets the pair type description.
	 * For testing and possibly the GUI.
	 */
	public function getPairingTypeDesc(): string
	{
		$pType = $this->getPairingType();
		return self::DESCRIPTIONS[$pType];
	}
}
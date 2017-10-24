<?php

namespace TheAnti\Match;

/*
 * The class that defines the settings for a specific poker match
 * between a human and computer player.
 */
class Settings
{
	//@var int Bankroll of players
	protected $bankroll = 10000;

	//@var int Stack sizes for the match in BB.
	protected $stackSize = 200;

	//@var int The big blind
	protected $bb = 2;

	//@var int The small blind
	protected $sb = 1;

	/*
	 * Gets the stack sizes for the match in BB.
	 */
	public function getStackSize(): int
	{
		return $this->stackSize;
	}

	/*
	 * Gets the starting stack size.
	 */
	public function getStartingStackSize(): int
	{
		return $this->bb * $this->stackSize;
	}

	/*
	 * Gets an array of blinds.
	 */
	public function getBlinds()
	{
		return [$this->bb, $this->sb];
	}

	/*
	 * The stack size in BB must be at least 20.
	 */
	public function setStackSize(int $bb)
	{
		$this->stackSize = max($bb, 20);
	}

	/*
	 * BB must be 2 or more, and SB must not be greater than the BB.
	 * Passing in 5, will result in a 2/5 game
	 * 6 => 3/6
	 * 25 => 12/25
	 * 25, 5 => 5/25
	 * 2, 0 => 1/2
	 */
	public function setBlinds(int $bb, int $sb = NULL)
	{
		$this->bb = max($bb, 2);

		if($sb)
		{
			$this->sb = min($sb, $this->bb);
		}

		else
		{
			$this->sb = floor($this->bb / 2);
		}
	}

	/*
	 * Sets the bankroll of each player.
	 * Must be at least the size of the starting stack.
	 */
	public function setBankroll(int $br)
	{
		$this->bankroll = max($br, $this->getStartingStackSize());
	}
}
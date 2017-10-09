<?php

namespace TheAnti\Match;

/*
 * The class that defines the settings for a specific poker match
 * between a human and computer player.
 */
class Settings
{
	//Stack sizes for the match in BB.
	protected $stackSize = 200;

	//The big blind
	protected $bb = 2;

	//If small blind
	protected $sb = 1;

	public function getStackSize(): int
	{
		return $this->stackSize;
	}

	public function getStartingStackSize(): int
	{
		return $this->bb * $this->stackSize;
	}

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
}
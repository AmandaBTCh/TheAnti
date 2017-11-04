<?php

namespace TheAnti\Player;

use TheAnti\Situation\Situation;

class Human extends Player
{
	public function makeDecision(Situation $situation): int
	{
		$this->setFolded();
		return 0;
	}
}
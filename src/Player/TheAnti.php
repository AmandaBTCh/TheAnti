<?php

namespace TheAnti\Player;

use TheAnti\Situation\Situation;

class TheAnti extends Computer
{
	public function makeDecision(Situation $situation): int
	{
		//Super nit
		$this->setFolded();
		return 0;
	}
}
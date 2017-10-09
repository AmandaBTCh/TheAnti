<?php

namespace TheAnti\Player;

/*
 * The abstract base class for all players, both human and computer.
 */
abstract class Player
{
	//The stack of the player.
	protected $stack = 0;

	//Constructs a player with a stack.
	public function __construct(int $stack)
	{
		$this->stack = $stack;
	}
}
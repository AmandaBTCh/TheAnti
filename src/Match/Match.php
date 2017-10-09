<?php

namespace TheAnti\Match;

use TheAnti\Player\Human;
use TheAnti\Player\TheAnti;

/*
 * The class that represents a match between a human and computer player.
 */
class Match
{
	//@var TheAnti\Player\Player[] The poker players 0 => human, 1 => computer
	protected $players = [];

	//@var Settings The settings for the match
	protected $settings;

	/*
	 * Prepares the match with the settings and players.
	 */
	public function __construct(Settings $settings)
	{
		$this->settings = $settings;

		$this->setupPlayers();
	}

	public function setupPlayers()
	{
		$this->players[0] = new Human($this->settings->getStartingStackSize());
		$this->players[1] = new TheAnti($this->settings->getStartingStackSize());
	}
}









<?php

namespace TheAnti\Match;

use TheAnti\Player\Human;
use TheAnti\Player\TheAnti;
use TheAnti\Tool\Prompt;

/*
 * The class that represents a match between a human and computer player.
 */
class Match
{
	//@var Player[] The poker players 0 => human, 1 => computer
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

	/*
	 * Gets the settings.
	 */
	public function getSettings(): Settings
	{
		return $this->settings;
	}

	/*
	 * Starts the match!
	 * Keeps on playing rounds
	 * until there is either no money left
	 * or the human decides to quit.
	 */
	public function start()
	{
		$prompt = new Prompt();
		while($prompt->getYesNo("Would you like to start a new round? (y/n): "))
		{
			$round = new Round($this);
			$round->start();
		}
	}

	/*
	 * Sets up players.
	 */
	protected function setupPlayers()
	{
		$this->players[0] = new Human($this->settings->getStartingStackSize(), $this->settings->getBankroll());
		$this->players[1] = new TheAnti($this->settings->getStartingStackSize(), $this->settings->getBankroll());
	}

	/*
	 * Gets the array of players.
	 */
	public function getPlayers(): array
	{
		return $this->players;
	}

	/*
	 * Moves the button.
	 * (Updates player position)
	 */
	public function moveButton()
	{
		$this->players = array_reverse($this->players);
	}
}









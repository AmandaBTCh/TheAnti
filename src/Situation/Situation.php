<?php

namespace TheAnti\Situation;

/*
 * Represents the current situation in a round.
 * This is used by the AI/Human in order to make decisions.
 * It's currently more of a struct than a class,
 * as I really only need a convenient way to pass a bunch of assorted info
 * around.
 * This will be updated later.
 */
class Situation
{
	//@var int The pot
	public $pot = 0;

	//@var int The player index for the player this gets passed to.
	public $playerIndex = NULL;

	//@var Player The primary player.
	public $player = NULL;

	//@var Player The opponent player.
	public $opponent = NULL;

	//@var Action The action that has taken place so far.
	public $action = NULL;

	//@var HandAnalyser Info about the hand.
	public $handAnalyzer = NULL;

	//@var BoardAnalyze Info ab out the board.
	public $boardAnalyzer = NULL;

	//@var HandStrengthCalculator Gets the equity of our hand against our range.
	public $handStrengthCalculator = NULL;

	//@var SPRAnalyzer Gets info about the player's stacks vs. the pot
	public $sprAnalyzer = NULL;

	//@var PotOddsCalculator Gets info about pot odds.
	public $potOddsCalculator = NULL;
}
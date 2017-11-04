<?php

namespace TheAnti\Situation;

class Situation
{
	//@var Action The action that has taken place so far.
	protected $action = NULL;

	//@var HandAnalyser Info about the hand.
	protected $handAnalyzer = NULL;

	//@var BoardAnalyzer Info ab out the board.
	protected $boardAnalyzer = NULL;

	//@var HandStrengthCalculator Gets the equity of our hand against our range.
	protected $handStrengthCalculator = NULL;

	//@var SPRAnalyzer Gets info about the player's stacks vs. the pot
	protected $sprAnalyzer = NULL;
}
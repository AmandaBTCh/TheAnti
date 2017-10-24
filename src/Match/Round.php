<?php

namespace TheAnti\Match;

/*
 * This class represents a round of Texas Hold'em.
 */
class Round
{
	//@var Match The match we're in
	protected $match = NULL;

	/*
	 * Creates a new round.
	 */
	public function __construct(Match $match)
	{
		$this->match = $match;
	}

	/*
	 * Starts the round!
	 */
	public function start()
	{
		print "Starting round...\n";
	}
}
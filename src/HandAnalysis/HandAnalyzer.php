<?php

namespace TheAnti\HandAnalysis;

use TheAnti\GameElement\Hand;
use TheAnti\GameElement\Card;

/*
 * Gets information about a hand based on the
 * following criteria:
 * 1. Suited: Suited, Unsuited
 * 2. Paired: Paired, Unpaired
 * 3. Connected:
 * 		A. Number of straights we can flop (max = 49T, min = 0)
 * 		B. Distance between cards (max = 6, min = 0)
 * 4. High: Rank of highest card in hand (max = 13, min = 2)
 */
class HandAnalyzer
{
	protected $hand = NULL;
}
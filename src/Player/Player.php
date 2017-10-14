<?php

namespace TheAnti\Player;

use TheAnti\GameElement\Card;
use TheAnti\GameElement\Hand;

/*
 * The abstract base class for all players, both human and computer.
 */
abstract class Player
{
	//The stack of the player.
	protected $stack = 0;

	//@var Hand The player's hand.
	protected $hand = NULL;

	/*
	 * Creates a player with a stack.
	 */
	public function __construct(int $stack)
	{
		$this->stack = $stack;
	}

	/*
	 * Gets the player's stack.
	 */
	public function getStack(): int
	{
		return $this->stack;
	}

	/*
	 * Sets the player's hand.
	 */
	public function setHand(Hand $hand)
	{
		$this->hand = $hand;
	}

	/*
	 * Gets the player's hand.
	 */
	public function getHand(): Hand
	{
		return $this->hand;
	}

	/*
	 * Applies a decision to the player which will
	 * affect the game/player's decision history and
	 * also possibly the player's stack.
	 * @return The size of the stack after the decision was made.
	 * @todo Implement the Decision objects(s) or something similar.
	 */
	public function applyDecision($decision): int
	{
		return $this->stack;
	}

	/*
	 * Based on the situation in the match, this determines what decision will
	 * be made by the player.
	 * For human players, this will of course, be showing them the situation
	 * and asking for a decision via command entry.
	 * For the computer players, this will be performed based on the various
	 * logic/strategy classes that have not yet been implemented.
	 * @todo Implement the situation/logic/strategy classes or something similar.
	 */
	abstract public function makeDecision($situation);
}
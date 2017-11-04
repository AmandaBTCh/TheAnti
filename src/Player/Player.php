<?php

namespace TheAnti\Player;

use TheAnti\GameElement\Hand;
use TheAnti\Range\Range;

/*
 * The abstract base class for all players, both human and computer.
 */
abstract class Player
{
	//@var int The player's bankroll.
	protected $bankroll = 0;

	//@var int The stack of the player.
	protected $stack = 0;

	//@var Hand The player's hand.
	protected $hand = NULL;

	//@var Range The player's range/perceived range.
	protected $range = NULL;

	//@var bool Specifies if the player has folded.
	protected $folded = false;

	/*
	 * Creates a player with a stack.
	 */
	public function __construct(int $stack, int $bankroll = 0)
	{
		$this->setStack($stack);
		$this->setBankroll($bankroll);
	}

	/*
	 * Sets the players stack size.
	 */
	public function setStack(int $stack)
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
	 * Sets the player's bankroll.
	 */
	public function setBankroll(int $br = 0)
	{
		//Default the bankroll to 10 times the stack size
		$bankroll = $br ?: $this->stack * 10;
		$this->bankroll = $bankroll;
	}

	/*
	 * Gets the player's bankroll.
	 */
	public function getBankroll(): int
	{
		return $this->bankroll;
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
	 * Gets the players range.
	 */
	public function getRange(): Range
	{
		return $this->range;
	}

	/*
	 * Sets the player's range.
	 */
	public function setRange(Range $range)
	{
		$this->range = $range;
	}

	/*
	 * Broadcasts a message to/from this player.
	 */
	public function broadcast(string $message)
	{
		$reflection = new \ReflectionClass($this);
		print $reflection->getShortName() . ": $message\n";
	}

	/*
	 * Determines if the player has folded.
	 */
	public function isFolded(): bool
	{
		return $this->folded;
	}

	/*
	 * Sets the player to be folded or unfolded.
	 */
	public function setFolded(bool $folded = true)
	{
		$this->folded = $folded;
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
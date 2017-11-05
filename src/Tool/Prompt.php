<?php

namespace TheAnti\Tool;

/*
 * A tool for getting input from the user.
 */
class Prompt
{
	/*
	 * Gets an integer from the user.
	 */
	public function getInt(string $prompt): int
	{
		//Keep asking till we get a valid input
		while(!is_numeric($line = readline($prompt)));
		return (int) $line;
	}

	/*
	 * Gets a Yes or a No from the user.
	 */
	public function getYesNo(string $prompt): bool
	{
		//Keep asking till we get something starting in a y or n
		while(!in_array($answer = strtolower(readline($prompt)[0]), ['y', 'n']));
		return $answer == 'y';
	}

	/*
	 * Gets an action in a poker hand.
	 */
	public function getAction(array $actions): string
	{
		$actionsString = implode("|", $actions);
		$valid = false;
		do
		{
			$action = trim(strtolower(readline("Make decision ($actionsString): ")));
			if($action == "check" && in_array($action, $actions))
			{
				$valid = true;
			}

			else if($action == "call" && in_array($action, $actions))
			{
				$valid = true;
			}

			else if($action == "fold" && in_array($action, $actions))
			{
				$valid = true;
			}

			else if(preg_match("/raise [0-9]+/", $action) && in_array("raise", $actions))
			{
				$valid = true;
				$action = explode(" ", $action)[1];
			}
		} while(!$valid);

		return $action;
	}
}
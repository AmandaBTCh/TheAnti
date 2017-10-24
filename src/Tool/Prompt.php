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
}
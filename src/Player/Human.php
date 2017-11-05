<?php

namespace TheAnti\Player;

use TheAnti\Situation\Situation;
use TheAnti\Tool\Prompt;

class Human extends Player
{
	public function makeDecision(Situation $situation): int
	{
		print "\n";
		//Display info about the pot, stacks, and actions allowed
		print "The pot is $" . $situation->pot . ".\n";
		print "Your stack is $" . $this->stack . ".\n";

		//Get the amount needed to call
		$callAmount = $situation->action->getCallAmountForPlayer($situation->playerIndex);

		//Facing a raise
		if($callAmount)
		{
			print "Amount needed to continue: $$callAmount.\n";
			print "Pot odds: " . $situation->potOddsCalculator->getPotOdds() . ".\n";
			print "You should continue with " . $situation->potOddsCalculator->getContinuingFrequency() . "% of your range.\n";

			$prompt = new Prompt();
			$action = $prompt->getAction(["call", "raise", "fold"]);

			if($action == "call")
			{
				return $callAmount;
			}

			else if($action == "fold")
			{
				return 0;
			}

			else if(is_numeric($action))
			{
				return (int) $action;
			}

			throw new \Exception(("Invalid action $action"));
		}

		//Not facing a raise
		else
		{
			$prompt = new Prompt();
			$action = $prompt->getAction(["check", "raise"]);

			if($action == "check")
			{
				return 0;
			}

			else if(is_numeric($action))
			{
				return (int) $action;
			}

			throw new \Exception(("Invalid action $action"));
		}
	}
}
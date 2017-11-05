<?php

namespace TheAnti\Strategy;

/*
 * For a given situation, finds the strategy(s) to use.
 */
use TheAnti\Situation\Situation;

class StrategyManager
{
	//@var Situation The situation.
	protected $situation = NULL;

	/*
	 * Constructor.
	 */
	public function __construct(Situation $situation)
	{
		$this->situation = $situation;
	}

	/*
	 * Gets all strategies that we should use given the situation.
	 */
	public function getStrategies(): array
	{
		$allStrategies = $this->getAllStrategies();
		$strategies = [];
		foreach($allStrategies as $strategy)
		{
			if($strategy->situationApplies())
			{
				$strategies[] = $strategy;
			}
		}
		return $strategies;
	}

	/*
	 * Gets all strategy class instances.
	 */
	public function getAllStrategies(): array
	{
		$strategyFolder = new \RecursiveDirectoryIterator(__DIR__);
		$strategyFiles = new \RecursiveIteratorIterator($strategyFolder);

		$strategies = [];
		foreach($strategyFiles as $strategyFile)
		{
			$className = "TheAnti\\Strategy\\" . basename($strategyFile, ".php");
			if(is_subclass_of($className, "TheAnti\\Strategy\\Strategy"))
			{
				$strategies[] = new $className($this->situation);
			}
		}
		return $strategies;
	}
}
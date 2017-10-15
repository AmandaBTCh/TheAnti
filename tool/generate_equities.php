<?php

/*
 * Is called via HTTP and exec's the executable to generate a file of
 * equities based on an optional board.
 * Running the command from the same process causes the terminal to run
 * for an interminably long amount of time if the terminal is the active window.
 */

$omp = $_GET["omp"];
$handFile = $_GET["handFile"];
$board = $_GET["board"] ?? "";

//If we weren't given a board, return the preflop equity file
if($board == "" && file_exists("equities/pre.txt"))
{
	print file_get_contents("equities/pre.txt");
}

else
{
	$command = "{$omp} {$handFile} {$board}";

	ob_start();
	system($command);
	$results = ob_get_clean();

	$results = chop($results);

	//Cache preflop equities
	if($board == "")
	{
		file_put_contents("equities/pre.txt", $results);
	}

	print $results;
}

exit;

?>
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

$command = "{$omp} {$handFile} {$board}";
system($command);

?>
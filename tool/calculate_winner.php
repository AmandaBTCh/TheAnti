<?php

/*
 * Is called via HTTP and exec's the executable to determine
 * the winner at the end of a hand.
 * 0 = first player, 1 = second player, -1 = tie
 */

$omp = $_GET["omp"];
$hand1 = $_GET["hand1"];
$hand2 = $_GET["hand2"];
$board = $_GET["board"];

$command = "{$omp} {$hand1} {$hand2} {$board}";

system($command);

exit;

?>
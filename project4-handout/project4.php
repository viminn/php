<!DOCTYPE html>
<!--
Aidan Lapenta
CSC 242, Fall 2022, Assignment 4
Due 20 October
Program takes a csv file and converts it to an html table styled with css.
-->

<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<title>Zoo Animals</title>
</head>
<body>
	<h1>Beautiful HTML Table</h1>

<?php
	
/*
The first line of the csv is the headers/ labels for each row. Takes the array of the first line
	and prints each array element as a table header column in the header row
Param: $header - An array of the first line of the file exploded over the comma separator
Returns: Prints each header as a header in the table through html
*/
function makeHeader($header) {
	print_r("<thead>\n<tr>\n");
	foreach ($header as $titles) {
		print_r("<th>" . $titles . "</th>\n");
	}
	print_r("</tr>\n</thead>\n");
}

/*
Takes the array of the rest of the file, makes a table row for each line of the file, explodes each line
	by the comma separator, and puts each comma-separated-value into a cell of the table
Param: $data - The csv file with the first line, the header, removed
Returns: Prints html to put each value of the file into a table
*/
function makeCells($data) {
	foreach ($data as $rows) {
		print_r("<tr>\n");

		$arrayCells = explode(",", $rows);

		foreach($arrayCells as $splitCells) {
			print_r("<td>" . $splitCells . "</td>\n");
		}
		print_r("</tr>\n");
	}
}

$data = file("animals.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

print_r("<table>\n");

$header = explode("," , array_shift($data));

makeHeader($header);
makeCells($data);

print_r("</table>");
?>

</body>
</html>

<!DOCTYPE html>
<!--
Aidan La Penta
CSC 242 010
Dr. Schwesinger
Project 5
27 Oct 2022
Program will take a user search from an html form and return the relevant data
	filtered from a csv file as a table.
Source: https://stackoverflow.com/questions/2368027/php-sort-an-object-by-two-criteria
	Used for syntax of using the spaceship operator to sort with two criteria
-->

<html lang="en">
<head>
  <meta charset = "utf-8">
  <link rel = "stylesheet" href = "style.css">
  <title>Animals</title>
</head>
<body>

<h1>Zoo Information</h1>

<form action="project5.php" method="get">
  <select name="type">
    <option value="class">Class</option>
    <option value="status">Status</option>
  </select>
  <input type="text" name="term">
  <input type="submit" value="Search">
</form>

<?php
/*
If the search is invalid, prints an error message and valid inputs for classes
	or statuses
Param: $classes, $statuses - Each are an array of the classes and statuses
	found in the input file
Return: None, prints error message to html page
*/
function throwError($classes, $statuses) {
	if ($_GET["type"] == "class") {
		print_r("<p>Error: Invalid class. Valid classes:</p>\n<ul>");
		foreach ($classes as $class) {
			print_r("<li>$class</li>\n");
		}
		print_r("</ul>");
	}
	if ($_GET["type"] == "status") {
		print_r("<p>Error: Invalid status. Valid statuses:</p>\n<ul>");
		foreach ($statuses as $status) {
			print_r("<li>$status</li>\n");
		}
		print_r("</ul>");
	}
}
/*
The first line of the csv is the headers/ labels for each row. Takes the array of the first line
        and prints each array element as a table header column in the header row
Param: $header - An array of the first line of the file exploded over the comma separator
Returns: None, prints each header as a header in the table through html
*/
function makeHeader($header) {
        print_r("<thead>\n<tr>\n");
        foreach ($header as $titles) {
                print_r("<th>" . $titles . "</th>\n");
        }
        print_r("</tr>\n</thead>\n");
}
/*
Takes the array of the rest of the file, makes a table row for each line of the file, 
	and puts each comma-separated-value into a cell of the table
Param: $data - The array of the csv file with the first line, the header, removed
Returns: None, prints html to put each value of the relevant data into a table
*/
function makeCells($data) {
        foreach ($data as $rows) {
		print_r("<tr>\n");
                foreach($rows as $cells) {
                        print_r("<td>" . $cells . "</td>\n");
                }
                print_r("</tr>\n");
        }
}

// Read the file ignoring empty space and separates values into an array
$data = file("animals.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$data = array_map(fn($x) => explode(",", $x), $data);
// Take out the first header line
$header = array_shift($data);

$classes = array();
$statuses = array();
$tableArray = array();

// Take every valid class and status from the file
foreach ($data as $line) {
	$classes[] = $line[1];
	$statuses[] = $line[2];
}
// Take the set of the array and aggregate valid searches to check against
$classes = array_unique($classes);
$statuses = array_unique($statuses);
$validInput = array_merge($classes, $statuses);

// If no search term is submitted, throw an error and list valid options
if (!in_array($_GET["term"], $validInput)) {
	throwError($classes, $statuses);	
}

else {
	// Filter the remaining data by the search term over the
	//	class or status
	$tableArray = array_filter($data, function($k) {
		return $k[1] == $_GET["term"] || $k[2] == $_GET["term"];
	});

	// Sourced from mickmackusa on stackoverflow
	// Sorts first by total then by name, flipping the a and b in the second
	// 	criteria will sort by descending alphabetical order
	usort($tableArray, function($a, $b) {
	    return ([$b[3], $a[0]] <=> [$a[3], $b[0]]);
	});

	print_r("<table>");
	makeHeader($header);
	makeCells($tableArray);
	print_r("</table>");
}
?>

</body>
</html>

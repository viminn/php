<?php

function printTable($data) {
    if (count($data) === 0) {
        return;
    }
    $header = array_keys($data[0]);
    print "<table>\n";
    print "<thead>";
    foreach ($header as $h) {
        print "<th>$h</th>";
    }
    print "</thead>\n";
    foreach ($data as $record) {
        $values = array_values($record);
        print "<tr>";
        foreach ($values as $v) {
            print "<td>$v</td>";
        }
        print "</tr>\n";
    }
    print "</table>";
}

function printReviewTable($data) {
    if (count($data) === 0) {
        return;
    }
    $header = array_keys($data[0]);
    print "<table>\n";
    print "<thead>";
    foreach ($header as $h) {
        print "<th>$h</th>";
    }
    print "<th></th>";
    print "</thead>\n";
    foreach ($data as $record) {
        $values = array_values($record);
        $locationName = $record["Location Name"];
        $linkString = "<a href='viewReviews.php?location=$record[locationID]&name=$locationName'>view</a>";
        print "<tr>";
        foreach ($values as $v) {
            print "<td>$v</td>";
	    }
	    print("<td>$linkString</td>");
         print "</tr>\n";
    }
    print "</table>";
}

function printFormTable($data) {
    if (count($data) === 0) {
        return;
    }
    $header = array_keys($data[0]);
    print "<table>\n";
    print "<thead>";
    print "<th>Select</th>";
    foreach ($header as $h) {
        print "<th>$h</th>";
    }
    print "</thead>\n";
    foreach ($data as $record) {
        $values = array_values($record);
        $form_value = implode(',', $values);
        print "<tr>";
        print "<td><input type=\"checkbox\" name=\"rows[]\" value=\"$form_value\"></td>";
        foreach ($values as $v) {
            print "<td>$v</td>";
        }
        print "</tr>\n";
    }
    print "</table>";
}

function createAcct($name, $password) {

    // try to insert into the database
    // if an error occurs return FALSE
    try {
        $db =  new PDO("sqlite:review.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO tbUser VALUES (NULL, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$name, $password]);
        return TRUE;
    }
    catch (Exception $e) {
        print "<p>$e</p>";
        return FALSE;
    }
}

function createLocation($name, $address, $city, $state, $zip) {

    // try to insert into the database
    // if an error occurs return FALSE
    try {
        $db =  new PDO("sqlite:review.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO tbLocation VALUES (NULL, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$name, $address, $city, $state, $zip]);
        return TRUE;
    }
    catch (Exception $e) {
        print "<p>$e</p>";
        return FALSE;
    }
}
/* Function Name: getUserRecord
 * Description: get user information from the database
 * Parameters: (string) $email: the user's email
 *             (string) $password: the user's password
 * Return Value: (array) The user's record if it exists, otherwise an empty
 *               array
 */
function getUserRecord($username, $password) {

    // try to insert into the database
    // if an error occurs return FALSE
    try {
        $db = new PDO("sqlite:review.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM tbUser WHERE username=? and password=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$username, $password]);
        // there should only be a single record
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        print "<p>$e</p>";
        return array();
    }
}


?>

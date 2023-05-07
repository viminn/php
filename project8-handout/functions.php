<?php

function printTable($data) {
    if (count($data) === 0) {
        return;
    }
    $header = array_keys($data[0]);
    print "<table>\n";
    print "<tr>";
    foreach ($header as $h) {
        print "<th>$h</th>";
    }
    print "</tr>\n";
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

function printFormTable($data) {
    if (count($data) === 0) {
        return;
    }
    $header = array_keys($data[0]);
    print "<table>\n";
    print "<tr>";
    print "<th>Select</th>";
    foreach ($header as $h) {
        print "<th>$h</th>";
    }
    print "</tr>\n";
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


?>

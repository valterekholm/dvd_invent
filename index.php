<!doctype html>
<html>
    <head>
        <title>DVD-fodral med skivor</title>
</head>
<body>
    <pre>
<?php
include "db.php";
include "print_tables.php";

$db = new db();

$sql_dvds = "SELECT * FROM dvd_case";
$res_dvds = $db->select_query($sql_dvds);
$rows_dvds = $res_dvds->fetchAll();


print_rows_table($rows_dvds, true, array(), array("id"));

?>
</pre>
</body>
</html>

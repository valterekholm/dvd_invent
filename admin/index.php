<!doctype html>
<html>
    <head>
        <title>DVD-fodral med skivor</title>
        <style>
            .hide_first_col td:first-child, .hide_first_col th:first-child{
                display: none;
            }
        </style>
    </head>
<body>

<?php
include "../db.php";
include "edit.php";
include "../print_tables.php";
$table_name = "dvd_case";

$db = new db();



if(!empty($_GET["id"]) && empty($_GET["delete"])){ //edit

    $id = $_GET["id"];

    $sql_dvd = "SELECT * FROM dvd_case WHERE id = $id";
    $res_dvd = $db->select_query($sql_dvd);
    $row_dvd = $res_dvd->fetch();
    edit_form_id($id, $row_dvd);
}

if(!empty($_POST["id"])){ //update
    $id = $_POST["id"];
    $POST = $_POST;
    //echo "Got post for id $id<br>";

    $sql_update = "UPDATE " . $db->get_db_name() . ".$table_name SET ";

    $values = array();

    foreach($POST as $key=>$value){
        if($key == "id") continue;

        if(is_numeric($value)){
            //$sql_update .= "$key = $value,";
        }
        else{
            //$sql_update .= "$key = '$value',";
        }

        $sql_update .= "$key = ?,";

        $values[] = $value;
        
    }
    $sql_update = rtrim($sql_update, ',');

    $sql_update .= " WHERE id = ?";
    $values[]=$id;

    //echo $sql_update;
    //print_r($values);
    $row_count = $db->update_query($sql_update, $values, false);
    if($row_count > 0){
        echo "<p>Row was updated, please reload <a href='index.php'>here</a>";
        header("refresh: 0");
    }
}

//add new
if(empty($_POST["id"]) && !empty($_POST["title"])){
    echo "add";
    $values = array();//for sql placeh
    $title = $_POST["title"];

    $values[]=$title;

    $sql_add = "INSERT INTO " . $db->get_db_name() . ".$table_name (title";

    if(!empty($_POST["quantity"])){
        $q = $_POST["quantity"];
        $sql_add .= ", quantity";
    }
    else $q = "";

    $sql_add .= ") VALUES (?";

    if(!empty($q)){
        $sql_add .= ", ?";
        $values[]=$q;
    }

    $sql_add .= ")";

    echo $sql_add;

    $insert_count = $db->insert_query($sql_add, $values, false);

    if($insert_count>0){
        echo "<p>Row inserted, please reload <a href='index.php'>here</a></p>";
        header("refresh: 0");
    }
}

//delete
if(!empty($_GET["delete"])){
    if($_GET["delete"] == "yes"){
        if(!empty($_GET["id"])){
            $del_id = $_GET["id"];

            $sql_del = "DELETE FROM " . $db->get_db_name() . ".$table_name WHERE id = ?";
            $values = array($del_id);
            $row_count =$db->update_query($sql_del, $values, false);
            echo "Delete row count: $row_count";
            if($row_count > 0){
                echo "<p>Row was deleted, please reload <a href='index.php'>here</a></p>";
                //header("refresh: 0");
                header("Location: {$_SERVER['PHP_SELF']}");
            }
        }
    }
}

$sql_dvds = "SELECT * FROM $table_name";
$res_dvds = $db->select_query($sql_dvds);
$rows_dvds = $res_dvds->fetchAll();


print_rows_table_admin($rows_dvds, true, array("class"=>"hide_first_col"));

$fields_dvd = get_fields_from_rows($rows_dvds);
?>
<div class="add">
<?php
add_form($fields_dvd, array("id", "insert_date")); //render a form
?>
</div>




</body>
</html>


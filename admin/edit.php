<?php

//offer editing forms...

function edit_form_id($id, $row, $ignore_field = "insert_date"){
    echo "<form action='index.php' method='post'>";

    $label_ = "label";
    $field1_ = "input";
    foreach($row as $key=>$value){
        if($key == $ignore_field){
            echo "<br>";
            continue;
        }



        echo "<$label_>$key</$label_>";
        echo "<br>";
        echo "<$field1_ value='$value' name='$key'>";
        echo "<br>";
    }
    echo "<input type='submit'>";
    echo "</form>";

}

function get_fields_from_rows($rows){
    $fields = array();
    foreach($rows as $row){
        $_link = "index.php?id=" . $row["id"];
        foreach($row as $key=>$value){
            $fields[] = $key;
        }
        break;
    }
    return $fields;
}

function add_form($fields, $ignore_field = array("insert_date", "id")){
    echo "<form action='index.php' method='post'>";
    echo "<h2>Add</h2>";
    foreach($fields as $field){
        if(in_array($field, $ignore_field)){
            continue;
        }
        echo "<span>$field</span>" . "<br>";
        echo "<input name='$field'>" . "<br>";
    }
    echo "<input type='submit'>";
    echo "</form>";
}
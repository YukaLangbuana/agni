<?php

$db = pg_connect("host=localhost dbname=daemon user=postgres password=root");

$output = '';

if(isset($_POST["state_code"], $_POST["city_name"], $_POST["zipcode"], $_POST["category"])){
    $output .= "<option value=".">Select Business</option>";
    if($_POST["state_code"] != '' && $_POST["city_name"] != '' && $_POST["zipcode"] != '' && $_POST["category"] != ''){
        $sql = "SELECT business.name FROM business JOIN category ON business.busID=category.busID WHERE state='".$_POST["state_code"]."' AND city='".$_POST["city_name"]."' AND zipcode=".$_POST["zipcode"]." AND category.category_name='".$_POST["category"]."'";
    }
    else{
        $sql = "SELECT name FROM business ORDER BY name";
    }
    $result = pg_query($db, $sql);

    while($row = pg_fetch_row($result)) {
        $output .= "<option value='".$row[0]."'>".$row[0]."</option>";
    }

    echo $output;
}
elseif(isset($_POST["state_code"], $_POST["city_name"], $_POST["zipcode"], $_POST["business"])){
    $output .= "<option value=".">Select Category</option>";
    if($_POST["state_code"] != '' && $_POST["city_name"] != '' && $_POST["zipcode"] != '' && $_POST["business"] != ''){
        $sql = "SELECT DISTINCT category_name FROM category WHERE busID IN (SELECT busID from business WHERE state='".$_POST["state_code"]."' AND city='".$_POST["city_name"]."' AND zipcode=".$_POST["zipcode"].")";
    }
    else{
        $sql = "SELECT DISTINCT category_name FROM category";
    }
    $result = pg_query($db, $sql);

    while($row = pg_fetch_row($result)) {
        $output .= "<option value='".$row[0]."'>".$row[0]."</option>";
    }

    echo $output;
}
elseif(isset($_POST["state_code"], $_POST["city_name"], $_POST["zipcode"])){
    $output .= "<option value=".">Select Business</option>";
    if($_POST["state_code"] != '' && $_POST["city_name"] != '' && $_POST["zipcode"] != '' ){
        $sql = "SELECT name FROM business WHERE state='".$_POST["state_code"]."' AND city='".$_POST["city_name"]."' AND zipcode=".$_POST["zipcode"];
        echo $sql;
    }
    else{
        $sql = "SELECT name FROM business ORDER BY name";
    }
    $result = pg_query($db, $sql);

    while($row = pg_fetch_row($result)) {
        $output .= "<option value='".$row[0]."'>".$row[0]."</option>";
    }

    echo $output;
}
elseif(isset($_POST["state_code"], $_POST["city_name"])){
    $output .= "<option value=".">Select Zipcode</option>";
    if($_POST["state_code"] != '' && $_POST["city_name"] != '' ){
        $sql = "SELECT DISTINCT zipcode FROM business WHERE state = '".$_POST["state_code"]."' AND city = '".$_POST["city_name"]."' ORDER BY zipcode";
    }
    else{
        $sql = "SELECT DISTINCT zipcode FROM business ORDER BY zipcode";
    }
    $result = pg_query($db, $sql);

    while($row = pg_fetch_row($result)) {
        $output .= "<option value='".$row[0]."'>".$row[0]."</option>";
    }

    echo $output;
}
elseif(isset($_POST["state_code"])){
    $output .= "<option value=".">Select City</option>";
    if($_POST["state_code"] != ''){
        $sql = "SELECT DISTINCT city FROM business WHERE state = '".$_POST["state_code"]."' ORDER BY city";
    }
    else{
        $sql = "SELECT DISTINCT city FROM business ORDER BY city";
    }
    $result = pg_query($db, $sql);

    while($row = pg_fetch_row($result)) {
        $output .= "<option value='".$row[0]."'>".$row[0]."</option>";
    }

    echo $output;
}



?>
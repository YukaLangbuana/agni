<?php

$db = pg_connect(getenv("DATABASE_URL"));

$output = '';

if(isset($_POST["state_code"])){
    if($_POST["state_code"] != ''){
        $sql = "SELECT DISTINCT city FROM business WHERE state = '".$_POST["state_code"]."' ORDER BY city";
    }
    else{
        $sql = "SELECT DISTINCT city FROM business";
    }
    $result = pg_query($db, $sql);

    while($row = pg_fetch_row($result)) {
        $output .= "<option value='".$row[0]."'>".$row[0]."</option>";
    }

    echo $output;
}

?>
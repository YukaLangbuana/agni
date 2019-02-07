<?php

$db = pg_connect(getenv("DATABASE_URL"));

$output = '';

if(isset($_POST["state_code"], $_POST["city"])){
    if($_POST["state_code"] != ''){
        $sql = "SELECT * FROM business WHERE state = '".$_POST["state_code"]."' AND city = '".$_POST["city"]."'";
    }
    $result = pg_query($db, $sql);

    while($row = pg_fetch_row($result)) {
        $output .= "<tr><td>'".$row[0]."'</td><td>'".$row[1]."'</td><td>'".$row[2]."'</td></tr>";
    }

    echo $output;
}

?>
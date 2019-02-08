<?php

$db = pg_connect(getenv("DATABASE_URL"));

$output = '';

if(isset($_POST["state_code"], $_POST["city"])){
    if($_POST["state_code"] != ''){
        $sql = "SELECT name FROM business WHERE state = '".$_POST["state_code"]."' AND city = '".$_POST["city"]."' ORDER BY name";
    }
    $result = pg_query($db, $sql);

    while($row = pg_fetch_row($result)) {
        $output .= "<tr><td>".$row[0]."</td><td>".$_POST["state_code"]."</td><td>".$_POST["city"]."</td></tr>";
    }

    echo $output;
}

?>
<?php

$db = pg_connect("host=localhost dbname=daemon user=postgres password=root");

$output = '';

if(isset($_POST["rating"], $_POST["review"], $_POST["business_name"], $_POST["city_name"], $_POST["zipcode"])){
    if($_POST["rating"] != '' && $_POST["review"] != '' && $_POST["business_name"] != '' && $_POST["city_name"] != '' && $_POST["zipcode"] != ''){
        $uniqueID = uniqid();
        $sql = "INSERT INTO review (reviewid, userid, busid, date, stars, text, useful, funny, cool) 
                VALUES ('".$uniqueID."', 'T5MGS0NHBCWgofZ6Q6Btng', (SELECT busID FROM business WHERE city = '".$_POST["city_name"]."' AND zipcode='".$_POST["zipcode"]."' AND name='".$_POST["business_name"]."'), '2019-03-22', ".$_POST["rating"].", '".$_POST["review"]."', 0, 0, 0)";
    }
    $result = pg_query($db, $sql);
}
elseif(isset($_POST["business_name"], $_POST["city_name"], $_POST["zipcode"])){
    if($_POST["business_name"] != ''){
        $sql = "SELECT stars, text FROM review WHERE busID=(SELECT busID FROM business WHERE name LIKE '".$_POST["business_name"]."' AND city = '".$_POST["city_name"]."' AND zipcode='".$_POST["zipcode"]."')";
    }
    $result = pg_query($db, $sql);

    while($row = pg_fetch_row($result)) {
        $output .= "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>";
    }

    echo $output;
}
?>
<?php
   $db = pg_connect(getenv("DATABASE_URL"));

   if(!$db) {
      echo "<h1>Error : Unable to open database</h1>";
   } else {
      echo "<h1>Opened database successfully</h1>";
   }

   $sql = "SELECT * FROM business";

   $response = pg_query($db, $sql);

   if (!$response) {
       echo pg_last_error($db);
       exit;
   }
   
    while($row = pg_fetch_row($response)) {
        echo "NAME = ". $row[0] . "\n";
        echo "STATE = ". $row[1] ."\n";
        echo "CITY = ". $row[2] ."\n";
    }

   pg_close($db);
   
?>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>CS 451 - WSU</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
        <script src="main.js"></script>
    </head>

    <body>
        <div class="content">
            <div class="row">
                <div class="col-sm-5">
                    <div class="wrapper">
                        <form>
                            <h2>Run Query</h2>
                            <select class="form-control" onchange="alert('hoorah!')">
                                    <option value="">Select a State</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="IL">Illinois</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="AZ">Arizona</option>
                            </select>
                            <br>
                            <select class="form-control">
                                <option>Select City</option>
                            </select>
                            <br>
                            <button type="submit" class="btn btn-primary btn-block">GO FIND!</button>
                        </form>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="wrapper">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">State</th>
                                <th scope="col">City</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Advance Auto Parts</td>
                                <td>PA</td>
                                <td>Carnegie</td>
                            </tr>
                            <tr>
                                <td>Alexion's Bar & Grill</td>
                                <td>PA</td>
                                <td>Carnegie</td>
                            </tr>
                            <tr>
                                <td>Amerifit</td>
                                <td>PA</td>
                                <td>Carnegie</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
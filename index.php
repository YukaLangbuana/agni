<?php
   $db = pg_connect(getenv("DATABASE_URL"));

   if(!$db) {
      echo "<h1>Error : Unable to open database</h1>";
   } else {
      echo "<h1>Opened database successfully</h1>";
   }

    function fill_state($db){
       $output = '';
       $sql = "SELECT DISTINCT state FROM business";
       $result = pg_query($db, $sql);

       while($row = pg_fetch_row($result)) {
           $output .= "<option value='.$row[0].'>".$row[0]."</option>";
       }

       return $output;
    }

    function fill_city($db){
        $output = '';
        $sql = "SELECT DISTINCT city FROM business";
        $result = pg_query($db, $sql);

        while($row = pg_fetch_row($result)) {
            $output .= "<option value='.$row[0].'>".$row[0]."</option>";
        }

        return $output;
    }
   
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
                            <select class="form-control" id="state">
                                    <option value="">Select a State</option>
                                    <?php echo fill_state($db); ?>
                            </select>
                            <br>
                            <select class="form-control" id="city">
                                <?php echo fill_city($db); ?>
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
        <script>

            $(document).ready(function(){
                $('#state').change(function(){
                    var state_code = $(this).val()

                    $.ajax({
                        url:"load_data.php";
                        method:"POST";
                        data: {state_code:state_code},
                        success:function(data){
                            $('#city').html(data);
                            alert(data);
                        }
                    })

                });
            });

        </script>
    </body>
</html>
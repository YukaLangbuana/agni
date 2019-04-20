<?php
    $db = pg_connect("host=localhost dbname=daemon user=postgres password=root");

    function get_db_connection_status($db){
        $status = "";
        if(!$db) {
            $status = "<h3>🛑 Database Not Connected</h3>";
        } else {
            $status = "<h3>✅ Database Connected</h3>";
        }

        return $status;
    }

    function fill_state($db){
       $output = '';
       $sql = "SELECT DISTINCT state FROM business ORDER BY state";
       $result = pg_query($db, $sql);

       while($row = pg_fetch_row($result)) {
           $output .= "<option value='".$row[0]."'>".$row[0]."</option>";
       }

       return $output;
    }

    function fill_city($db){
        $output = '';
        $sql = "SELECT DISTINCT city FROM business ORDER BY city";
        $result = pg_query($db, $sql);

        while($row = pg_fetch_row($result)) {
            $output .= "<option value='".$row[0]."'>".$row[0]."</option>";
        }

        return $output;
    }

    function fill_zipcode($db){
        $output = '';
        $sql = "SELECT DISTINCT zipcode FROM business";
        $result = pg_query($db, $sql);

        while($row = pg_fetch_row($result)) {
            $output .= "<option value='".$row[0]."'>".$row[0]."</option>";
        }

        return $output;
    }

    function fill_category($db){
        $output = '';
        $sql = "SELECT category_name FROM category";
        $result = pg_query($db, $sql);

        while($row = pg_fetch_row($result)) {
            $output .= "<option value='".$row[0]."'>".$row[0]."</option>";
        }

        return $output;
    }

    function fill_businesses($db){
        $output = '';
        $sql = "SELECT DISTINCT name FROM business";
        $result = pg_query($db, $sql);

        while($row = pg_fetch_row($result)) {
            $output .= "<option value='".$row[0]."'>".$row[0]."</option>";
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
        <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.js"></script>
    </head>

    <body>
        <div class="content">
            <div class="row">
                <div class="col-sm-5">
                    <div class="wrapper">
                        <?php echo get_db_connection_status($db); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <div class="wrapper">
                        <form>
                            <br>
                            <h2>Run Query</h2>
                            <br>
                            <select class="form-control" id="state">
                                <option value="">Select a State</option>
                                <?php echo fill_state($db); ?>
                            </select>
                            <br>
                            <select class="form-control" id="city">
                                <option value="">Select a City</option>
                                <?php echo fill_city($db); ?>
                            </select>
                            <br>
                            <select class="form-control" id="zipcode">
                                <option value="">Select Zipcode</option>
                            </select>
                            <br>
                            <select class="form-control" id="category">
                                <option value="">Select Category</option>
                            </select>
                            <br>
                            <select class="form-control" id="business">
                                <option value="">Select Business</option>
                                <?php echo fill_businesses($db); ?>
                            </select>
                            <br>
                            <button type="button" class="btn btn-primary btn-block" id="run-query">GO FIND!</button>
                        </form>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="wrapper">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Stars</th>
                                    <th scope="col">Review</th>
                                </tr>
                            </thead>
                            <tbody id = "table-content">
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Submit Review
                        </button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Submit Review!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <br>
                                    <select class="form-control" id="rating">
                                        <option value="">Give a rating</option>
                                        <option value="5">5</option>
                                        <option value="4">4</option>
                                        <option value="3">3</option>
                                        <option value="2">2</option>
                                        <option value="1">1</option>
                                    </select>
                                    <br>
                                    <textarea placeholder="Remember, be nice!" cols="38" rows="5" style="outline: none; resize: none;" id='review'></textarea>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="submit-review">Submit</button>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>

            $(document).ready(function(){
                $('#state').change(function(){
                    var state_code = $(this).val();

                    $.ajax({
                        url:"php/load_data.php",
                        method:"POST",
                        data: {state_code:state_code},
                        success:function(data){
                            $('#city').html(data);
                        }
                    });

                });

                $('#city').change(function(){
                    var city_name = $(this).val();
                    var state_code = $('#state').val();
                    $.ajax({
                        url:"php/load_data.php",
                        method:"POST",
                        data: {state_code:state_code, city_name:city_name},
                        success:function(data){
                            $('#zipcode').html(data);
                        }
                    });

                });

                $('#zipcode').change(function(){
                    var city_name = $('#city').val();
                    var state_code = $('#state').val();
                    var zipcode = $('#zipcode').val();
                    $.ajax({
                        url:"php/load_data.php",
                        method:"POST",
                        data: {state_code:state_code, city_name:city_name, zipcode:zipcode},
                        success:function(data){
                            $('#business').html(data);
                        }
                    });
                });

                $('#business').change(function(){
                    var city_name = $('#city').val();
                    var state_code = $('#state').val();
                    var zipcode = $('#zipcode').val();
                    var business = $('#business').val();
                    $.ajax({
                        url:"php/load_data.php",
                        method:"POST",
                        data: {state_code:state_code, city_name:city_name, zipcode:zipcode, business:business},
                        success:function(data){
                            $('#category').html(data);
                        }
                    });
                });

                $('#category').change(function(){
                    var city_name = $('#city').val();
                    var state_code = $('#state').val();
                    var zipcode = $('#zipcode').val();
                    var category = $('#category').val();
                    $.ajax({
                        url:"php/load_data.php",
                        method:"POST",
                        data: {state_code:state_code, city_name:city_name, zipcode:zipcode, category:category},
                        success:function(data){
                            $('#business').html(data);
                        }
                    });
                });

                $('#run-query').click(function(){
                    var business_name = $('#business').val();
                    var city_name = $('#city').val();
                    var zipcode = $('#zipcode').val();
                    $.ajax({
                        url:"php/run_query.php",
                        method:"POST",
                        data: {business_name:business_name, city_name:city_name, zipcode:zipcode},
                        success:function(data){
                            $('#table-content').html(data);
                        }
                    });

                });

                $('#submit-review').click(function(){
                    var rating = $('#rating').val();
                    var review = $('#review').val();
                    var business_name = $('#business').val();
                    var city_name = $('#city').val();
                    var zipcode = $('#zipcode').val();
                    $.ajax({
                        url:"php/run_query.php",
                        method:"POST",
                        data: {rating:rating, review:review, business_name:business_name, city_name:city_name, zipcode:zipcode},
                        success:function(data){
                            alert("Success!")
                        }
                    });

                });
            });

        </script>
    </body>
</html>
<!doctype html> 
<html>
<head>
    <title>Car Gallery</title>
    <style>
        p {
            color: white;
        }
        .div-1 {
            background-color: black;
        }
        .column {
            float: left;
            width: 32%;
            padding: 5px;
            height: auto; /* Adjusted for dynamic height */
        }
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        div.gallery {
            margin: 10px;
            border: 1px solid #ccc;
            float: left;
            width: 100%; /* Full width in columns */
        }
        div.gallery:hover {
            border: 1px solid #777;
        }
        div.gallery img {
            width: 100%;
            height: 200px;
        }
        div.desc {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    $email = $_SESSION['email'];
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'jatra';
    $con = mysqli_connect($hostname, $username, $password, $dbname);

    if (!$con) {
        echo "Connection failed: " . mysqli_connect_error();
        exit();
    }

    $sr = "SELECT * FROM register WHERE email='$email'";
    $rr = mysqli_query($con, $sr);
    $data = mysqli_fetch_assoc($rr);
    
    if (mysqli_num_rows($rr) > 0) {
    ?>
    <div class="div-1">
        <div class="row">
            <?php
            $q = "SELECT * FROM car";
            $r = mysqli_query($con, $q);

            while ($carData = mysqli_fetch_assoc($r)) {
                $Number_PLate = $carData['Number_PLate'];
                $Price = $carData['Price'];
                $Image = $carData['img']; // ...................
                $Model = $carData['Model'];
                
                // .....................
                if (file_exists($Image)) {
                    echo "<div class='column'>
                            <div class='gallery'>
                                <a href='insert.php?Number_PLate=$Number_PLate&Price=$Price'>
                                    <img src='$Image' alt='$Model' style='width:100%' />
                                </a>
                                <p align='center'><b>$Model</b></p>
                                <p align='center'><b>Price: $Price</b></p>
                            </div>
                          </div>";
                } else {
                    // .......................................
                    echo "<div class='column'>
                            <div class='gallery'>
                                <a href='insert.php?Number_PLate=$Number_PLate&Price=$Price'>
                                    <img src='uploads/placeholder.png' alt='Image not found' style='width:100%' />
                                </a>
                                <p align='center'><b>$Model</b></p>
                                <p align='center'><b>Price: $Price</b></p>
                            </div>
                          </div>";
                }
            }
            ?>
        </div>
    </div>
    <?php
    } else {
        echo "<p>No data found.</p>";
    }
    mysqli_close($con);
    ?>
</body>
</html>

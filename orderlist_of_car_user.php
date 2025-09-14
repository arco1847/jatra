<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('Tesla.jpg') center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            backdrop-filter: blur(5px);
            background-color: rgba(255, 255, 255, 0.5);
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
            color: black;
        }

        th {
            background-color: #333;
            font-weight: bold;
            color: white; /* Changed to white */
        }

        td img {
            width: 150px;
            height: auto;
            object-fit: cover;
        }

        h1 {
            text-align: center;
            color: #fff;
        }
    </style>
</head>

<body>

    <?php
    // Enable error reporting
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Start session and fetch user email from session
    session_start();
    $email = $_SESSION['email'];

    // Database connection
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'jatra';
    $con = mysqli_connect($hostname, $username, $password, $dbname);

    if ($con) {
        echo "<p>Connected to database successfully.</p>";
    } else {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Function to display query results in a table
    function displayTable($result, $columns, $title) {
        echo "<h1>$title</h1>";
        echo "<table>";
        echo "<tr>";
        foreach ($columns as $col) {
            echo "<th>$col</th>";
        }
        echo "</tr>";
        
        while ($data = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            foreach ($columns as $col) {
                if ($col == 'img') {
                    // If the column is the 'img', display an image
                    echo "<td><img src='" . $data[$col] . "' alt='Car Image'></td>";
                } else {
                    echo "<td>" . $data[$col] . "</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    // Query and display data for Car with the new 'img' column
    $q = "SELECT customer_details_c.name, customer_details_c.email, customer_details_c.contactno, car.Model, car.Colour, car.img, customer_details_c.pickup_address, customer_details_c.pickup_date, customer_details_c.pickup_time, customer_details_c.days, customer_details_c.location, customer_details_c.price, customer_details_c.reason, car.Number_PLate 
          FROM car 
          JOIN customer_details_c ON customer_details_c.Number_PLate = car.Number_PLate 
          WHERE email = '$email' 
          ORDER BY customer_details_c.pickup_date";
    
    $r = mysqli_query($con, $q);
    if ($r === false) {
        echo "Error in Car query: " . mysqli_error($con);
    } elseif (mysqli_num_rows($r) > 0) {
        displayTable($r, ['name', 'email', 'contactno', 'Model', 'Colour', 'img', 'pickup_address', 'pickup_date', 'pickup_time', 'location', 'reason', 'price', 'Number_PLate', 'days'], 'Car');
    }

    ?>

</body>

</html>
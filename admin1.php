<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'jatra';
$con = mysqli_connect($hostname, $username, $password, $dbname);
if ($con) {
    echo "";
} else {
    echo "Connection failed: " . mysqli_connect_error();
}

if (isset($_POST['Number_PLate']) && isset($_POST['Model']) && isset($_POST['Colour']) && isset($_POST['Price']) && isset($_FILES['image'])) {
    $Number_PLate = $_POST['Number_PLate'];
    $Model = $_POST['Model'];
    $Colour = $_POST['Colour'];
    $Price = $_POST['Price'];

    // Handle file upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    echo $targetFile;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // Attempt to upload the file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Insert data into the database, save the image path in the 'img' column
            $insert = "INSERT INTO car (Number_PLate, Model, Colour, Price, img) VALUES ('$Number_PLate', '$Model', '$Colour', '$Price', '$targetFile')";
            if (mysqli_query($con, $insert)) {
                echo "Data uploaded successfully.";
            } else {
                echo "Error uploading data: " . mysqli_error($con);
            }
        } else {
            echo "Sorry, there was an error uploading your image.";
        }
    } else {
        echo "File is not an image.";
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<style>
    * { margin: 0; padding: 0; }
    body { background: #ecf1f4; font-family: sans-serif; }

    .form-wrap { 
        width: 320px; 
        background: #3e3d3d; 
        padding: 40px 20px; 
        box-sizing: border-box; 
        position: fixed; 
        left: 50%; 
        top: 50%; 
        transform: translate(-50%, -50%); 
    }
    h1 { text-align: center; color: #fff; font-weight: normal; margin-bottom: 20px; }
    input { 
        width: 100%; 
        background: none; 
        border: 1px solid #fff; 
        border-radius: 3px; 
        padding: 6px 15px; 
        box-sizing: border-box; 
        margin-bottom: 20px; 
        font-size: 16px; 
        color: #fff; 
    }
    input[type="button"] { 
        background: #bac675; 
        border: 0; 
        cursor: pointer; 
        color: #3e3d3d; 
    }
    input[type="button"]:hover { 
        background: #a4b15c; 
        transition: .6s; 
    }
    ::placeholder { color: #fff; }
</style>

<body>
    <div class="form-wrap">
        <form action="" method="POST" enctype="multipart/form-data">
            <h1>Car</h1>
            <input type="text" placeholder="Number Plate" name="Number_PLate" required>
            <input type="text" placeholder="Model" name="Model" required>
            <input type="text" placeholder="Colour" name="Colour" required>
            <input type="number" placeholder="Price" name="Price" required>
            <input type="file" name="image" accept="image/*" required>
            <input type="submit" placeholder="Submit" value="Submit">
        </form>
    </div>
</body>
</html>

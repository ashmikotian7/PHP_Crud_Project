<!DOCTYPE html>
<html>
<head>
    <title>Add Details</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        h2 {
            color: #333;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        input[type="text"], input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: purple;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #6a0dad;
        }
        .message {
            margin: 10px 0;
            color: #5cb85c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Details</h2>
        <form action="add_details.php" method="post">
            Name: <input type="text" name="name" required><br>
            USN: <input type="text" name="usn" required><br>
            Phone Number: <input type="text" name="phone" required><br>
            <input type="submit" name="submit" value="Submit">
        </form>

        <form action="view_details.php" method="get">
            <input type="submit" value="View Records">
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $usn = $_POST['usn'];
            $phone = $_POST['phone'];

            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'wshop');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Insert data
            $sql = "INSERT INTO students (name, usn, phone) VALUES ('$name', '$usn', '$phone')";
            if ($conn->query($sql) === TRUE) {
                echo "<div class='message'>New record created successfully</div>";
            } else {
                echo "<div class='message' style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</div>";
            }

            $conn->close();
        }
        ?>
    </div>
</body>
</html>

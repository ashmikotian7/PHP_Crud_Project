<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Details</title>
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
            min-height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="submit"], select {
            padding: 10px;
            margin: 10px 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .no-records {
            text-align: center;
            padding: 20px;
            color: #777;
        }
        .action-form {
            display: inline-block;
            margin: 0;
        }
        .action-form input[type="submit"] {
            background-color: #d9534f;
            color: white;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
        }
        .action-form input[type="submit"]:hover {
            background-color: #c9302c;
        }
        .update-form input[type="submit"] {
            background-color: #0275d8;
            color: white;
        }
        .update-form input[type="submit"]:hover {
            background-color: #025aa5;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="view_details.php" method="get">
            Search: <input type="text" name="query" value="<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>">
            <input type="submit" value="Search">
            Sort by: 
            <select name="sort">
                <option value="name" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'name') echo 'selected'; ?>>Name</option>
                <option value="usn" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'usn') echo 'selected'; ?>>USN</option>
                <option value="phone" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'phone') echo 'selected'; ?>>Phone</option>
            </select>
            <input type="submit" value="Sort">
        </form>

        <h2>View Details</h2>

        <!-- Display Records -->
        <table>
            <tr>
                <th>Name</th>
                <th>USN</th>
                <th>Phone Number</th>
                <th>Delete Record</th>
                <th>Update Record</th>
            </tr>

            <?php
            $conn = new mysqli('localhost', 'root', '', 'wshop');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $search_query = isset($_GET['query']) ? $_GET['query'] : '';
            $sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'name';

            $sql = "SELECT * FROM students WHERE name LIKE '%$search_query%' OR usn LIKE '%$search_query%' OR phone LIKE '%$search_query%' ORDER BY $sort_by";

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["name"] . "</td>
                            <td>" . $row["usn"] . "</td>
                            <td>" . $row["phone"] . "</td>
                            <td>
                                <form action='delete.php' method='post' class='action-form'>
                                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                                    <input type='submit' value='Delete'>
                                </form>
                            </td>
                            <td>
                                <form action='update.php' method='post' class='action-form update-form'>
                                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                                    <input type='submit' value='Update'>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='no-records'>No records found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>

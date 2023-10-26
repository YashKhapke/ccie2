<?php
// Include the database connection configuration
include('dbinfo.inc');

// Initialize variables
$name = "";
$department = "";

// Create a connection to the database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);

    // Check for empty fields
    if (empty($name) || empty($department)) {
        // Handle validation errors, e.g., display an error message
        echo "Name and Department are required.";
    } else {
        // Insert data into the database
        $insertQuery = "INSERT INTO employees (name, position) VALUES ('$name', '$department')";

        if ($conn->query($insertQuery) === TRUE) {
            // Data successfully inserted
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .button {
            background-color: #333;
            color: #fff;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 0.5rem;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>
    <h1>Employee Management System</h1>
    <div class="container">
        <h2>Add Employee</h2>
        <form method="post" action="ccie2.php">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>

            <div class="form-group">
                <label for "department">Department:</label>
                <input type="text" id="department" name="department" value="<?php echo $department; ?>" required>
            </div>

            <button class="button" type="submit" name="add_employee">Add Employee</button>
        </form>

        <h2>Employee List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
            </tr>
            <?php
            $query = "SELECT * FROM employees";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["position"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No employees found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

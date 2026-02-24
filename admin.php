<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'school_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM registrations";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
        }
        .container {
            width: 90%;
            max-width: 800px; /* Increased max-width for better layout */
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto; /* Enable horizontal scrolling for tables */
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0; /* Smaller margins for responsiveness */
        }
        th, td {
            border: 1px solid #ccc;
            padding: 0.5rem;
            text-align: left;
            word-break: break-word; /* Break long words in table for better layout */
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }

        /* Responsive styles */
        @media (max-width: 600px) {
            h2 {
                font-size: 1.5rem; /* Adjust font size for small screens */
            }
            table {
                font-size: 0.9rem; /* Smaller font size for the table */
            }
            th, td {
                padding: 0.3rem; /* Adjust padding for smaller screens */
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registered Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>School Name</th>
            <th>School Phone</th>
            <th>School Email</th>
            <th>Course</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['school_name']); ?></td>
            <td><?php echo htmlspecialchars($row['school_phone']); ?></td>
            <td><?php echo htmlspecialchars($row['school_email']); ?></td>
            <td><?php echo htmlspecialchars($row['course']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
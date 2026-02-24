<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 600px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input, select {
            width: 100%;
            padding: 0.5rem;
            margin: 0.5rem 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            margin: 1rem 0;
        }
        .success-message {
            color: green;
        }
        .error-message {
            color: red;
        }
        @media (max-width: 600px) {
            .container {
                padding: 1.5rem;
            }
            h2 {
                font-size: 1.5rem;
            }
            input, select {
                padding: 0.7rem;
                font-size: 1rem;
            }
        }
        .add-another {
            text-align: center;
            margin: 1rem 0;
        }
        .add-another a {
            background-color: #007bff;
            color: white;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 4px;
        }
        .add-another a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registration Form</h2>

    <?php
    $successMessage = "";
    $errorMessage = "";
    $formVisible = true; // Control visibility of the form

    // Function to validate phone number
    function is_valid_phone($phone) {
        return preg_match('/^\+?[0-9]{10,15}$/', $phone);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'school_system');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Set parameters
        $full_name = $_POST['full_name'];
        $phone_number = $_POST['phone_number'];
        $email = $_POST['email'];
        $school_name = $_POST['school_name'];
        $school_phone = $_POST['school_phone'];
        $school_email = $_POST['school_email'];
        $course = $_POST['course'];

        // Validate phone numbers
        if (!is_valid_phone($phone_number) || !is_valid_phone($school_phone)) {
            $errorMessage = "Invalid phone number format. Please enter a valid phone number.";
        } else {
            // Check if phone number already exists
            $checkQuery = "SELECT COUNT(*) FROM registrations WHERE phone_number = ?";
            $stmtCheck = $conn->prepare($checkQuery);
            $stmtCheck->bind_param("s", $phone_number);
            $stmtCheck->execute();
            $stmtCheck->bind_result($count);
            $stmtCheck->fetch();
            $stmtCheck->close();

            if ($count > 0) {
                $errorMessage = "Phone number is already in use. Please use a different number.";
            } else {
                // Prepare and bind for insertion
                $stmt = $conn->prepare("INSERT INTO registrations (full_name, phone_number, email, school_name, school_phone, school_email, course) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $full_name, $phone_number, $email, $school_name, $school_phone, $school_email, $course);

                if ($stmt->execute()) {
                    $successMessage = "Registration is successful. If you want additional information, contact us at: yossefbir26@gmail.com or call (+251)965199622.";
                    $formVisible = false; // Hide the form on successful submission
                } else {
                    $errorMessage = "Error: " . $stmt->error;
                }

                $stmt->close();
            }
        }

        $conn->close();
    }
    ?>

    <?php if ($successMessage): ?>
    <p class="message success-message"><?php echo $successMessage; ?></p>
    <div class="add-another">
        <a href="register.php">Add Another Registration</a> <!-- Link to the same page or another registration page -->
    </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
    <p class="message error-message"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <?php if ($formVisible): ?>
    <form action="" method="post">
        Full Name: <input type="text" name="full_name" required><br>
        Phone Number: <input type="tel" name="phone_number" required pattern="^\+?[0-9]{10,15}$" title="Invalid phone number format. Please enter a valid phone number."><br>
        Email: <input type="email" name="email" required><br>
        School Name: <input type="text" name="school_name" required><br>
        School Phone: <input type="tel" name="school_phone" required pattern="^\+?[0-9]{10,15}$" title="Invalid phone number format. Please enter a valid phone number."><br>
        School Email: <input type="email" name="school_email" ><br>
        Course:
        <select name="course" required>
            <option value="Amharic">Amharic</option>
            <option value="A/Oromo">A/Oromo</option>
            <option value="English">English</option>
            <option value="Maths">Maths</option>
            <option value="Physics">Physics</option>
            <option value="Chemistry">Chemistry</option>
            <option value="Biology">Biology</option>
            <option value="Geography">Geography</option>
            <option value="History">History</option>
            <option value="Economics">Economics</option>
            <option value="Civics">Civics</option>
            <option value="G/Science">G/Science</option>
            <option value="S/Science">S/Science</option>
            <option value="CTE">CTE</option>
            <option value="Art">Art</option>
            <option value="Sport">Sport</option>
            <option value="ICT">ICT</option>
            <option value="WoodWork">WoodWork</option>
            <option value="Finishing Construction">Finishing Construction</option>
            <option value="Animal Production">Animal Production</option>
            <option value="Natural R.M">Natural R.M</option>
            <option value="Health">Health</option>
            <option value="Journalism">Journalism</option>
            <option value="Psychosocial">Psychosocial</option>
            <option value="Accounting">Accounting</option>
            <option value="Marketing">Marketing</option>
            <option value="Vocal Performance">Vocal Performance</option>
            <option value="Other">Other</option>
        </select><br>
        <input type="submit" value="Register">
    </form>
    <?php endif; ?>
</div>

</body>
</html>
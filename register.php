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

// Display messages
if ($successMessage) {
    echo "<p class='message success-message'>$successMessage</p>";
    echo "<div class='add-another'><a href='register.html'>Add Another Registration</a></div>";
}

if ($errorMessage) {
    echo "<p class='message error-message'>$errorMessage</p>";
}

if ($formVisible) {
    echo "<script>window.location.href='register.html';</script>";
}
?>
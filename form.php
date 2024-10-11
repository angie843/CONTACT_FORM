<?php
session_start();

function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

$formData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = isset($_POST['first_name']) ? sanitizeInput($_POST['first_name']) : '';
    $lastName = isset($_POST['last_name']) ? sanitizeInput($_POST['last_name']) : '';
    $age = isset($_POST['age']) ? (int) sanitizeInput($_POST['age']) : 0; 
    $contact = isset($_POST['contact']) ? sanitizeInput($_POST['contact']) : '';
    $address = isset($_POST['address']) ? sanitizeInput(trim($_POST['address'])) : '';

    if (empty($firstName) || empty($lastName) || empty($contact) || empty($address) || $age <= 0) {
        echo "Please fill out all fields.";
    } elseif (!is_numeric($age) || $age <= 0 || $age > 120) {
        $_SESSION['error'] = "Please enter a valid age between 1 and 120.";
        header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
        exit();
    } else {
        $formData = [
            "First Name" => $firstName,
            "Last Name" => $lastName,
            "Age" => $age,
            "Contact" => $contact,
            "Address" => $address
        ];

        $_SESSION['all_form_data'][] = $formData; 

        echo "<div class='result'>";
        echo "<h1>Contact Information</h1>";
        echo "<ul>";
        foreach ($formData as $key => $value) {
            echo "<li><strong>$key:</strong> $value</li>";
        }
        echo "</ul>";
        echo "<a href='" . $_SERVER['PHP_SELF'] . "'>Go Back to Form</a>";
        echo "</div>";
    }
} else {
    if (isset($_SESSION['error'])) {
        echo "<div class='error'>".$_SESSION['error']."</div>";
        unset($_SESSION['error']);
    }
    
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact Form</title>
        <link rel="stylesheet" href="styles.css">

        <script>
            function validateForm() {
                const age = document.getElementById('age').value;

                if (age < 0 || age > 120) {
                alert('Enter a valid age.');
                return false; 
                }
                return true; 
                }
                    
                    function resetForm(event) {
                        if (validateForm(event)) {
                            alert("Form submitted successfully!");
                            
                            event.target.reset();
                            return true; 
                        }
                    }
                    </script>
    </head>
    <body>
        <div class="input">
            <h1>Contact Form</h1>
            <form action="" method="POST" onsubmit="return validateForm()">
                <div class="full-name-input">
                    <div>
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" placeholder="Enter your first name....." 
                        name="first_name" pattern="[A-Z\sa-z]{3,20}" required autocomplete="off">
                    </div>
                    <div>
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" placeholder="Enter your last name....." 
                        name="last_name" pattern="[A-Z\sa-z]{3,20}" required autocomplete="off">
                    </div>
                </div>

                <div class="contact-age-input">
                    <div>
                        <label for="age">Age:</label>
                        <input type="number" id="age" placeholder="Enter your age....." name="age" required>
                    </div>
                    <div>
                        <label for="contact">Contact No:</label>
                        <input type="text" id="contact" placeholder="e.g. +63 9123456789" 
                        name="contact" pattern="^\+63[0-9]{10}$" required autocomplete="off"> 
                    </div>
                </div>

                <div class="address-input">
                    <label for="address">Address:</label>
                    <input type="text" id="address" placeholder="Enter your address....." name="address" required autocomplete="off">
                </div>

                <div>
                    <input type="submit" value="Submit" style="font-weight: bold; font-family: 'Times New Roman', Times, serif; 
                    font-size: 20px; margin-top: 25px; height: 40px;">
                </div>
            </form>
        </div>
    </body>
    </html>
<?php
}
?>

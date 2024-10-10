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
    unset($_SESSION['all_form_data']);
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact Form</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 20px;
            }   

            .input {
                width: 28%;
                margin: auto;
                padding: 10px;
                background: #ADE8F4;
                box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.3);
                border-radius: 15px;
                border: 2px solid #007EFF; 
            }

            h1 {
                text-align: center;
                color: #007EFF;
                font-size: 45px;
                font-family: 'Times New Roman', Times, serif;
                text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.5);
            }

            label {
                display: block;
                margin: 8px 0 5px;
                color: #007EFF;
                font-weight: bold;
            }

            .fullname-input, .contact-age-input {
                display: flex;
                justify-content: space-between;
                gap: 20px;
            }

            .fullname-input div, .contact-age-input div {
                flex: 1;
            }

            .address-input input[type="text"] {
                height: 60px; 
            }

            input[type="text"], input[type="number"] {
                width: 100%;
                padding: 10px;
                margin: 5px 0 10px;
                border: 1px solid #ccc; 
                border-radius: 4px;
                box-sizing: border-box;
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
                transition: border-color 0.3s, background-color 0.3s; 
            }

            input[type="text"]:focus, input[type="number"]:focus {
                border-color: #007EFF; 
                background-color: #E0F7FA; 
                outline: none; 
            }


            input[type="submit"] {
                background: #007EFF;
                color: white;
                border: none;
                cursor: pointer;
                width: 50%;
                margin: 20px auto;
                display: block;
                border-radius: 5px;
                box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.3);
            }

            input[type="submit"]:hover {
                background: #48CAE4;
            }

            .output {
                margin-top: 20px;
                background-color: #CAF0F8;
                padding: 20px;
                border-radius: 8px;
            }

            ul {
                list-style-type: none;
                padding: 0;
            }

            li {
                margin: 10px 0;
                font-size: 18px;
            }

            strong {
                color: #007EFF;
            }

            .result {
                font-family: Arial, sans-serif;
                padding: 20px;
                width: 30%;
                margin: 20px auto;
                background: #ADE8F4;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 15px;
                border: 2px solid #007EFF; 
            }
        </style>

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
                <div class="full_name-input">
                    <div>
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" placeholder="Enter your first name....." 
                        name="first_name" pattern=[A-Z\sa-z]{3,20} required autocomplete="off">
                    </div>
                    <div>
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" placeholder="Enter your last name....." 
                        name="last_name" pattern=[A-Z\sa-z]{3,20} required autocomplete="off">
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

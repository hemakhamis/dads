<?php
// Function to generate a new filename with sequential number
function generateNewFileName($filePath) {
    $info = pathinfo($filePath);
    $directory = $info['dirname'];
    $filename = $info['filename'];
    $extension = isset($info['extension']) ? '.' . $info['extension'] : '';

    // Check if the file already exists
    $i = 2;
    while (file_exists($directory . '/' . $filename . $extension)) {
        $filename = $info['filename'] . $i;
        $i++;
    }

    // Return the new filename with sequential number
    return $directory . '/' . $filename . $extension;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $contractId = $_POST["contractId"];
    $title = $_POST["title"];
    $companyName = $_POST["companyName"];
    $subsidiary = $_POST["subsidiary"];
    $department = $_POST["department"];
    $street = $_POST["street"];
    $addition = $_POST["addition"];
    $zipCode = $_POST["zipCode"];
    $location = $_POST["location"];
    $country = $_POST["country"];
    $companyPhone = $_POST["companyPhone"];
    $companyFax = $_POST["companyFax"];
    $website = $_POST["website"];
    $contactPersonName = $_POST["contactPersonName"];
    $contactPersonPhone = $_POST["contactPersonPhone"];
    $contactPersonFax = $_POST["contactPersonFax"];
    $contactPersonEmail = $_POST["contactPersonEmail"];

    // Create a string with form data
    $formData = "Contract ID: " . $contractId . "\n" . "Title: " . $title . "\n" . 
                "Company Name: " . $companyName . "\n" . "Subsidiary: " . $subsidiary . "\n" . 
                "Department: " . $department . "\n" . "Street: " . $street . "\n" . 
                "Addition: " . $addition . "\n" . "Zip Code: " . $zipCode . "\n" . 
                "Location: " . $location . "\n" . "Country: " . $country . "\n" . 
                "Company Phone: " . $companyPhone . "\n" . "Company Fax: " . $companyFax . "\n" . 
                "Website: " . $website . "\n" . "Contact Person Name: " . $contactPersonName . "\n" . 
                "Contact Person Phone: " . $contactPersonPhone . "\n" . "Contact Person Fax: " . $contactPersonFax . "\n" . 
                "Contact Person Email: " . $contactPersonEmail . "\n\n";

    // Define the path to the text file
    $filePath = "form_data.txt";

    // Generate a new filename with sequential number if the file already exists
    $filePath = generateNewFileName($filePath);

    // Open the file in append mode
    $file = fopen($filePath, "a");

    // Write form data to the file
    fwrite($file, $formData);

    // Close the file
    fclose($file);

    // Redirect to a thank you page or wherever you want
    header("location:1.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form 1</title>
    <style>
        /* Form container styling */
        .form-container {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            width: 400px;
            margin: auto;
        }

        /* Form label styling */
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Form input styling */
        .form-container input[type="text"],
        .form-container input[type="tel"],
        .form-container input[type="email"],
        .form-container input[type="url"],
        .form-container textarea,
        .form-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Adjust for padding and border */
        }

        /* Form submit button styling */
        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
/* Form submit button styling */
.form-container input[type="submit"] {
    background-color: #24305e; /* Dark blue */
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.form-container input[type="submit"]:hover {
    background-color: #1a237e; /* Darker blue on hover */
}

    </style>
</head>
<body>
<div class="form-container">
    <form id="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="contractId">Contract ID:</label>
        <input type="text" id="contractId" name="contractId">

        <label for="title">Title:</label>
        <input type="text" id="title" name="title">

        <label for="companyName">Company Name:</label>
        <input type="text" id="companyName" name="companyName">

        <label for="subsidiary">Subsidiary:</label>
        <input type="text" id="subsidiary" name="subsidiary">

        <label for="department">Department:</label>
        <input type="text" id="department" name="department">

        <label for="street">Street:</label>
        <input type="text" id="street" name="street">

        <label for="addition">Addition:</label>
        <input type="text" id="addition" name="addition">

        <label for="zipCode">Zip Code:</label>
        <input type="text" id="zipCode" name="zipCode">

        <label for="location">Location:</label>
        <input type="text" id="location" name="location">

        <label for="country">Country:</label>
        <input type="text" id="country" name="country">

        <label for="companyPhone">Company Phone:</label>
        <input type="tel" id="companyPhone" name="companyPhone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="XXX-XXX-XXXX">

        <label for="companyFax">Company Fax:</label>
        <input type="tel" id="companyFax" name="companyFax" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="XXX-XXX-XXXX">

        <label for="website">Website:</label>
        <input type="url" id="website" name="website">

        <label for="contactPersonName">Contact Person Name:</label>
        <input type="text" id="contactPersonName" name="contactPersonName">

        <label for="contactPersonPhone">Contact Person Phone:</label>
        <input type="tel" id="contactPersonPhone" name="contactPersonPhone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="XXX-XXX-XXXX">

        <label for="contactPersonFax">Contact Person Fax:</label>
        <input type="tel" id="contactPersonFax" name="contactPersonFax" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="XXX-XXX-XXXX">

        <label for="contactPersonEmail">Contact Person Email:</label>
        <input type="email" id="contactPersonEmail" name="contactPersonEmail">

        <input type="submit" value="Submit">
    </form>
</div>
</body>
</html>

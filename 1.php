<?php
// Function to find the latest file
function findLatestFile() {
    $latestFile = "form_data.txt"; // Default file name if no other files exist
    $i = 2; // Start checking from form_data2.txt
    while (file_exists("../form_data" . $i . ".txt")) {
        $latestFile = "../form_data" . $i . ".txt";
        $i++;
    }
    return $latestFile;
}

// Define the path to the text file
$filePath = findLatestFile();

// Open the file in append mode
$file = fopen($filePath, "a");

// Add the selected option to the text file
fwrite($file, "Selected Option: " . $selectedOption . "\n");

// Close the file
fclose($file);

// Redirect to a thank you page or wherever you want
header("location:2.php");
exit();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form 2</title>
    <style>
        /* Form container styling */
        .form-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px; /* Add margin top */
            width: 300px; /* Add width */
            margin: auto; /* Center align */
        }

        /* Form label styling */
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Form select styling */
        .form-container select {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Form submit button styling */
        .form-container input[type="submit"] {
            background-color: #191970;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0e0e8c;
        }
    </style>
</head>
<body>
<div class="form-container">
    <form id="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!-- Specify action and method -->
        <label for="options">Choose an option:</label>
        <select id="options" name="options">
            <option value="basic">Basic template</option>
            <option value="mobile_crane">Mobile crane</option>
        </select>
        <input type="submit" value="Next">
    </form>
</div>
</body>
</html>

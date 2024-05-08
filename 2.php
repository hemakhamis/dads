<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $craneType = $_POST["craneType"];
    $code = $_POST["code"];
    $symbol = $_POST["symbol"];
    $location = $_POST["location"];
    $manufacturer = $_POST["manufacturer"];
    $vehicleType = $_POST["vehicleType"];
    $loadCapacity = $_POST["loadCapacity"];
    $yearOfBuild = $_POST["yearOfBuild"];
    $commissioningDate = $_POST["commissioningDate"];
    $lastInspection = $_POST["lastInspection"];
    $nextInspection = $_POST["nextInspection"];

    // Create a string with form data
    $formData = "Crane Type: " . $craneType . "\n" .
                "Code / ID: " . $code . "\n" .
                "Symbol: " . $symbol . "\n" .
                "Location / Number Plate: " . $location . "\n" .
                "Manufacturer: " . $manufacturer . "\n" .
                "Vehicle Type: " . $vehicleType . "\n" .
                "Load Capacity [t]: " . $loadCapacity . "\n" .
                "Year of Build: " . $yearOfBuild . "\n" .
                "Commissioning Date: " . $commissioningDate . "\n" .
                "Date of Last Inspection: " . $lastInspection . "\n" .
                "Date of Next Inspection: " . $nextInspection . "\n";

// Function to find the latest file
function findLatestFile() {
    $latestFile = "form_data.txt"; // Default file name if no other files exist
    $i = 2; // Start checking from form_data2.txt
    while (file_exists("form_data" . $i . ".txt")) {
        $latestFile = "form_data" . $i . ".txt";
        $i++;
    }
    return $latestFile;
}

// Define the path to the text file
$filePath = findLatestFile();


    // Open the file in append mode
    $file = fopen($filePath, "a");

    // Write form data to the file
    fwrite($file, $formData);

    // Close the file
    fclose($file);

    // Redirect to a thank you page or wherever you want
    header("Location: checkpoints/{$_POST['checkpoint']}.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form 3</title>
    <style>
        /* Form container styling */
        .form-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px; /* Add margin top */
            font-family: Arial, sans-serif; /* Set font family */
            width: 300px; /* Add width */
            margin: auto; /* Center align */
        }

        /* Form label styling */
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Form input styling */
        .form-container input[type="text"],
        .form-container input[type="date"],
        .form-container input[type="number"] {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: inherit; /* Inherit font family */
        }

        /* Checkpoint buttons container styling */
        .checkpoint-buttons {
            margin-top: 20px; /* Add margin between the buttons */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Checkpoint button styling */
        .checkpoint-buttons button {
            margin: 10px;
            background-color: #191970;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            font-family: inherit; /* Inherit font family */
        }

        .checkpoint-buttons button:hover {
            background-color: #0e0e8c;
        }
      .checkpoint-buttons button {
          width: 250px; /* Adjust the width as needed */
          height: 40px; /* Adjust the height as needed */
          margin: 5px; /* Adjust the margin as needed */
      }

    </style>
</head>
<body>
<div class="form-container">
    <form id="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!-- Specify action and method -->
        <label for="craneType">Type:</label>
        <input type="text" id="craneType" name="craneType" value="Mobile crane" readonly>

        <label for="code">Code / ID:</label>
        <input type="text" id="code" name="code">

        <label for="symbol">Symbol:</label>
        <input type="text" id="symbol" name="symbol">

        <h2>Attributes</h2>
        <label for="location">Location / Number Plate:</label>
        <input type="text" id="location" name="location">

        <label for="manufacturer">Manufacturer:</label>
        <input type="text" id="manufacturer" name="manufacturer">

        <label for="vehicleType">Vehicle Type:</label>
        <input type="text" id="vehicleType" name="vehicleType">

        <label for="loadCapacity">Load Capacity [t]:</label>
        <input type="number" id="loadCapacity" name="loadCapacity">

        <label for="yearOfBuild">Year of Build:</label>
        <input type="number" id="yearOfBuild" name="yearOfBuild">

        <h2>Dates</h2>
        <label for="commissioningDate">Commissioning Date:</label>
        <input type="date" id="commissioningDate" name="commissioningDate">

        <label for="lastInspection">Date of Last Inspection:</label>
        <input type="date" id="lastInspection" name="lastInspection">

        <label for="nextInspection">Date of Next Inspection:</label>
        <input type="date" id="nextInspection" name="nextInspection">

        <h2>OCCUPATIONAL SAFETY DURING CRANE INSPECTION</h2>
      <div class="checkpoint-buttons">
          <button type="submit" name="checkpoint" value="1">Carrier Structure</button>
          <button type="submit" name="checkpoint" value="2">Tyre pressure</button>
          <button type="submit" name="checkpoint" value="3">Wheel Nuts</button>
          <button type="submit" name="checkpoint" value="4">Radiator water</button>
          <button type="submit" name="checkpoint" value="5">Engine Oil Level</button>
          <button type="submit" name="checkpoint" value="6">Diesel Level</button>
          <button type="submit" name="checkpoint" value="7">Diesel Tank</button>
          <button type="submit" name="checkpoint" value="8">Any Retrofitted Fuel Tanks</button>
          <button type="submit" name="checkpoint" value="9">Battery water level</button>
          <button type="submit" name="checkpoint" value="10">power take-off (PTO)</button>
          <button type="submit" name="checkpoint" value="11">propeller shaft</button>
          <button type="submit" name="checkpoint" value="12">hydraulic tank</button>
          <button type="submit" name="checkpoint" value="13">hydraulic pump</button>
          <button type="submit" name="checkpoint" value="14">hydraulic hose</button>
          <button type="submit" name="checkpoint" value="15">hydraulic oil</button>
          <button type="submit" name="checkpoint" value="16">slewing teble</button>
          <button type="submit" name="checkpoint" value="17">slewing gear and beaning</button>
          <button type="submit" name="checkpoint" value="18">elevating cylinder</button>
          <button type="submit" name="checkpoint" value="19">boom structure</button>
          <button type="submit" name="checkpoint" value="20">fly-jib</button>
          <button type="submit" name="checkpoint" value="21">single top</button>
          <button type="submit" name="checkpoint" value="22">sheave and hook block</button>
          <button type="submit" name="checkpoint" value="23">boom hoist wire</button>
          <button type="submit" name="checkpoint" value="24">load hoist wire</button>
          <button type="submit" name="checkpoint" value="25">winch motor</button>
          <button type="submit" name="checkpoint" value="26">clutch</button>
          <button type="submit" name="checkpoint" value="27">brake</button>
          <button type="submit" name="checkpoint" value="28">wire rope</button>
          <button type="submit" name="checkpoint" value="29">hook block</button>
          <button type="submit" name="checkpoint" value="30">operation control</button>
          <button type="submit" name="checkpoint" value="31">selector switch</button>
          <button type="submit" name="checkpoint" value="32">angle indicator</button>
          <button type="submit" name="checkpoint" value="33">pressure gauge</button>
          <button type="submit" name="checkpoint" value="34">LRl</button>
          <button type="submit" name="checkpoint" value="35">anti-tow block</button>
          <button type="submit" name="checkpoint" value="36">boom stop</button>
          <button type="submit" name="checkpoint" value="37">outrigger</button>
          <button type="submit" name="checkpoint" value="38">jack cylinder</button>
          <button type="submit" name="checkpoint" value="39">float</button>
      </div>

            <!-- Add buttons for other checkpoints here -->
        </div>
    </form>
</div>
</body>
</html>

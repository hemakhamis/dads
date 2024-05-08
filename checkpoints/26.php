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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $question1 = $_POST["question1"];
    $assessment1 = $_POST["assessment1"];
    $comment1 = $_POST["comment1"];
    $responsible1 = $_POST["responsible1"];
    $deadline1 = $_POST["deadline1"];
    $media1 = $_POST["media1"]; // Base64 encoded image data

    // Open the file to read existing data
    $existingData = file_get_contents($filePath);

    // Check if responsible and deadline fields are already filled
    $existingResponsible = "";
    $existingDeadline = "";
    preg_match("/Responsible: (.*?)\n/", $existingData, $existingResponsible);
    preg_match("/Deadline: (.*?)\n/", $existingData, $existingDeadline);

    // If responsible field is empty in the file, use the submitted value, otherwise use the existing one
    $responsibleValue = (!empty($existingResponsible[1])) ? $existingResponsible[1] : $responsible1;
    // If deadline field is empty in the file, use the submitted value, otherwise use the existing one
    $deadlineValue = (!empty($existingDeadline[1])) ? $existingDeadline[1] : $deadline1;

    // Create a string with form data (excluding image data for now)
    $formData = "clutch:\n" .
        "Assessment: " . $assessment1 . "\n" .
        "Comment: " . $comment1 . "\n" .
        "Responsible: " . $responsible1 . "\n" .
        "Deadline: " . $deadline1 . "\n";

    // Append base64 image data to form data string
     if (!empty($media1)) {
        // Prepend the Base64 encoded image with the necessary data URL prefix
        $formData .= "media: data:image/jpeg;base64," . $media1 . "\n";
    }

    // Open the file in append mode
    $file = fopen($filePath, "a");

    // Write the complete form data (including image data) to the text file
    fwrite($file, $formData . "\n");

    // Close the text file
    fclose($file);

    // Redirect to next page
    header("Location: 27.php");
exit();
}  

// Check if it's an AJAX request to fetch values
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Open the file to read existing data
    $existingData = file_get_contents($filePath);

    // Check if responsible and deadline fields are already filled
    $existingResponsible = "";
    $existingDeadline = "";
    preg_match("/Responsible: (.*?)\n/", $existingData, $existingResponsible);
    preg_match("/Deadline: (.*?)\n/", $existingData, $existingDeadline);

    // Create an array with extracted values
    $values = array(
        'responsible' => (!empty($existingResponsible[1])) ? $existingResponsible[1] : "",
        'deadline' => (!empty($existingDeadline[1])) ? $existingDeadline[1] : ""
    );

    // Output values as JSON
    header('Content-Type: application/json');
    echo json_encode($values);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkpoint 1</title>
 <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Checkpoint form styling */
        .checkpoint-form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
            color: #333333;
        }

        /* Form label styling */
        .checkpoint-form label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #555555;
        }

        /* Form input styling */
        .checkpoint-form input[type="text"],
        .checkpoint-form input[type="date"],
        .checkpoint-form textarea,
        .checkpoint-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            background-color: #f9f9f9;
            color: #333333;
        }

        .checkpoint-form input[type="file"] {
            display: none;
        }

        /* Choose file button styling */
        .choose-file-btn {
            background-color: #ffffff;
            color: #00008B;
            border: 2px solid #00008B;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
            width: 100%;
            text-align: center;
            display: inline-block;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .choose-file-btn:hover {
            background-color: #00008B;
            color: #ffffff;
            border-color: #00008B;
        }

        /* Assessment section styling */
        .assessment-container {
            margin-bottom: 20px;
            transition: background-color 0.3s; /* Smooth transition */
        }

        .assessment-container label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #555555;
        }

        .assessment-container select {
            width: calc(100% + 2px); /* Adjust width to match other inputs */
            margin-left: -1px; /* Compensate for border width */
        }

        /* Submit button styling */
        .checkpoint-form button[type="button"],
        .checkpoint-form .back-button {
            background-color: #00008B;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100%;
            display: block;
            text-align: center;
        }

        .checkpoint-form button[type="button"]:hover,
        .checkpoint-form .back-button:hover {
            background-color: #000080;
        }

        /* Back button styling */
        .checkpoint-form .back-button {
            background-color: #6c757d;
            margin-top: 10px;
        }

        /* Camera button styling */
        .camera-btn {
            background-color: #ffffff;
            color: #00008B;
            border: 2px solid #00008B;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
            width: 100%;
            text-align: center;
            display: inline-block;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .camera-btn:hover {
            background-color: #00008B;
            color: #ffffff;
            border-color: #00008B;
        }

        /* Video container */
        .video-container {
            display: none;
            margin-bottom: 20px;
        }

        /* Video element styling */
        #video {
            width: 100%;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }

        /* Capture button styling */
        .capture-btn {
            background-color: #00008B;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100%;
            display: block;
            text-align: center;
        }

        .capture-btn:hover {
            background-color: #000080;
        }

        /* Image display styling */
        .taken-image {
            display: none; /* Initially hide the image */
            max-width: 100%; /* Adjust image width */
            height: auto; /* Maintain aspect ratio */
            margin-top: 20px; /* Add space below the image */
            border: 1px solid #cccccc; /* Add border */
            border-radius: 4px; /* Add border radius */
        }

        /* Close button styling */
         #closeFormBtn {
            position: fixed;
            top: 10px;
            left: 10px;
            background-color: #ccc;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 16px;
            cursor: pointer;
        }

        /* Confirmation popup styling */
        .confirmation-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        /* Style for buttons inside the confirmation popup */
        .confirmation-popup button {
            margin: 0 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            outline: none;
        }

        /* Style for Yes button */
        .confirmation-popup button.yes {
            background-color: #00008B;
            color: #fff;
        }

        /* Style for No button */
        .confirmation-popup button.no {
            background-color: #ddd;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="checkpoint-form">
        <!-- Close button -->
        <button id="closeFormBtn">X</button>

        <!-- Your existing form content -->

        <!-- Confirmation Popup -->
        <div class="confirmation-popup" id="confirmationPopup">
            <p>Are you sure you want to quit?</p>
            <button class="no" onclick="closeConfirmationPopup()">No</button>
            <button class="yes" onclick="quitForm()">Yes</button>
        </div>
    <div class="checkpoint-form">
        <form id="checkpointForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <input type="text" style="background-color: #00008b; color: white;" id="question1" name="question1" required placeholder="clutch" value="clutch" required placeholder="clutch" value="clutch" required placeholder="Question">

            <div class="assessment-container">
                <label for="assessment1">Assessment:</label>
                <select id="assessment1" name="assessment1" required>
        <option style="color: green;" value="ok">OK</option>
        <option style="color: yellow;" value="not ok">Not OK</option>
        <option style="color: red;" value="to be fixed">To be fixed</option>
        <option style="color: grey;" value="not applicable">Not applicable</option>
                </select>
            </div>

            <label for="comment1">Comment:</label>
            <textarea id="comment1" name="comment1" rows="4"></textarea>

            <label for="responsible1">Responsible:</label>
            <input type="text" id="responsible1" name="responsible1" required>

            <label for="deadline1">Deadline:</label>
            <input type="date" id="deadline1" name="deadline1" required>

            <input type="hidden" id="media1" name="media1">

            <label for="camera" class="camera-btn">Take a Photo</label>

            <!-- Video container -->
            <div class="video-container" id="videoContainer">
                <video id="video" autoplay></video>
                <button type="button" id="captureBtn" class="capture-btn">Capture</button>
            </div>
            <!-- Image display -->
            <img id="takenImage" class="taken-image" src="" alt="Taken Image">
            <button type="button" onclick="submitForm()">Next</button>
        </form>
 
    </div>

      <script>
        // Show confirmation popup when close button is clicked
        document.getElementById('closeFormBtn').addEventListener('click', function() {
            document.getElementById('confirmationPopup').style.display = 'block';
        });

        // Function to close the confirmation popup
        function closeConfirmationPopup() {
            document.getElementById('confirmationPopup').style.display = 'none';
        }

        // Function to quit the form
        function quitForm() {
            // Get the file path
            var filePath = "<?php echo $filePath; ?>";
            
            // AJAX request to delete the file
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_file.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // File deleted successfully, now redirect
                        window.location.href = '../index.php'; // Redirect to the desired page after quitting
                    } else {
                        console.error("Error deleting file: " + xhr.responseText);
                        // Still redirect even if file deletion fails
                        window.location.href = '../index.php'; // Redirect to the desired page after quitting
                    }
                }
            };
            xhr.send("filePath=" + filePath);
        }

        // Function to handle form submission
        function submitForm() {
            document.getElementById("checkpointForm").submit();
        }

        // Function to handle camera button click
        document.querySelector('.camera-btn').addEventListener('click', function() {
            document.getElementById('videoContainer').style.display = 'block'; // Show video container
            initCamera(); // Initialize camera
        });

        // Function to initialize camera
        function initCamera() {
            // Get access to the camera
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    var video = document.getElementById('video');
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(err) {
                    console.log("An error occurred: " + err);
                });
        }

        // Function to handle capture button click
        document.getElementById('captureBtn').addEventListener('click', function() {
            var video = document.getElementById('video');
            var canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            var context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            var imageDataURL = canvas.toDataURL('image/jpeg'); // Get image data URL
            var base64Image = imageDataURL.split(',')[1]; // Extract base64 image data
            document.getElementById('videoContainer').style.display = 'none'; // Hide video container
            document.getElementById('media1').value = base64Image; // Set base64 image data to hidden input

            // Display the taken image
            var takenImage = document.getElementById('takenImage');
            takenImage.src = imageDataURL;
            takenImage.style.display = 'block'; // Show the image
        });

        // Function to update assessment color
        function updateAssessmentColor() {
            var selectElement = document.getElementById('assessment1');
            var assessmentContainer = document.getElementById('assessmentContainer');
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            assessmentContainer.style.backgroundColor = selectedOption.style.backgroundColor;
        }

        // Function to fetch responsible and deadline values from the file
        function fetchValues() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?php echo $_SERVER["PHP_SELF"]; ?>', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var values = JSON.parse(xhr.responseText);
                    document.getElementById('responsible1').value = values.responsible;
                    document.getElementById('deadline1').value = values.deadline;
                }
            };
            xhr.send();
        }

        // Fetch values when the page loads
        window.onload = function () {
            fetchValues();
        };
    </script>
</body>
</html>


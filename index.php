<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inspections</title>
  <style>
    /* Resetting default margin and padding */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Circle button styling */
    .circle-button {
      background-color: #191970; /* Dark blue color */
      color: #fff; /* White text */
      border: none;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      font-size: 24px;
      cursor: pointer;
      position: absolute;
      bottom: 20px;
      left: 20px;
      transition: all 0.3s ease-in-out;
      font-family: "Comic Sans MS", "Comic Sans", monospace; /* Set font family */
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4; /* Light gray background */
    }

    /* Navbar styling */
    .navbar {
      background-color: #191970; /* Dark blue color */
      color: #fff; /* White text */
      padding: 15px;
      font-size: 24px;
      font-weight: bold;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Container for inspection buttons */
    .inspection-container {
      display: flex;
      flex-wrap: wrap; /* Allow items to wrap to the next line */
      justify-content: flex-start;
      align-items: center;
      max-width: 800px; /* Adjust this width as needed */
      margin: 0 auto; /* Center the container */
      padding: 20px;
    }

    /* Inspection button styling */
    .inspection-button {
      background-color: #fff; /* White background */
      color: #191970; /* Dark blue text */
      border: 2px solid #191970; /* Dark blue border */
      border-radius: 8px;
      padding: 10px 10px; /* Adjust padding for larger size */
      font-size: 24px; /* Adjust font size for larger size */
      margin: 10px;
      cursor: pointer;
      transition: all 0.3s ease-in-out;
    }

    .inspection-button:hover {
      background-color: #191970; /* Dark blue background on hover */
      color: #fff; /* White text on hover */
    }

    /* Modal styling */
    .modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 1; /* Sit on top */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgba(0, 0, 0, 0.4); /* Black with opacity */
      padding-top: 60px; /* Position the modal's content */
    }

    /* Modal content */
    .modal-content {
      background-color: #fefefe;
      margin: 5% auto; /* 15% from the top and centered */
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Close button */
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover,
    .close:focus {
      color: #333;
      text-decoration: none;
    }

    /* Styling for PDF buttons */
    .pdf-button {
      background-color: #191970; /* Dark blue color */
      color: #fff; /* White text */
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      font-size: 16px;
      margin: 5px;
      cursor: pointer;
      transition: all 0.3s ease-in-out;
    }

    .pdf-button:hover {
      background-color: #00008B; /* Darken button on hover */
    }

    .pdf-button:disabled {
      background-color: #ccc; /* Light gray for disabled state */
      cursor: not-allowed;
    }

    .navbar img {
      width: 50px !important;
      height: 70px !important;
    }

    .navbar {
      background-color: #191970;
      color: #fff;
      padding: 15px;
      font-size: 24px;
      font-weight: bold;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .logo-container {
      display: flex;
      align-items: center;
    }

    .logo-container img {
      width: 50px;
      height: 70px;
      margin-right: 10px;
    }

    .logo-text {
      font-size: 24px;
      line-height: 1.5; /* Adjust line height if needed */
      margin-right: 10px; /* Adjust margin to separate the logo and text */
    }

    .navbar-text {
      line-height: 1.5; /* Adjust line height if needed */
    }
  </style>
</head>
<body>
  <div class="navbar">
    <div class="logo-container">
      <img src="infinty.png" alt="">
      <span class="logo-text">INFINTY<br>inspections</span>
    </div>
  </div>

  <!-- Circle button -->
  <button onclick="window.location.href='0.php'" class="circle-button">
    +
  </button>
  
  <div class="inspection-container">
    <?php
    // Function to save filename to a text file
    function saveFilename($filename) {
      $file = fopen("nameoftext.txt", "w");
      fwrite($file, $filename);
      fclose($file);
    }

    // Loop through potential filenames (form_data.txt, form_data2.txt, etc.) until a file is not found
    $i = 1; // Start from form_data.txt
    while (true) {
      $filename = ($i == 1) ? "form_data.txt" : "form_data" . $i . ".txt";

      if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (isset($lines[1])) {
          $title = trim(str_replace('Title: ', '', $lines[1])); // Assuming the title is on the second line

          // Create a button for each inspection
          echo "<button class='inspection-button' onclick='showModal(\"$filename\")'>$title</button>";
        } else {
          echo "<button class='inspection-button'>No Title Found for $filename</button>";
        }
      } else {
        break; // Stop checking if a file is not found
      }
      
      $i++;
    }
    ?>
  </div>

  <!-- Modal -->
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="hideModal()">&times;</span>
      <p>Choose an option:</p>
      <button id="generatePdfBtn" class="pdf-button" onclick="generatePdf()">Generate PDF</button>
      <button id="viewPdfBtn" class="pdf-button" onclick="viewPdf()" disabled>View PDF</button>
    </div>
  </div>

  <script>
    function showModal(filename) {
      var modal = document.getElementById("myModal");
      modal.style.display = "block";
      // Reset the state of buttons on modal show
      document.getElementById("generatePdfBtn").disabled = false;
      document.getElementById("viewPdfBtn").disabled = true;

      // Save filename to a text file using AJAX
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log('Filename saved: ' + filename);
        }
      };
      xhttp.open("GET", "?save=" + filename, true);
      xhttp.send();
    }

    function hideModal() {
      var modal = document.getElementById("myModal");
      modal.style.display = "none";
    }

    function generatePdf() {
      // Simulating PDF generation
      document.getElementById("generatePdfBtn").disabled = true;
      setTimeout(function() {
        document.getElementById("viewPdfBtn").disabled = false;
      }, 2000); // 2 seconds delay

      // Retrieve filename from the text file using AJAX
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var filename = this.responseText;
          console.log('Generating PDF for: ' + filename);
          // Perform PDF generation logic here
        }
      };
      xhttp.open("GET", "?get", true);
      xhttp.send();
    }

    function viewPdf() {
      // Redirect to generate_pdf.php when "View PDF" button is clicked
      window.location.href = "generate_pdf.php";
    }

    // Check if there's a request to save or get filename
    <?php
      if (isset($_GET['save'])) {
        $filename = $_GET['save'];
        saveFilename($filename);
      }

      if (isset($_GET['get'])) {
        $filename = file_get_contents("nameoftext.txt");
        echo "document.getElementById('viewPdfBtn').disabled = false;";
        echo "console.log('Retrieved filename: ' + '$filename');";
      }
    ?>
  </script>

</body>
</html>

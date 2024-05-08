<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Authentication</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 600px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container h1 {
            margin-bottom: 20px;
            font-family: “Comic Sans MS”, “Comic Sans”, monospace;
        }
        input[type="submit"] {
            cursor: pointer;
            background-color: #1a237e;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0d47a1;
        }
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
        p {
            font-family: “Comic Sans MS”, “Comic Sans”, monospace;
            margin: 0;
            color: #555;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>welcome</h1>
        <form action="register.html">
            <input type="submit" value="Create Free Account">
        </form>
        <hr>
        <p>OR</p>
        <hr>
        <form action="login.html">
            <input type="submit" value="Login to Existing Account">
        </form>
    </div>
</body>
</html>

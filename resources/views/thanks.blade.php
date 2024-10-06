<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            text-align: center;
            padding: 50px 20px;
            margin: 0;
        }
        h1 {
            font-size: 4rem;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.5rem;
            color: #555;
        }
        .thankyou-box {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            font-size: 1.2rem;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        footer {
            margin-top: 50px;
            font-size: 0.9rem;
            color: #aaa;
        }
    </style>
    <script>
        // Prevent back button navigation
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
</head>
<body>

    <div class="thankyou-box">
        <h1>Thank You!</h1>
        <p>Your payment was successful.</p>
        <p>We appreciate your business and hope you enjoy your purchase.</p>
        
        <a href="/" class="btn">Back to Home</a>
    </div>

    <footer>
        &copy; 2024 Your Company. All rights reserved.
    </footer>

</body>
</html>

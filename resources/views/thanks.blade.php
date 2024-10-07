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
            margin: 20px 0px;
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
        window.onpopstate = function() {
            // Refresh the page when the back button is clicked
            location.reload();
        };

        // Ensure that a new state is pushed into the history stack when the page is loaded
        window.onload = function() {
            history.pushState(null, "", location.href);
        };
    </script>
</head>
<body>

    <div class="thankyou-box">
        <svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" viewBox="0 0 24 24">
            <g fill="none" stroke="#4CAF50" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
              <path fill="#C8E6C9" fill-opacity="1" stroke-dasharray="64" stroke-dashoffset="64" d="M3 12c0 -4.97 4.03 -9 9 -9c4.97 0 9 4.03 9 9c0 4.97 -4.03 9 -9 9c-4.97 0 -9 -4.03 -9 -9Z">
                <animate fill="freeze" attributeName="fill-opacity" begin="0.6s" dur="0.15s" values="0;1"/>
                <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="64;0"/>
              </path>
              <path stroke-dasharray="14" stroke-dashoffset="14" d="M8 12l3 3l5 -5">
                <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.75s" dur="0.2s" values="14;0"/>
              </path>
            </g>
        </svg>   
        <h1>Thank You!</h1>
        <p>Your payment was successful.</p>
        <p>We appreciate your business and hope you enjoy your purchase.</p>
    </div>

    <footer>
        &copy; 2024 Atomic. All rights reserved.
    </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription</title>
    <style>
        /* CSS styles for the subscription message */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #fee3ec; /* Pink background color */
            position: relative;
        }

        .message-frame {
            padding: 20px;
            background-color: #fff; /* White background color for frame */
            border-radius: 10px;
            border: 1px solid #000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Nicer font */
            color: #333; /* Darker color for better readability */
        }

        .back-button {
            position: absolute;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #fee3ec;
            border: 1px solid #000;
            border-radius: 5px;
            text-decoration: none;
            color: #000;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #fff;
        }
    </style>
</head>
<body>

<div class="message-frame">
    <h2>Successfully subscribed!</h2>
</div>

<a href="index.html" class="back-button">Back to Home</a>

</body>
</html>

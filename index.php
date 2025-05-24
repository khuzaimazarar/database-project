<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Crave Chicken Restaurant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('main.png'); /* Assuming you have a main.png in your project folder */
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        h1 {
            font-size: 3em;
            color: aqua; /* Similar to your welcome text */
            margin-bottom: 20px;
            animation: changes_color 2.2s infinite, move 2.2s forwards; /* Keep consistent animation */
        }
        p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .buttons a {
            display: inline-block;
            padding: 10px 25px;
            margin: 0 10px;
            background-color: #4CAF50; /* Green button */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .buttons a:hover {
            background-color: #45a049;
        }
        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.75);
            padding: 20px;
            color: white;
            font-size: 0.9em;
        }

        /* Animations from your review.html */
        @keyframes changes_color {
            0%, 30% {
                color: aqua;
            }
            70%, 100% {
                color: rgb(255, 230, 0);
            }
        }
        @keyframes move {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <h1>WELCOME TO CRAVE CHICKEN RESTAURANT</h1>
    <p>Your culinary journey begins here.</p>
    <div class="buttons">
        <a href="customer.php">View Menu & Order</a> <a href="review.php">Leave a Review</a>
        </div>

    <footer>
        <p>© 2025 Crave Kitchen</p>
        <p>At Crave Kitchen, we believe food is not just nourishment — it’s an experience to be celebrated. Every plate we serve reflects our commitment to quality, creativity, and exceptional service.</p>
    </footer>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Our Restaurant</title>
    <link rel="stylesheet" href="login-style.css" />
  </head>
  <style>
    body {
      background-size: cover;
      font-family: Arial, sans-serif;
      background-image: url(main.png);
      position: fixed;
      top: 12%;
      left: 15%;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.01);
      width: 400px;
      margin: 100px auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px gray;
      text-align: center;
    }

    .login-form input {
      width: 90%;
      padding: 10px;
      margin: 10px 0;
      font-size: 16px;
    }

    .login-form button {
      width: 95%;
      padding: 12px;
      background-color: #ff6600;
      border: none;
      font-size: 18px;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }

    .login-form button:hover {
      background-color: #ff8533;
    }

    .login-form a {
      color: #ff6600;
      text-decoration: none;
    }

    .login-form a:hover {
      text-decoration: underline;
    }
    footer {
      position: relative;
      top: 77%;
      left: 7%;
      width: 800px;
    }
    @keyframes changes_color {
      0% {
        color: aqua;
      }
      30% {
        color: aqua;
      }
      70% {
        color: rgb(255, 230, 0);
      }

      100% {
        color: rgb(255, 230, 0);
      }
    }

    @keyframes move {
      0% {
        transform: translateX(-100%);
      }
    }

    .welcome {
      position: fixed;
      top: 4%;
      left: 2%;
      font-size: 43px;
      animation: changes_color 2.2s infinite, move 2.2s forwards;
    }
  </style>
  <body>
    <header>
      <h1 class="welcome">WELCOME TO CRAVE CHICKEN RESTAURANT</h1>
    </header>

    <div class="login-container">
      <h1>Welcome to Our Restaurant</h1>

      <form action="login_check.php" method="POST" class="login-form">
        <h2>Login</h2>
        <input type="text" name="username" placeholder="Username" required />

        <input
          type="password"
          name="password"
          placeholder="Password"
          required
        />

        <button type="submit">Login</button>
      </form>

      <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>
    <footer style="align-items: center">
      <p style="color: bisque; padding-left: 38%; margin-bottom: -28px">
        © 2025 Crave Kitchen
      </p>
      <br />
      <p style="color: white">
        At Crave Kitchen, we believe food is not just nourishment — it’s an
        experience to be celebrated. Our passion lies in crafting fresh,
        flavorful dishes that bring people together around the table. Using only
        the finest locally sourced ingredients, our chefs blend traditional
        techniques with innovative ideas to create meals that are both
        comforting and inspiring. Every plate we serve reflects our commitment
        to quality, creativity, and exceptional service. Whether you're
        gathering with family, meeting friends, or celebrating a special moment,
        we invite you to savor every bite and create lasting memories at Crave
        Kitchen.
      </p>
    </footer>
  </body>
</html>

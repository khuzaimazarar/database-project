<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Browse Menu</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url(main.png);
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      font-family: Arial, sans-serif;
      overflow-x: hidden;
    }

    header {
      text-align: center;
      margin-top: 20px;
    }

    .welcome {
      font-size: 43px;
      animation: changes_color 2.2s infinite, move 2.2s forwards;
    }

    h1, h2 {
      color: aqua;
      text-align: center;
    }

    .button {
      background-color: bisque;
      border-radius: 8px;
      width: 100px;
      height: 37px;
      margin: 10px;
      border: none;
      transition: 0.2s;
    }

    .button:hover {
      background-color: aquamarine;
      color: bisque;
      width: 120px;
      height: 45px;
    }

    nav ul {
      list-style-type: none;
      padding: 0;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
    }

    .Dashboard {
      text-align: center;
      margin-top: 60px;
    }

    .category-title {
      margin-top: 50px;
    }

    .main-div {
      display: flex;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      padding: 20px 5%;
    }

    .main-div div {
      display: flex;
      justify-content: center;
    }

    img {
      width: 250px;
      height: 250px;
      object-fit: cover;
      border-radius: 15px;
      transition: 0.3s;
    }

    img:hover {
      width: 270px;
      height: 270px;
    }

    footer {
      margin-top: 208px;
      background-color: rgba(0, 0, 0, 0.7);
      padding: 30px;
      color: white;
      text-align: center;
    }

    section {
      margin: 50px auto;
      text-align: center;
      width: 90%;
    }

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
    .category-card {
  position: relative;
  display: inline-block;
  overflow: hidden;
  border-radius: 15px;
}

.category-label {
  position: absolute;
  bottom: 0;
  left: 0;
  background: rgba(0, 0, 0, 0.6);
  color: white;
  width: 100%;
  padding: 10px 0;
  text-align: center;
  font-size: 20px;
  opacity: 0;
  transform: translateY(100%);
  transition: all 0.4s ease;
  border-bottom-left-radius: 15px;
  border-bottom-right-radius: 15px;
}

.category-card:hover .category-label {
  opacity: 1;
  transform: translateY(0);
}

  </style>
</head>
<body>

  <header>
    <h1 class="welcome">WELCOME TO CRAVE CHICKEN RESTAURANT</h1>
  </header>

  <div class="Dashboard">
    <h1>Browse Our Menu</h1>
    <nav>
      <ul>
        <li><a href="payment-form.php"><button class="button">Place Order</button></a></li>
        <li><a href="view-cart.php"><button class="button">View Cart Orders</button></a></li>
      </ul>
    </nav>
  </div>


   <div class="main-div">
    <div class="category-card">
      <a href="special-items.php"><img src="Special.jpg" alt="Special"></a>
      <div class="category-label">Special</div>
    </div>
    <div class="category-card">
      <a href="pizza.php"><img src="Pizza.jpg" alt="Pizza"></a>
      <div class="category-label">Pizza</div>
    </div>
    <div class="category-card">
      <a href="burger.php"><img src="Burger.webp" alt="Burger"></a>
      <div class="category-label">Burger</div>
    </div>
    <div class="category-card">
      <a href="drinks.php"><img src="Drinks.jpg" alt="Drinks"></a>
      <div class="category-label">Drinks</div>
    </div>
    <div class="category-card">
      <a href="pasta.php"><img src="pastas.jpg" alt="Pastas"></a>
      <div class="category-label">Pastas</div>
    </div>
    <div class="category-card">
      <a href="dessert.php"><img src="Dessert.jpg" alt="Dessert"></a>
      <div class="category-label">Dessert</div>
    </div>
    <div class="category-card">
      <a href="Appetizers.php"><img src="appetizers.webp" alt="Appetizers"></a>
      <div class="category-label">Appetizers</div>
    </div>
    <div class="category-card">
      <a href="vegeterian.php"><img src="Vegetarian.jpg" alt="Vegetarian"></a>
      <div class="category-label">Vegetarian</div>
    </div>
    <div class="category-card">
      <a href="salad.php"><img src="Salad.jpg" alt="Salad"></a>
      <div class="category-label">Salad</div>
    </div>
  </div>
  <section>

  </section>

  <footer>
    <p style="color: bisque;">© 2025 Crave Kitchen</p><br>
    <p>
      At Crave Kitchen, we believe food is not just nourishment — it’s an experience to be celebrated.
      Our passion lies in crafting fresh, flavorful dishes that bring people together around the table.
      Using only the finest locally sourced ingredients, our chefs blend traditional techniques with innovative ideas to create meals that are both comforting and inspiring.
      Every plate we serve reflects our commitment to quality, creativity, and exceptional service.
      Whether you're gathering with family, meeting friends, or celebrating a special moment, we invite you to savor every bite and create lasting memories at Crave Kitchen.
    </p>
  </footer>

</body>
</html>

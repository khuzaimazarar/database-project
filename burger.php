<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Browse Menu</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Your existing CSS styles */
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
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 2%;
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* exactly 4 per row */
        gap: 20px;
        justify-content: center;
        padding: 20px 5%;
    }

    .main-div > div { /* Target direct children of main-div, which are category-cards */
      display: flex;
      flex-direction: column; /* Stack image, labels, and new button vertically */
      align-items: center; /* Center items horizontally within the card */
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
      margin-top: 50px;
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
      /* Add some padding for the button */
      padding-bottom: 50px; /* Make space for the button below the image/labels */
    }
    .description {
      position: absolute;
      padding: 10px;
      font-size: 16px;
      border-radius: 15px;
      z-index: 1;
      margin-bottom: 8px;
      font-size: 16px;
      color: white;
      background: rgba(0, 0, 0, 0.75);
      text-align: center;
      padding: 5px 10px;
      border-radius: 10px;
      opacity: 0;
      transform: translateY(-10px);
      transition: opacity 0.4s ease, transform 0.3s ease;
    }
    .category-label { /* Burger Name */
      position: absolute;
      bottom: 45px; /* Adjust this to be above the add to cart button */
      left: 50%;
      transform: translateX(-50%);
      background: rgba(0, 0, 0, 0.6);
      color: white;
      width: 100%; /* Make it span the width of the card */
      padding: 10px 0;
      text-align: center;
      font-size: 20px;
      opacity: 0;
      transition: all 0.4s ease;
      /* Removed border-bottom-left/right-radius as it's now internal */
    }

    .category-card:hover .category-label {
      opacity: 1;
      transform: translateX(-50%);
    }
    .category-label2 { /* Burger Price */
      position: absolute;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(0, 0, 0, 0.6);
      color: white;
      width: 100%; /* Make it span the width of the card */
      padding: 10px 0;
      text-align: center;
      font-size: 20px;
      opacity: 0;
      transition: all 0.4s ease;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }

    .category-card:hover .category-label2 {
      opacity: 1;
      transform: translateX(-50%);
    }

    /* New CSS for Add to Cart button */
    .add-to-cart-btn {
        position: absolute;
        bottom: 0; /* Position at the bottom of the card */
        left: 50%;
        transform: translateX(-50%);
        width: 100%; /* Span the width of the card */
        padding: 10px;
        background-color: #007bff; /* Blue, common for add to cart */
        color: white;
        border: none;
        border-radius: 0 0 15px 15px; /* Rounded bottom corners */
        cursor: pointer;
        font-size: 16px;
        opacity: 0; /* Hidden by default */
        transition: opacity 0.4s ease;
        z-index: 2; /* Make sure it's above other elements if needed */
    }

    .category-card:hover .add-to-cart-btn {
        opacity: 1; /* Show on hover */
    }

  </style>
</head>
<body>

  <header>
    <h1 class="welcome">WELCOME TO CRAVE CHICKEN RESTAURANT</h1>
  </header>

  <div class="Dashboard">
    <h1>Order Now!</h1>
    <nav>
      <ul>
        <li><a href="payment-form.php"><button class="button">Place Order</button></a></li>
        <li><a href="view-cart.php"><button class="button">View Cart</button></a></li>
      </ul>
    </nav>
  </div>

  <h1 class="category-title">Choose Your Items</h1>
  <div class="main-div">
    <div class="category-card">
      <img src="Classic Beef Burger.jpg" alt="Classic Beef Burger">
      <div class="category-label">Classic Beef Burger</div>
      <div class="category-label2">Rs. 250</div>
      <button class="add-to-cart-btn" data-item-name="Classic Beef Burger" data-item-price="250">Add to Cart</button>
    </div>
    <div class="category-card">
      <img src="Chicken Zinger Burger.jpg" alt="Chicken Zinger Burger">
      <div class="category-label2">Rs. 280</div>
      <div class="category-label">Chicken Zinger Burger</div>
      <button class="add-to-cart-btn" data-item-name="Chicken Zinger Burger" data-item-price="280">Add to Cart</button>
    </div>
    <div class="category-card">
      <img src="Spicy Veggie Burger.jpg" alt="Spicy Veggie Burger">
      <div class="category-label2">Rs. 220</div>
      <div class="category-label">Spicy Veggie Burger</div>
      <button class="add-to-cart-btn" data-item-name="Spicy Veggie Burger" data-item-price="220">Add to Cart</button>
    </div>
    <div class="category-card">
      <img src="BBQ Chicken Burger.jpg" alt="BBQ Chicken Burger">
      <div class="category-label2">Rs. 300</div>
      <div class="category-label">BBQ Chicken Burger</div>
      <button class="add-to-cart-btn" data-item-name="BBQ Chicken Burger" data-item-price="300">Add to Cart</button>
    </div>
    <div class="category-card">
      <img src="Mushroom Swiss Burger.jpg" alt="Mushroom Swiss Burger">
      <div class="category-label2">Rs. 320</div>
      <div class="category-label">Mushroom Swiss Burger</div>
      <button class="add-to-cart-btn" data-item-name="Mushroom Swiss Burger" data-item-price="320">Add to Cart</button>
    </div>
    <div class="category-card">
      <img src="Cheese Love Burger.jpg" alt="Cheese Love Burger">
      <div class="category-label2">Rs. 350</div>
      <div class="category-label">Cheese Love Burger</div>
      <button class="add-to-cart-btn" data-item-name="Cheese Love Burger" data-item-price="350">Add to Cart</button>
    </div>
    <div class="category-card">
      <img src="TeriYaki Burger.jpg" alt="TeriYaki Burger">
      <div class="category-label2">Rs. 290</div>
      <div class="category-label">TeriYaki Burger</div>
      <button class="add-to-cart-btn" data-item-name="TeriYaki Burger" data-item-price="290">Add to Cart</button>
    </div>
    <div class="category-card">
      <img src="Veggie delight Burger.jpg" alt="Veggie Delight Burger">
      <div class="category-label2">Rs. 210</div>
      <div class="category-label">Veggie Delight Burger</div>
      <button class="add-to-cart-btn" data-item-name="Veggie Delight Burger" data-item-price="210">Add to Cart</button>
    </div>
    <div class="category-card">
      <img src="Double Beef Burger.jpg" alt="Double Beef Burger">
      <div class="category-label2">Rs. 380</div>
      <div class="category-label">Double Beef Burger</div>
      <button class="add-to-cart-btn" data-item-name="Double Beef Burger" data-item-price="380">Add to Cart</button>
    </div>
  </div>


  <section>
    <h2>Menu Items</h2>
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

<script>
    const items = document.querySelectorAll(".category-card");

    items.forEach(item => {
        item.addEventListener("click", () => {
            const name = item.querySelector(".category-label").innerText;
            // Get the text, remove "Rs. " and then parse it as a floating-point number
            const priceText = item.querySelector(".category-label2").innerText;
            const price = parseFloat(priceText.replace("Rs. ", "")); // THIS IS THE KEY CHANGE

            // Fetch cart or initialize
            let cart = JSON.parse(localStorage.getItem("cart")) || [];

            // Push new item (now 'price' is a number)
            cart.push({ name, price });

            // Save updated cart
            localStorage.setItem("cart", JSON.stringify(cart));

            alert(`${name} added to cart!`);
        });
    });
</script>
</body>
</html>
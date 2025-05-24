<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dessert Menu | Crave Chicken Restaurant</title>
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
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 2%;
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* exactly 4 per row */
        gap: 20px;
        justify-content: center;
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

.category-label {
  position: absolute;
  bottom: 0;
  left: -25px;
  background: rgba(0, 0, 0, 0.6);
  color: white;
  width: 271px;
  margin-left: 95px;
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
.category-label2 {
  position: absolute;
  top: 0;
  left: -25px;
  background: rgba(0, 0, 0, 0.6);
  color: white;
  width: 271px;
  margin-left: 95px;
  padding: 10px 0;
  text-align: center;
  font-size: 20px;
  opacity: 0;
  transform: translateY(-100%);
  transition: all 0.4s ease;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;
}

.category-card:hover .category-label2 {
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
    <h1>Order Now!</h1>
    <nav>
      <ul>
        <li><a href="payment-form.php"><button class="button">Place Order</button></a></li>
        <li><a href="view-cart.php"><button class="button">View Cart</button></a></li>
      </ul>
    </nav>
  </div>

  <h1 class="category-title">Choose Your Appetizers</h1>   <div class="main-div">

        <div class="category-card" data-desc="Rich and moist Appetizer">
      <div class="description"></div>       <img src="A1.jpeg" alt="Chocolate Cake">       <div class="category-label">Chocolate Cake</div>       <div class="category-label2">800</div>     </div>


    <div class="category-card" data-desc="Creamy and classic Appetizer">
      <div class="description"></div>
      <img src="A2.jpeg" alt="Cheesecake">       <div class="category-label">Cheese appetizer</div>
      <div class="category-label2">950</div>
    </div>

    <div class="category-card" data-desc="Delicious assorted Appetizer">
      <div class="description"></div>
      <img src="A3.jpg" alt="Assorted Pastries">       <div class="category-label">Assorted appetizer</div>
      <div class="category-label2">600</div>
    </div>

    <div class="category-card" data-desc="Italian Appetizer.">
      <div class="description"></div>
      <img src="A4.jpg" alt="Tiramisu">       <div class="category-label">Tiramisu apppetizers</div>
      <div class="category-label2">750</div>
    </div>

    <div class="category-card" data-desc="Warm, Appetizer.">
      <div class="description"></div>
      <img src="A5.jpg" alt="Chocolate Brownie">       <div class="category-label">special appetizer</div>
      <div class="category-label2">400</div>
    </div>

    <div class="category-card" data-desc="French Appetizers">
      <div class="description"></div>
      <img src="A5.jpg" alt="Ice Cream">       <div class="category-label">Cream pie appetizer</div>
      <div class="category-label2">300</div>
    </div>

          </div>


  <section>
    <h2>Other Menu Categories</h2>      <nav>
         <ul>
             <li><a href="customer.html"><button class="button">Browse All</button></a></li>
             <li><a href="pizza.html"><button class="button">Pizza</button></a></li>
             <li><a href="burger.html"><button class="button">Burger</button></a></li>
             <li><a href="drinks.html"><button class="button">Drinks</button></a></li>
             <li><a href="pasta.html"><button class="button">Pasta</button></a></li>
                      </ul>
     </nav>
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
  // JavaScript for showing description on hover with a delay
  const cards = document.querySelectorAll('.category-card');

  cards.forEach(card => {
    const descDiv = card.querySelector('.description');
    const text = card.getAttribute('data-desc'); // Get description from data-desc
    let timer;

    card.addEventListener('mouseenter', () => {
      timer = setTimeout(() => {
        descDiv.textContent = text;
        descDiv.style.opacity = '1';
        descDiv.style.transform = 'scale(1)';
      }, 500); // 0.5 second delay
    });

    card.addEventListener('mouseleave', () => {
      clearTimeout(timer);
      descDiv.style.opacity = '0';
      descDiv.style.transform = 'scale(0.95)';
      descDiv.textContent = ''; // Clear text on mouse leave
    });
  });

  // JavaScript for adding items to local storage cart on click
  const items = document.querySelectorAll(".category-card");

  items.forEach(item => {
    item.addEventListener("click", (event) => {
      // Check if the click target is the description div itself, and ignore if so
       if (event.target.classList.contains('description')) {
         return; // Do nothing if the click is on the description tooltip
       }

        const name = item.querySelector(".category-label").innerText;
        const priceText = item.querySelector(".category-label2").innerText;
        const price = parseFloat(priceText);

        // Fetch cart or initialize
        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        // Push new item
        cart.push({ name, price });

        // Save updated cart
        localStorage.setItem("cart", JSON.stringify(cart));

        alert(`${name} added to cart!`);
    });
  });

</script>

</body>
</html>
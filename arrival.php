<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Order Delivered</title>
  <style>
    body {
      margin: 0;
      background-image: url(main.png);
      background-size: cover;
      background-position: center;
      font-family: Arial, sans-serif;
      color: white;
    }

    header {
      text-align: center;
      padding: 40px 0 20px;
    }

    .welcome {
      font-size: 43px;
      animation: changes_color 2.2s infinite, move 2.2s forwards;
    }

    .container {
      background-color: rgba(0, 0, 0, 0.6);
      margin: 20px auto;
      padding: 30px;
      width: 70%;
      border-radius: 10px;
      text-align: center;
    }

    .delivery-confirmation {
      background-color: #fff8dc;
      color: black;
      margin: 20px auto;
      padding: 30px;
      border-radius: 8px;
      max-width: 500px;
    }

    .confirmation-title {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #4CAF50;
    }

    .btn {
      padding: 12px 24px;
      margin: 10px;
      border: none;
      border-radius: 6px;
      font-size: 18px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-primary {
      background-color: #4CAF50;
      color: white;
    }

    .btn-secondary {
      background-color: #f44336;
      color: white;
    }

    .btn:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }

    @keyframes changes_color {
      0%, 30% { color: aqua; }
      70%, 100% { color: rgb(255, 230, 0); }
    }

    @keyframes move {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(0); }
    }

    footer {
      margin-top: 50px;
      background-color: rgba(0, 0, 0, 0.7);
      padding: 30px;
      color: white;
      text-align: center;
    }
  </style>
</head>
<body>
  <header>
    <h1 class="welcome">ORDER DELIVERY CONFIRMATION</h1>
  </header>
  
  <div class="container">
    <div class="delivery-confirmation">
      <div class="confirmation-title">Has your order arrived?</div>
      <p>Please confirm delivery and help us improve by rating your experience.</p>
      
      <button class="btn btn-primary" onclick="confirmDelivery()">Yes, My Order Arrived</button>
      <button class="btn btn-secondary" onclick="window.location.href='index.php'">Not Yet</button>
    </div>
  </div>

  <footer>
    <p style="color: bisque;">© 2025 Crave Kitchen</p><br>
    <p>
      At Crave Kitchen, we believe food is not just nourishment — it's an experience to be celebrated.
      Our passion lies in crafting fresh, flavorful dishes that bring people together around the table.
      Using only the finest locally sourced ingredients, our chefs blend traditional techniques with innovative ideas to create meals that are both comforting and inspiring.
      Every plate we serve reflects our commitment to quality, creativity, and exceptional service.
      Whether you're gathering with family, meeting friends, or celebrating a special moment, we invite you to savor every bite and create lasting memories at Crave Kitchen.
    </p>
  </footer>

  <script>
    function confirmDelivery() {
      if (confirm("Thank you for confirming! Would you like to rate your experience?")) {
        // Redirect to review page
        window.location.href = "review.php";
        
        // Optional: Mark order as delivered in localStorage
        const orders = JSON.parse(localStorage.getItem("orders")) || [];
        const lastOrderIndex = orders.length - 1;
        if (lastOrderIndex >= 0) {
          orders[lastOrderIndex].status = "Delivered";
          localStorage.setItem("orders", JSON.stringify(orders));
        }
      } else {
        // Optional: Just mark as delivered without review
        const orders = JSON.parse(localStorage.getItem("orders")) || [];
        const lastOrderIndex = orders.length - 1;
        if (lastOrderIndex >= 0) {
          orders[lastOrderIndex].status = "Delivered";
          localStorage.setItem("orders", JSON.stringify(orders));
        }
        alert("Thank you for your order!");
        window.location.href = "customer.php";
      }
    }
  </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment Page</title>
  <style>
    body {
      background-image: url(main.png);
      background-size: cover;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 40px;
      width: 400px;
      margin: 140px auto;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      border-radius: 10px;
      color: white;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: aqua;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input, select {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #4CAF50;
      color: white;
      font-size: 18px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #45a049;
    }

    .welcome {
      font-size: 43px;
      animation: changes_color 2.2s infinite, move 2.2s forwards;
    }

    footer {
      background-color: rgba(0, 0, 0, 0.8);
      margin-top: 60px;
      padding: 20px;
      text-align: center;
      color: white;
    }

    footer p:first-child {
      color: bisque;
      font-weight: bold;
    }

    @keyframes move {
      0% {
        transform: translateX(-100%);
      }
      100% {
        transform: translateX(25%);
      }
    }

    @keyframes changes_color {
      0%, 30% {
        color: aqua;
      }
      70%, 100% {
        color: rgb(255, 230, 0);
      }
    }
  </style>
</head>
<body>
  <header>
    <h1 class="welcome">WELCOME TO CRAVE CHICKEN RESTAURANT</h1>
  </header>

  <div class="container">
    <h2>Payment Information</h2>
    <form id="payment-form">
      <div class="form-group">
        <label for="name">Cardholder Name</label>
        <input type="text" id="name" name="name" required />
      </div>

      <div class="form-group">
        <label for="cardNumber">Card Number</label>
        <input type="text" id="cardNumber" name="cardNumber" maxlength="16" required />
      </div>

      <div class="form-group">
        <label for="expDate">Expiration Date</label>
        <input type="month" id="expDate" name="expDate" required />
      </div>

      <div class="form-group">
        <label for="cvv">CVV</label>
        <input type="text" id="cvv" name="cvv" maxlength="4" required />
      </div>

      <div class="form-group">
        <label for="billing">Billing Address</label>
        <input type="text" id="billing" name="billing" required />
      </div>

      <div class="form-group">
        <label for="delivery">Delivery Address</label>
        <input type="text" id="delivery" name="delivery" required />
      </div>

      <div class="form-group">
        <label for="paymentType">Payment Type</label>
        <select id="paymentType" name="paymentType" required>
          <option value="">Select</option>
          <option value="Credit">Credit Card</option>
          <option value="Debit">Debit Card</option>
        </select>
      </div>

      <div class="form-group">
        <label for="notes">Notes (Optional)</label>
        <input type="text" id="notes" name="notes" placeholder="Any instructions or requests..." />
      </div>
      <label for="amount">Payment Amount</label>
      <input style="margin-bottom: 25px ;" type="number" id="amount" name="amount" required min="0" step="0.01">
      <button type="submit">Submit Payment</button>
    </form>
  </div>

  <footer>
    <p>© 2025 Crave Kitchen</p>
    <p>
      At Crave Kitchen, we believe food is not just nourishment — it's an experience to be celebrated.
      Our passion lies in crafting fresh, flavorful dishes that bring people together around the table.
      Using only the finest locally sourced ingredients, our chefs blend traditional techniques with
      innovative ideas to create meals that are both comforting and inspiring.
    </p>
  </footer>

  <script>
    document.getElementById("payment-form").addEventListener("submit", function (e) {
      e.preventDefault();
  
      const enteredAmount = parseFloat(document.getElementById("amount").value);
      const bill = parseFloat(localStorage.getItem("totalBill"));

      if (enteredAmount < bill) {
        alert(`Payment failed! Entered amount is less than the total bill (Rs. ${bill}).`);
      } else {
        alert("Payment successful! Press OK to continue.");
        // Clear cart and bill
        localStorage.removeItem("cart");
        localStorage.removeItem("totalBill");
        // Redirect to index.html
        window.location.href = "arrival.php";
      }
    });
  </script>
</body>
</html>
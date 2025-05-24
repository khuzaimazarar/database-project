<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Reviews</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      min-height: 100vh;
      font-family: Arial, sans-serif;
      background: url('main.png') no-repeat center center fixed;
      background-size: cover;
      overflow-x: hidden;
    }

    header {
      text-align: center;
      padding: 40px 0 20px;
    }

    .welcome {
      font-size: 43px;
      animation: changes_color 2.2s infinite, move 2.2s forwards;
      color: white;
    }

    .container {
      background-color: rgba(0, 0, 0, 0.6);
      margin: 20px auto;
      padding: 30px;
      width: 70%;
      border-radius: 10px;
      color: white;
    }

    .review {
      background-color: #fff8dc;
      color: black;
      margin: 10px 0;
      padding: 15px;
      border-radius: 8px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .review-actions {
      display: flex;
      align-items: center;
    }

    .review-actions button {
      margin-left: 10px;
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .approve {
      background-color: green;
      color: white;
    }

    .reject {
      background-color: crimson;
      color: white;
    }

    .delete {
      background-color: #444;
      color: white;
    }

    .status {
      margin-left: 15px;
      font-weight: bold;
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
      margin-top: 619px;
      background-color: rgba(0, 0, 0, 0.7);
      padding: 30px;
      color: white;
      text-align: center;
    }
  </style>
</head>
<body>
  <header>
    <h1 class="welcome">STAFF - MANAGE CUSTOMER REVIEWS</h1>
  </header>
  <div class="container" id="reviewContainer">
    <!-- Reviews will be loaded here -->
  </div>

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
    function setStatus(button, message) {
      const statusSpan = button.parentElement.querySelector(".status");
      statusSpan.textContent = message;
    }

    function deleteReviewButton(button) {
      const review = button.closest('.review');
      review.innerHTML = '<strong style="color: white;">🗑️ This review was deleted.</strong>';
      review.style.justifyContent = 'center';
      review.style.color = 'white';
      review.style.backgroundColor = 'rgba(255, 0, 0, 0.3)';
    }

    function loadReviews() {
      const container = document.getElementById("reviewContainer");
      const reviews = JSON.parse(localStorage.getItem("reviews")) || [];

      container.innerHTML = "";

      reviews.forEach((review, index) => {
        const div = document.createElement("div");
        div.className = "review";
        div.innerHTML = `
          <div>
            <span><strong>${review.name}</strong>:</span> ${review.text}
            <span class="status">[${review.status || ''}]</span>
          </div>
          <div class="review-actions">
            <button class="approve" onclick="updateStatus(${index}, '✅ Approved')">Approve</button>
            <button class="reject" onclick="updateStatus(${index}, '❌ Rejected')">Reject</button>
            <button class="delete" onclick="deleteReview(${index})">Delete</button>
          </div>
        `;
        container.appendChild(div);
      });
    }

    function updateStatus(index, status) {
      const reviews = JSON.parse(localStorage.getItem("reviews")) || [];
      reviews[index].status = status;
      localStorage.setItem("reviews", JSON.stringify(reviews));
      loadReviews();
    }

    function deleteReview(index) {
      const reviews = JSON.parse(localStorage.getItem("reviews")) || [];
      reviews.splice(index, 1);
      localStorage.setItem("reviews", JSON.stringify(reviews));
      loadReviews();
    }

    loadReviews();
    function loadReviews() {
    const reviewContainer = document.getElementById("reviewSection");
    const reviews = JSON.parse(localStorage.getItem("reviews")) || [];

    const approvedReviews = reviews.filter(review => review.status === '✅ Approved');

    if (approvedReviews.length === 0) {
      reviewContainer.innerHTML = '<p style="color: lightgray;">No approved reviews to show.</p>';
      return;
    }

    approvedReviews.forEach((review) => {
      const div = document.createElement("div");
      div.className = "review";
      div.innerHTML = `<strong>${review.name}:</strong> ${review.text}`;
      reviewContainer.appendChild(div);
    });
  }

  loadReviews();
  </script>
</body>
</html>

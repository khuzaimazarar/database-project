<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crave Chicken Admin Panel</title>
    <style>
        body {
            background-image: url(main.png);
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px;
            margin-top: 0;
        }

        .button {
            background-color: bisque;
            border-radius: 8px;
            width: 100px;
            height: 37px;
            margin-bottom: 1%;
            border-width: 0px;
            transition-duration: 0.2s;
        }

        .button:hover {
            background-color: aquamarine;
            color: bisque;
            width: 120px;
            height: 45px;
        }

        h1, h2 {
            color: aqua;
        }

        @keyframes changes_color {
            0%, 30% { color: aqua; }
            70%, 100% { color: rgb(255, 230, 0); }
        }

        @keyframes move {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(20%); }
        }

        .welcome {
            
            margin-top: -1%;
            left: 50%;
            transform: translateX(-50%);
            font-size: 43px;
  
            padding: 10px 20px;
            border-radius: 8px;
            animation: changes_color 2.2s infinite, move 2.2s forwards;
            z-index: 999;
        }
        footer {
            position: relative;
            top: 45px;
            left: 590px;
            width: 670px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: auto;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 15px 20px;
            text-align: center;
        }

        thead {
            background-color: #007BFF;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #d6e9ff;
            cursor: pointer;
        }

        th {
            font-size: 18px;
        }

        td {
            font-size: 16px;
            color: #333;
        }

        .controls {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <header>
        <h1 class="welcome">WELCOME TO CRAVE CHICKEN RESTAURANT</h1>
    </header>

    <div class="controls">
        <button class="button" onclick="addUser()">Add Order</button>
    </div>

    <table id="userTable">
        <thead>
            <tr>
                <th>Menu Item ID</th>
                <th>Item Name</th>
                <th>Description</th>
                <th>Price (Rs)</th>
                <th>Category</th>
                <th>Availability</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>101</td>
                <td>Classic Beef Burger</td>
                <td>A delicious beef patty with fresh lettuce, tomato, and cheese, served in a soft bun.</td>
                <td>250</td>
                <td>Burger</td>
                <td>Available</td>
                <td>
                    <button class="button" onclick="editRow(this)">Edit</button>
                    <button class="button" onclick="deleteRow(this)">Delete</button>
                </td>
            </tr>
            <tr>
                <td>102</td>
                <td>Pepperoni Pizza</td>
                <td>A classic pizza topped with pepperoni slices, cheese, and tomato sauce</td>
                <td>400</td>
                <td>Pizza</td>
                <td>Available</td>
                <td>
                    <button class="button" onclick="editRow(this)">Edit</button>
                    <button class="button" onclick="deleteRow(this)">Delete</button>
                </td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>

    <footer>
        <p style="color: bisque; padding-left: 38%; margin-bottom: -28px;">© 2025 Crave Kitchen</p><br>
        <p style="color: white;">At Crave Kitchen, we believe food is not just nourishment — it’s an experience to be celebrated.
        Our passion lies in crafting fresh, flavorful dishes that bring people together around the table.
        Using only the finest locally sourced ingredients, our chefs blend traditional techniques with innovative ideas to create meals that are both comforting and inspiring.
        Every plate we serve reflects our commitment to quality, creativity, and exceptional service.
        Whether you're gathering with family, meeting friends, or celebrating a special moment, we invite you to savor every bite and create lasting memories at Crave Kitchen.</p>
    </footer>

    <script>
        function deleteRow(btn) {
            const row = btn.parentElement.parentElement;
            row.remove();
        }

        function editRow(btn) {
            const row = btn.parentElement.parentElement;
            const cells = row.querySelectorAll('td');
            for (let i = 0; i < cells.length - 1; i++) {
                const input = document.createElement('input');
                input.value = cells[i].innerText;
                cells[i].innerText = '';
                cells[i].appendChild(input);
            }
            btn.textContent = 'Save';
            btn.onclick = function () {
                for (let i = 0; i < cells.length - 1; i++) {
                    cells[i].innerText = cells[i].querySelector('input').value;
                }
                btn.textContent = 'Edit';
                btn.onclick = () => editRow(btn);
            };
        }

        function addUser() {
            const table = document.getElementById('userTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            const nextId = table.rows.length + 2;
            const fields = ['Order ID', 'Special Instructions', 'Menu Item ID', 'Quantity', 'Status', 'Payment'];

            const cell0 = newRow.insertCell(0);
            cell0.innerText = nextId;

            for (let i = 1; i <= fields.length; i++) {
                const cell = newRow.insertCell(i);
                const input = prompt(`Enter ${fields[i - 1]}:`);
                cell.innerText = input || '—';
            }

            const actionCell = newRow.insertCell(fields.length + 1);
            actionCell.innerHTML = '<button class="button" onclick="editRow(this)">Edit</button> <button class="button" onclick="deleteRow(this)">Delete</button>';
        }
    </script>
</body>
</html>

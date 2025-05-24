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
                <th>Customer ID</th>
                <th>Order Item ID</th>
                <th>Order ID</th>
                <th>Special Instructions</th>
                <th>Menu Item ID</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>19</td><td>2</td><td>1</td><td>No onions</td><td>102</td><td>18</td><td>Pending</td><td>Unpaid</td><td><button class="button" onclick="editRow(this)">Edit</button> <button class="button" onclick="deleteRow(this)">Delete</button></td></tr>
            <tr><td>20</td><td>3</td><td>3</td><td>Spicy level high</td><td>103</td><td>42</td><td>Pending</td><td>Unpaid</td><td><button class="button" onclick="editRow(this)">Edit</button> <button class="button" onclick="deleteRow(this)">Delete</button></td></tr>
            <tr><td>21</td><td>4</td><td>2</td><td>Gluten-free</td><td>104</td><td>77</td><td>Pending</td><td>Unpaid</td><td><button class="button" onclick="editRow(this)">Edit</button> <button class="button" onclick="deleteRow(this)">Delete</button></td></tr>
            <tr><td>22</td><td>5</td><td>1</td><td>No mayo</td><td>105</td><td>23</td><td>Pending</td><td>Unpaid</td><td><button class="button" onclick="editRow(this)">Edit</button> <button class="button" onclick="deleteRow(this)">Delete</button></td></tr>
            <tr><td>20</td><td>6</td><td>4</td><td>Cut into halves</td><td>106</td><td>90</td><td>Pending</td><td>Unpaid</td><td><button class="button" onclick="editRow(this)">Edit</button> <button class="button" onclick="deleteRow(this)">Delete</button></td></tr>
            <tr><td>24</td><td>7</td><td>2</td><td>Less spicy</td><td>107</td><td>122</td><td>Pending</td><td>Unpaid</td><td><button class="button" onclick="editRow(this)">Edit</button> <button class="button" onclick="deleteRow(this)">Delete</button></td></tr>
            <tr><td>24</td><td>8</td><td>1</td><td>Add extra sauce</td><td>108</td><td>135</td><td>Pending</td><td>Unpaid</td><td><button class="button" onclick="editRow(this)">Edit</button> <button class="button" onclick="deleteRow(this)">Delete</button></td></tr>
            <tr><td>19</td><td>9</td><td>3</td><td>Serve hot</td><td>109</td><td>200</td><td>Pending</td><td>Unpaid</td><td><button class="button" onclick="editRow(this)">Edit</button> <button class="button" onclick="deleteRow(this)">Delete</button></td></tr>
            <tr><td>219</td><td>10</td><td>2</td><td>No special instructions</td><td>110</td><td>155</td><td>Pending</td><td>Unpaid</td><td><button class="button" onclick="editRow(this)">Edit</button> <button class="button" onclick="deleteRow(this)">Delete</button></td></tr>
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

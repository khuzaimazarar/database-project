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
        <button class="button" onclick="addStaff()">Add Staff</button>
    </div>

    <table id="userTable">
        <thead>
            <tr>
                <th>Staff ID</th>
                <th>Full Name</th>
                <th>Role</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Shift</th>
                <th>Salary</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>201</td><td>Ali Raza</td><td>Manager</td><td>ali@example.com</td><td>03001234567</td><td>Morning</td><td>50000</td>
                <td><button class="button" onclick="editStaffRow(this)">Edit</button> <button class="button" onclick="deleteStaffRow(this)">Delete</button></td>
            </tr>
            <tr>
                <td>202</td><td>Sana Khan</td><td>Chef</td><td>sana@example.com</td><td>03007654321</td><td>Evening</td><td>45000</td>
                <td><button class="button" onclick="editStaffRow(this)">Edit</button> <button class="button" onclick="deleteStaffRow(this)">Delete</button></td>
            </tr>
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
        function editStaffRow(btn) {
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
                btn.onclick = () => editStaffRow(btn);
            };
        }

        function deleteStaffRow(btn) {
            const row = btn.parentElement.parentElement;
            row.remove();
        }

        function addStaff() {
            const table = document.getElementById('staffTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            const nextId = table.rows.length + 201;

            const fullName = document.getElementById("fullName").value;
            const role = document.getElementById("role").value;
            const email = document.getElementById("email").value;
            const phone = document.getElementById("phone").value;
            const shift = document.getElementById("shift").value;
            const salary = document.getElementById("salary").value;

            const cell0 = newRow.insertCell(0);
            cell0.innerText = nextId;

            newRow.insertCell(1).innerText = fullName;
            newRow.insertCell(2).innerText = role;
            newRow.insertCell(3).innerText = email;
            newRow.insertCell(4).innerText = phone;
            newRow.insertCell(5).innerText = shift;
            newRow.insertCell(6).innerText = salary;

            const actionCell = newRow.insertCell(7);
            actionCell.innerHTML = '<button class="button" onclick="editStaffRow(this)">Edit</button> <button class="button" onclick="deleteStaffRow(this)">Delete</button>';

            // Close modal after adding
            closeModal();
        }
    </script>
</body>
</html>

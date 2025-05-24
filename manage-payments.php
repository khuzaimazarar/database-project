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
            margin-top: 125px;
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
            100% { transform: translateX(21%); }
        }

        .welcome {
            margin-top: -7%;
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
            margin-top: 3%;
            margin-left: 29%;
            width: 800px;
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
        <button class="button" onclick="addUser()">Add User</button>
    </div>

    <table id="userTable">
        <thead>
            <tr>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Age</th>
                <th>Email</th>
                <th>Role</th>
                <th>Phone No</th>
                <th>Address</th>
                <th>Signup Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded here -->
        </tbody>
    </table>

    <footer>
        <p style="color: bisque; padding-left: 38%; margin-bottom: -28px;">© 2025 Crave Kitchen</p><br>
        <p style="color: white;">At Crave Kitchen, we believe food is not just nourishment — it's an experience to be celebrated.
        Our passion lies in crafting fresh, flavorful dishes that bring people together around the table.
        Using only the finest locally sourced ingredients, our chefs blend traditional techniques with innovative ideas to create meals that are both comforting and inspiring.
        Every plate we serve reflects our commitment to quality, creativity, and exceptional service.
        Whether you're gathering with family, meeting friends, or celebrating a special moment, we invite you to savor every bite and create lasting memories at Crave Kitchen.</p>
    </footer>

    <script>
        // Load data when page opens
        document.addEventListener('DOMContentLoaded', function() {
            loadCustomerData();
        });

        function loadCustomerData() {
            const table = document.getElementById('userTable').getElementsByTagName('tbody')[0];
            table.innerHTML = ''; // Clear existing rows
            
            // Get customers from localStorage or use sample data
            let customers = JSON.parse(localStorage.getItem('customerRecords')) || [];
            
            if (customers.length === 0) {
                customers = [
                    {
                        userId: "#1001",
                        firstName: "John",
                        lastName: "Doe",
                        username: "john_doe92",
                        age: "32",
                        email: "john.doe@example.com",
                        role: "Admin",
                        phone: "923001234567",
                        address: "123 Main St",
                        signupDate: "2025-01-15"
                    },
                    {
                        userId: "#1002",
                        firstName: "Alice",
                        lastName: "Smith",
                        username: "asmith87",
                        age: "28",
                        email: "alice.smith@mail.com",
                        role: "Customer",
                        phone: "923004567891",
                        address: "456 Oak Ave",
                        signupDate: "2025-02-20"
                    }
                ];
            }
            
            // Add all customers to table
            customers.forEach(customer => {
                const newRow = table.insertRow();
                newRow.insertCell(0).innerText = customer.userId;
                newRow.insertCell(1).innerText = customer.firstName;
                newRow.insertCell(2).innerText = customer.lastName || "—";
                newRow.insertCell(3).innerText = customer.username;
                newRow.insertCell(4).innerText = customer.age;
                newRow.insertCell(5).innerText = customer.email;
                newRow.insertCell(6).innerText = customer.role;
                newRow.insertCell(7).innerText = customer.phone;
                newRow.insertCell(8).innerText = customer.address || "—";
                newRow.insertCell(9).innerText = customer.signupDate || "—";
                
                const actionCell = newRow.insertCell(10);
                actionCell.innerHTML = `
                    <button class="button" onclick="editRow(this)">Edit</button>
                    <button class="button" onclick="deleteRow(this)">Delete</button>
                `;
            });
            
            // Clear stored customers after loading
            localStorage.removeItem('customerRecords');
        }

        function deleteRow(btn) {
            if (confirm('Are you sure you want to delete this customer?')) {
                const row = btn.parentElement.parentElement;
                row.remove();
            }
        }

        function editRow(btn) {
            const row = btn.parentElement.parentElement;
            const cells = row.querySelectorAll('td');
            
            for (let i = 1; i < cells.length - 1; i++) {
                if (cells[i].innerText !== "—") {
                    const input = document.createElement('input');
                    input.value = cells[i].innerText;
                    cells[i].innerText = '';
                    cells[i].appendChild(input);
                }
            }
            
            btn.textContent = 'Save';
            btn.onclick = function() {
                for (let i = 1; i < cells.length - 1; i++) {
                    if (cells[i].querySelector('input')) {
                        cells[i].innerText = cells[i].querySelector('input').value;
                    }
                }
                btn.textContent = 'Edit';
                btn.onclick = () => editRow(btn);
            };
        }

        function addUser() {
            const table = document.getElementById('userTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            const newId = '#' + (1000 + table.rows.length + 1);
            const fields = [
                'First Name', 'Last Name', 'Username', 'Age', 
                'Email', 'Role', 'Phone No', 'Address', 'Signup Date (YYYY-MM-DD)'
            ];

            const cell0 = newRow.insertCell(0);
            cell0.innerText = newId;

            for (let i = 0; i < fields.length; i++) {
                const cell = newRow.insertCell(i + 1);
                const input = prompt(`Enter ${fields[i]}:`);
                cell.innerText = input || '—';
            }

            const actionCell = newRow.insertCell(fields.length + 1);
            actionCell.innerHTML = `
                <button class="button" onclick="editRow(this)">Edit</button>
                <button class="button" onclick="deleteRow(this)">Delete</button>
            `;
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
body{

background-image: url(main.png);
background-size:cover;

}
.button
{
 background-color: bisque;
 border-radius: 8px;
 width: 100px;
 height: 37px;
margin-bottom: 1%;
border-width: 0px;
transition-duration: 0.2s;


}
.button:hover{

background-color: aquamarine;
color: bisque;
width: 120px;
height: 45px;


}
h1{
 color: aqua;
 

}
h2{
    color: aqua;

}
.list{


 
line-height: 4px;
padding-top: 2px;
padding-bottom: 2px;


}
@keyframes changes_color{
    0% {
        color:aqua;
      
    }
    30%{

        color:aqua;
    }
    70%{

        color:rgb(255, 230, 0);
    }
  
    100% {
        color:rgb(255, 230, 0);
        
    }



}

@keyframes move{

    0% {
        
        transform: translateX(-100%)  ;
  
    }

}

.welcome{
    position: fixed;
   top: 4%;
   left: 2%;

   
    font-size: 43px; 
  
    animation: changes_color 2.2s infinite ,  move 2.2s forwards;



}
li{

color: bisque;

}
li:hover{

color: aqua;


}
footer{
    position:fixed;
top: 77%;
left: 7%;
width: 800px;

}
.Dashboard{

margin-top: 160px;

}
</style>
<body>
    <header>
        <h1  class= "welcome">WELCOME TO CRAVE CHICKEN RESTAURANT</h1>
    </header>
    <div class="Dashboard">
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
              <li><a href="admin_manage_customers.php"> <button class="button">Manage Customers</button></a></li>
<li><a href="admin_manage_orders.php"><button class="button">Manage Orders</button></a></li>
<li><a href="admin_manage_menu.php"><button class="button">Manage Menu</button> </a></li>
<li><a href="admin_manage_staff.php"><button class="button">Manage Staff</button> </a></li>
<li><a href="admin_manage_payments.php"><button class="button">Manage Payments</button> </a></li>
            </ul>
        </nav>
    </div>
   
    <section>
        <h2>Overview</h2>
        <!-- Here you can display recent orders, stats, etc. -->
    </section>

    <footer style="align-items: center ; ">
        <p style="color: bisque; padding-left: 38%; margin-bottom: -28px;">© 2025 Crave Kitchen</p><br>
        <p style="color: white;">At Crave Kitchen, we believe food is not just nourishment — it’s an experience to be celebrated.
            Our passion lies in crafting fresh, flavorful dishes that bring people together around the table.
            Using only the finest locally sourced ingredients, our chefs blend traditional techniques with innovative ideas to create meals that are both comforting and inspiring.
            Every plate we serve reflects our commitment to quality, creativity, and exceptional service.
            Whether you're gathering with family, meeting friends, or celebrating a special moment, we invite you to savor every bite and create lasting memories at Crave Kitchen.</p>
    </footer>
</body>
</html>

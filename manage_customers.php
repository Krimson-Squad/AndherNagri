<?php
    include "validate_admin.php";
    include "connect.php";
    include "header.php";
    include "user_navbar.php";
    include "admin_sidebar.php";
 
   include "session_timeout.php";

    if (isset($_POST['submit'])) {
        $back_button = TRUE;
        $search = $_POST['search'];
      
  $by = $_POST['by'];

     
   if ($by == "name") {
            $sql0 = "SELECT cust_id, first_name, last_name, account_no FROM customer
  WHERE first_name LIKE '%".$search."%' OR
 last_name LIKE '%".$search."%'
            OR CONCAT(first_name, ' ', last_name) LIKE '%".$search."%'";
        }
        
else {
            $sql0 = "SELECT cust_id, first_name, last_name, account_no FROM customer
            WHERE account_no LIKE '$search'";
 
       }
    }
    else {
        $back_button = FALSE;

        $sql0 =  'CALL `cust_details`()';  }

 
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
 <link rel="stylesheet" href="manage_customers_style.css">
</head>

<body>
    <div class="search-bar-wrapper">
      
  <div class="search-bar" id="the-search-bar">
            <div class="flex-item-search-bar" id="fi-search-bar">

          
      <form class="search_form" action="" method="post">
                    <div class="flex-item-search">
                       
 <input name="search" size="30" type="text" placeholder="Search Customers..." />
                    </div>

                    
<div class="flex-item-search-button">
                        <button type="submit" name="submit" id="search"></button>
                    </div>

           
         <div class="flex-item-by">
                        <label>By :</label>
                    </div>

                
    <div class="flex-item-search-by">
                        <select name="by">
                           
 <option value="name">Name</option>
                            <option value="acno">Ac/No</option>
                        </select>
                    </div>
 

               </form>

            </div>
        </div>
    </div>

    <div class="flex-container">
   
     <?php
            $result = $conn->query($sql0);

         
   if ($result->num_rows > 0) 
{
           
            $i = 0;
            while($row = $result->fetch_assoc()) {
                $i++; ?>

         
       <div class="flex-item">
                    <div class="flex-item-1">
                        <p id="id"><?php echo $i . "."; ?></p>
                    </div>
 
                   <div class="flex-item-2">
                        <p id="name"><?php echo $row["first_name"] . " " . $row["last_name"]; ?></p>
   
                     <p id="acno"><?php echo "Ac/No : " . $row["account_no"]; ?></p>
                    </div>
                    <div class="flex-item-1">
    
                    <div class="dropdown">
                           
   
                       <button onclick="dropdown_func(<?php echo $i ?>)" class="dropbtn"></button>
                        
  <div id="dropdown<?php echo $i ?>" class="dropdown-content">
                           
   
                         <a href="edit_customer.php?cust_id=<?php echo $row["cust_id"] ?>">View / Edit</a>
  
                          <a href="transactions.php?cust_id=<?php echo $row["cust_id"] ?>">Transactions</a>
      
                      <a href="delete_customer.php?cust_id=<?php echo $row["cust_id"] ?>"
                                
 onclick="return confirm('Are you sure?')">Delete</a>
                          </div>
                        </div>
                    </div>
                </div>

            <?php }
            } 
else {  ?>
                <p id="none"> No results found :(</p>
            <?php }
            if ($back_button) { ?>
                <div class="flex-container-bb">
 
                   <div class="back_button">
                        <a href="manage_customers.php" class="button">Go Back</a>
                    </div>
           
     </div>
            <?php }
            $conn->close(); ?>
    </div>

    <script>
   
 
    function dropdown_func(i) {
       
 
        var doc_id = "dropdown".concat(i.toString());

       
 var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;

       

        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
 
           if (openDropdown.classList.contains('show')) {
              openDropdown.classList.remove('show');
    
        }
        }

        document.getElementById(doc_id).classList.toggle("show");
        return false;
    }

   
 
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
 
       var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;

        for (i = 0; i < dropdowns.length; i++) {
      
    var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
   
       }
        }
      }
    }

    
    $(document).ready(function() {
        var curr_scroll;

        $(window).scroll(function () {
    
        curr_scroll = $(window).scrollTop();

            if ($(window).scrollTop() > 120) {
                $("#the-search-bar").addClass('search-bar-fixed');

             
 if ($(window).width() > 855) {
                  $("#fi-search-bar").addClass('fi-search-bar-fixed');
              }
            }

          
  if ($(window).scrollTop() < 121) {
                $("#the-search-bar").removeClass('search-bar-fixed');

              if ($(window).width() > 855) {
         
         $("#fi-search-bar").removeClass('fi-search-bar-fixed');
              }
            }
        });

        

        $(window).resize(function () {
          
  var class_name = $("#fi-search-bar").attr('class');

        
    if ((class_name == "flex-item-search-bar fi-search-bar-fixed") && ($(window).width() < 856)) {
         
       $("#fi-search-bar").removeClass('fi-search-bar-fixed');
            }

    
        if ((class_name == "flex-item-search-bar") && ($(window).width() > 855) && (curr_scroll > 120)) {
      
          $("#fi-search-bar").addClass('fi-search-bar-fixed');
            }
        });
    });

    </script>

</body>
</html>

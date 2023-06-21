<?php
include "connect.php";
include "header.php";
include "validate_customer.php";
include "customer_navbar.php";
include "customer_sidebar.php";
include "session_timeout.php";
$categoryId = $_GET['id'];
$NextCategoryId = $categoryId+1;
$PrevCategoryId = $categoryId-1;
$sql = "SELECT * FROM services WHERE `category_id` = '$categoryId'";

// Execute the SQL query
$result = $conn->query($sql);

// Fetch the services from the result set
$services = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $services[] = $row['name'];
  }
}

// Close the result set
$result->close();

// Close the database connection
$conn->close();

?>

<!DOCTYPE html>
<html>

<head>
  <title>Bank Services - Category <?php echo $categoryId; ?></title>
  <style>
    /* CSS styles */
    body {
      font-family: Arial, sans-serif;
      color: #fff !important;
       }

    .main {
      margin-left: 30%;
    }

  
    .card-container {
      display: grid;
      grid-template-columns: auto auto auto;
      /* background-color: #2196F3; */
      padding: 10px;
    }

    .card {
      /* margin-left: 30%; */

      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      transition: 0.3s;
      border: 1px solid rgba(0, 0, 0, 0.8);
      padding: 20px;
      font-size: 30px;
      text-align: center;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    img {
      border-radius: 5px 5px 0 0;
    }

    .container {
      text-align: center;
    }
  </style>
</head>

<body style="color: black">
  <div class="main">
    <h1>Bank Services - Category <?php echo $categoryId; ?></h1>
    <button onclick="window.location.href='?id=<?php echo $NextCategoryId?>'">Next ></button><button onclick="window.location.href='?id=<?php echo $PrevCategoryId?>'">< Previous</button>
    <?php if ($services) { ?>
      <br />
      <strong>Service Name</strong>
      <div class="card-container">
        <?php foreach ($services as $service) { ?>
          <div class="card">
            <div class="container"><?php echo $service; ?></div>
          </div>
        <?php } ?>
      </div>
    <?php } else { ?>
      <p>No services found for the selected category.</p>
    <?php } ?>
  </div>
</body>

</html>
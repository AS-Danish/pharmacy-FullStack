<?php
    session_start();
    if(!isset($_SESSION['AdminLoginId'])){
        header("location: adminLogin.php");
    }
    require("connection.php");

    if(isset($_POST['addBtn'])){
        $medicineName = $_POST['medicineName'];
        $medicine_Price = $_POST['price'];
        
        $medicine_Image = $_FILES['med_image']["name"];
        $medicine_Quantity = $_POST['quantity'];
        $medicine_Category = $_POST['category'];

        $addMedQuery = "INSERT INTO `medicines`(`med_name`, `med_img`, `med_price`, `med_qty`, `med_category`) VALUES (?, ?, ?, ?, ?);";
        $stmt = mysqli_prepare($conn, $addMedQuery);
            mysqli_stmt_bind_param($stmt, "ssiis", $medicineName, $medicine_Image, $medicine_Price, $medicine_Quantity, $medicine_Category);
            if(mysqli_stmt_execute($stmt)) {
                var_dump($_FILES);
            }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body{
            margin:0;
            
        }
        #add{
            display: block;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-left: 175px;
        }
        div.header{
            color:#f0f0f0;
            font-family: poppins;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 0 60px;
            background-color: #1c1c1e;
        }
        div.header button{
            background-color: #f0f0f0;
            font-size: 16px;
            font-weight: 550;
            padding: 8px 12px;
            border: 2px solid black;
            border-radius: 5px;
        }
        .list-group {
            list-style: none;
        }
        .form-container {
            text-align: center;
            max-width: 800px;  
            padding: 100px;
            border: 1px solid #ccc;
            
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-container button {
            background-color: black;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: white;
            color: black;
            border: 1px solid black;
            
        }       
        <!-- HTML !-->

.button-28 {
  appearance: none;
  background-color: transparent;
  border: 2px solid #1A1A1A;
  border-radius: 15px;
  box-sizing: border-box;
  color: #3B3B3B;
  cursor: pointer;
  display: inline-block;
  font-family: Roobert,-apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
  font-size: 16px;
  font-weight: 600;
  line-height: normal;
  margin: 0;
  min-height: 60px;
  min-width: 0;
  outline: none;
  padding: 16px 24px;
  text-align: center;
  text-decoration: none;
  transition: all 300ms cubic-bezier(.23, 1, 0.32, 1);
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  width: 100%;
  will-change: transform;
}

.button-28:disabled {
  pointer-events: none;
}

.button-28:hover {
  color: #fff;
  background-color: #1A1A1A;
  box-shadow: rgba(0, 0, 0, 0.25) 0 8px 15px;
  transform: translateY(-2px);
}

.button-28:active {
  box-shadow: none;
  transform: translateY(0);
}
    </style>
</head>
<body>
    <div class="header">
        <h1>ADMIN PANEL - <?php echo $_SESSION['AdminLoginId'] ?></h1>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method = "POST">
            <button type="submit" name = "Logout">LOG OUT</button>
        </form>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#allOrdersList">All orders</a></li>
        <li><a data-toggle="tab" href="#catalog">Catalog</a></li>
        <li><a data-toggle="tab" href="#add">Add Medicines</a></li>
    </ul>

    <div class="tab-content tab-pane">
        <div id="allOrdersList" class="tab-pane fade in active">
            <h3>All orders</h3>
            <div class="container mt-5">
            <div class="row">
                <div class="col-lg-12">
                <table class="table text-center table-dark">
                    <thead>
                        <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Phone No</th>
                        <th scope="col">Address</th>
                        <th scope="col">Pay Mode</th>
                        <th scope="col">Orders</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT * FROM `orders`;";
                            $user_result = mysqli_query($conn, $query);
                            while($user_fetch = mysqli_fetch_assoc($user_result)){
                                echo "
                                <tr>
                                    <td>$user_fetch[order_id]</td>
                                    <td>$user_fetch[Full_Name]</td>
                                    <td>$user_fetch[Phone_No]</td>
                                    <td>$user_fetch[Address]</td>
                                    <td>$user_fetch[Pay_Mode]</td>
                                    <td>
                                        <table class='table text-center table-dark'>
                                            <thead>
                                                <tr>
                                                <th scope='col'>Item Name</th>
                                                <th scope='col'>Price</th>
                                                <th scope='col'>Qauntity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            ";

                                    $order_query = "SELECT * FROM `user_orders` WHERE `order_id` = '$user_fetch[order_id]'";
                                    $order_result = mysqli_query($conn, $order_query);
                                    while($order_fetch = mysqli_fetch_assoc($order_result)){
                                        echo"
                                            <tr>
                                                <td>$order_fetch[med_name]</td>
                                                <td>$order_fetch[Price]</td>
                                                <td>$order_fetch[Quantity]</td>
                                            </tr>
                                        ";
                                    }
                                    echo"
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                ";
                            }
                        ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="catalog" class="tab-pane fade">
        <h3>Catalog</h3>
        <div class="container py-5">
        <div class="row" style="margin: auto;">
            <div class="col-lg-8 mx-auto">
                <!-- List group-->
                <ul class="list-group shadow">
                    <!-- list group item-->
                    <?php
                        $m_query = "SELECT * FROM medicines ORDER BY med_price ASC;";
                        $medicines_result = mysqli_query($conn, $m_query);
                        while($m_fetch = mysqli_fetch_assoc($medicines_result   )) {
                        echo "
                    <li class='list-group-item'>
                        <div class='media align-items-lg-center flex-row flex-lg-row p-3'>
                            <div class='media-body order-2 order-lg-1'>
                                <h5 class='mt-0 font-weight-bold mb-2'>$m_fetch[med_name]</h5>
                                <div class='d-flex align-items-center justify-content-between mt-1'>
                                    <h6 class='font-weight-bold my-2'>$m_fetch[med_price]</h6>
                                    <ul class='list-inline small'>
                                        <li class='list-inline-item m-0'><i class='fa fa-star text-success'></i></li>
                                        <li class='list-inline-item m-0'><i class='fa fa-star text-success'></i></li>
                                        <li class='list-inline-item m-0'><i class='fa fa-star text-success'></i></li>
                                        <li class='list-inline-item m-0'><i class='fa fa-star text-success'></i></li>
                                        <li class='list-inline-item m-0'><i class='fa fa-star-o text-gray'></i></li>
                                    </ul>
                                </div>
                            </div><img src=$m_fetch[med_img] alt='Generic placeholder image' width='200' class='ml-lg-5 order-1 order-lg-2'>
                            
                            <form method = 'post'>
                                <input type='hidden' name='med_id' value='$m_fetch[med_id]'>
                                <button type='submit' name = 'delBtn' class = 'btn btn-danger'>DELETE</button>
                            </form>
                        </div> <!-- End -->
                    </li>
                    ";
                    }
                    ?>
                    
                </ul> <!-- End -->
        </div>
    </div>
</div>
    </div>
    <div id="add" class="tab-pane fade">
        <div class="form-container">
            <form method="post" action='' enctype="multipart/form-data">
                <label for="">Medicine Name: </label>    
                <input type="text" id="medicineName" name="medicineName" placeholder="Medicine Name">
                <br>
                <label for="">Price: </label>
                <input type="number" id="price" name="price" placeholder="Price">
                <br>
                <label for="">Quantity: </label>
                <input type="number" id="qty" name="quantity" placeholder="Quantity">
                <br>
                <label for="">Category: </label>
                <input type="text" id="cat" name="category" placeholder="category">
                <br>
                <label for="">Upload Image:</label>
                <input type="file" id="image" name="med_image" accept="image/*" style="margin-bottom: 15px;">
                <br>
                
                <button class="button-28" name="addBtn" role="button" type='submit'>Submit</button>
            </form>
        </div>
    </div>
    </div>
    <?php
        if(isset($_POST['delBtn'])){
            $medName = $_POST['med_id'];
            $Query="DELETE FROM `medicines` WHERE `med_id` = ?";
            $stmt = mysqli_prepare($conn, $Query);
            mysqli_stmt_bind_param($stmt, "i", $medName);
            if(mysqli_stmt_execute($stmt)) {
                echo "<script> alert('Item Successfully Deleted'); </script>";
                
            } else {
                echo "<script> alert('Error Deleting the Record'); </script>";
            }
    
            // Close the statement
            mysqli_stmt_close($stmt);
        }
    ?>

<?php
    if(isset($_POST['Logout'])){
        session_destroy();
        header("location: adminLogin.php");
    }
?>

</body>
</html>
<?php
    require_once "connection.php";
    session_start();

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['purchase'])){
            $query1 = "INSERT INTO `orders`(`Full_Name`, `Phone_No`, `Address`, `Pay_Mode`) VALUES ('$_POST[fullname]','$_POST[phone_no]','$_POST[address]','$_POST[pay_mode]')";
            if(mysqli_query($conn, $query1)){
                $orderID = mysqli_insert_id($conn);
                $query2 = "INSERT INTO `user_orders`(`order_id`, `med_name`, `Price`, `Quantity`) VALUES (?,?,?,?)";
                $stmt = mysqli_prepare($conn, $query2);
                if($stmt){
                    mysqli_stmt_bind_param($stmt, "isii", $orderID, $Item_Name, $Price, $Quantity);
                    foreach($_SESSION['cart'] as $key => $values){
                        $Item_Name = $values['Item_Name'];
                        $Price = $values['Price'];
                        $Quantity = $values['Quantity'];
                        mysqli_stmt_execute($stmt);
                    }
                    unset($_SESSION['cart']);
                    echo "<script>
                        alert('Order Placed');
                        window.location.href = 'index.php';
                        </script>";
                }
                else{
                    echo "ERROR";
                }
            }
            else{
                echo "ERROR";
            }
        }
    }
?>
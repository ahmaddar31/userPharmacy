<?php
session_start();
include('./db_config/connect.php');
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $p_id = $_POST['pharmacy_id'];
    for ($i = 0; $i < count($_SESSION['all_info']); $i++) {
        if (isset($_SESSION['all_info'][$i])) {
            $med_ref_id = $_SESSION['all_info'][0]['md_id'];
        }
    }

    $totalPrice = $quantity * $price;
    $user_id = $_SESSION['userlog_info']['userID'];
    


    $query2 = "INSERT INTO reservation(userID, qtyReserved, total_price,med_ref_id,p_id) 
    VALUES('$user_id','$quantity','$totalPrice','$med_ref_id','$p_id')";
    mysqli_query($con, $query2);
    header("Location:index.php");



?>
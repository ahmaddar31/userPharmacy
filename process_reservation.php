<?php
session_start();
include('./db_config/connect.php');
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $p_id = $_POST['pharmacy_id'];
    $selectedValue = $_POST["yesNo"];
    for ($i = 0; $i < count($_SESSION['all_info']); $i++) {
        if (isset($_SESSION['all_info'][$i])) {
            $med_ref_id = $_SESSION['all_info'][0]['md_id'];
        }
    }

    $totalPrice = $quantity * $price;
    $user_id = $_SESSION['userlog_info']['userID'];
    
    


    $query2 = "INSERT INTO reservation(userID, qtyReserved, total_price,med_ref_id,p_id,delivery) 
    VALUES('$user_id','$quantity','$totalPrice','$med_ref_id','$p_id','$selectedValue')";
    mysqli_query($con, $query2);

    $query3 = "SELECT r_id FROM reservation WHERE med_ref_id='$med_ref_id' AND p_id='$p_id'";
    $result=mysqli_query($con, $query3);
    if(mysqli_num_rows($result) > 0){
        $row= mysqli_fetch_assoc($result);
        $_SESSION['reservation_id']= $row;
        header('location:index.php?flag=3&reservation_id=' . $row['r_id']);

    }
    else{
        header("location:index.php?flag=4");
    }



?>
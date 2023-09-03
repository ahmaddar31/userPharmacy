<?php
session_start();
include('./db_config/connect.php');

if (isset($_SESSION['userlog_info'])) {
    $md_Name = $_POST['md_Name'];


    $query = "SELECT * FROM admin 
        INNER JOIN pharma ON admin.id=pharma.admin_id 
        INNER JOIN pharmamed ON pharma.pharma_id=pharmamed.ph_id
        INNER JOIN medication ON pharmamed.med_id=medication.md_id  
        WHERE medication.medName='$md_Name'
        ORDER BY pharma.phName";

    $result = mysqli_query($con, $query);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($data, $row);
        }
        $_SESSION['all_info'] = $data;
    }


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./bootstrap-4.6.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="./bootstrap-4.6.2-dist/css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="Style1.css">
    </head>

    <body>
        <center>
            <header class="head">
                <div><a href="index.php">Home</a></div>
            </header>

            <div class="container" style="margin: 3px 3%">
                <div class="row">
                    <?php
                    $cardCount = 0; // Counter to keep track of the number of cards
                    for ($i = 0; $i < count($_SESSION['all_info']); $i++) {
                        if (isset($_SESSION['all_info'][$i])) {
                            $medName = $_SESSION['all_info'][$i]['medName'];
                            $quantity = $_SESSION['all_info'][$i]['quantity'];
                            $price = $_SESSION['all_info'][$i]['price'];
                            $ph_Name = $_SESSION['all_info'][$i]['phName'];
                            $Address = $_SESSION['all_info'][$i]['address'];
                            $ph_id = $_SESSION['all_info'][$i]['ph_id'];
                            $md_id = $_SESSION['all_info'][$i]['md_id'];

                            // Open a row div for every third card
                            if ($cardCount % 3 == 0) {
                                echo '<div class="w-100"></div>'; // Clear the previous row and start a new row
                            }
                    ?>
                            <div class="col-md-4">
                                <div class="card" style="box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, 0.3);">
                                    <div class="card-header">
                                        Medication Name: <?php echo $medName; ?>
                                    </div>
                                    <form method="POST" action="process_reservation.php">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $ph_Name; ?></h5>
                                            <input type="hidden" name="pharmacy_id" id="hiddenId" value="<?php echo $ph_id; ?>">
                                            <p class="card-text">Address: <?php echo $Address; ?></p>
                                            <p class="card-text">Quantity: <?php echo $quantity; ?></p>
                                            <p class="card-text">Price: <?php echo '$', $price; ?></p>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn badge badge-pill btnr" onclick="openWindow(<?php echo $md_id; ?>)">reservation</button>

                                        </div>
                                        <!-- Hidden window -->
                                        <div class="reservationWindow" id="reservationWindow-<?php $price ?>" style="display: none;">


                                            <label for="quantity">Enter a quantity between 1 and 3:</label>
                                            <input type="number" id="quantity" name="quantity" min="1" max="3" step="1" oninput="validateInput(this)">
                                            <p id="errorText" style="color: red;"></p>
                                            <p class="price" id="price-<?php $cardCount ?>" name="price" style="display: none;"><?php echo $price; ?></p>
                                            <!-- Hidden input field to pass the price value to the process_reservation.php -->
                                            <input type="hidden" name="price" id="hiddenPrice" value="<?php echo $price; ?>">
                                            <button type="submit">Reserve</button>
                                    </form>
                                </div>
                            </div>
                </div>
        <?php
                            $cardCount++;
                        }
                    }
        ?>
            </div>
            </div>

            <br>
            <a href="./index.php">
                <button type="button" class="btn badge badge-pill">Go To Home</button>
            </a>
            <script>
                function openWindow(md_id) {
                    var card = event.target.closest('.card');
                    var reservationWindow = card.querySelector('.reservationWindow');
                    var price = parseFloat(card.querySelector('.price').textContent);
                    var quantityField = card.querySelector('.qty');
                    var quantityValue = card.querySelector('.quantityValue');
                    var priceField = card.querySelector('.price');
                    var hiddenPriceField = card.querySelector('.hiddenPrice');
                    reservationWindow.style.display = 'block';
                }

                function validateInput(input) {
                    var value = input.value;

                    // Check if the entered value is within the specified range
                    if (value < 1 || value > 3) {
                        document.getElementById("errorText").textContent = "Please enter a number between 1 and 3.";
                        input.setCustomValidity("Invalid input"); // Set a custom validation message
                    } else {
                        document.getElementById("errorText").textContent = "";
                        input.setCustomValidity(""); // Clear the custom validation message
                    }
                }
            </script>
    </body>

    </html>
<?php
} else {
    header("location:userlogin.php?flag=2");
}
?>
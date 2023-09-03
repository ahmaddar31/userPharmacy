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
            <div><a href="userLogin.php">Login</a></div>
            <div><a href="userRegistration.php">Signup</a></div>
        </header>
        <?php
            if(isset($_GET['flag'])){
                if($_GET['flag']==1){
                    echo "<b>email or password is wrong!!</b>";
                }
                elseif($_GET['flag']==2){
                    echo "<script>alert('login before please')</script>";
                }
            }
        ?>
        <div class="card" style="width: 25rem;">
            <div class="card-header">
                 LOGIN
            </div>
            <form method="post" action="./userLogAction.php">
                <div class="form-group">
                    <label>email: </label>
                    <input type="email" class="form-control" name="email" placeholder="email" required>
                </div>
                <div class="form-group">
                    <label>password: </label>
                    <input type="password" class="form-control" name="password" placeholder="password" required>
                </div>
                <button type="submit" class="btn " name="submit">Submit</button>
            </form>
        </div>
</body>

</html>
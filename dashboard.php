<?php
include "koneksi.php";
session_start();
if (!isset($_SESSION['IS_LOGIN'])) {
    header("Location: index.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <title>Login Attempts</title>
</head>
<br />

<body>
    <div class="container">
        <div class="box">
            <div class="row contentForm">
                <div class="col-sa-12 col-md-6 col-lg-6">
                    <img src="SalyNoted.png" width="300" height="350" alt="" class="img-fluid">
                </div>
                <div class="col-sa-12 col-md-6 col-lg-6">
                    <h4 class="text-center"> LOGIN SEBAGAI :</h4>
                    <br />
                    <h4 class="text-center">

                        <?php
                        $id = $_GET['id'];
                        $query = "SELECT * from user where id = '$id'";
                        $query_exec = mysqli_query($con, $query);
                        while ($row = mysqli_fetch_array($query_exec)) :
                        ?>
                            <?php echo "Selamat Datang, ", $row['nama'], " :)";
                            ?>
                            </br>
                            <?php echo "Anda adalah ", $row['role'], "."; ?>
                        <?php endwhile; ?>

                        <a href="logout.php">Logout</a>
                    </h4>
                    <br />
                </div>
            </div>
        </div>
    </div>
</body>

</html>
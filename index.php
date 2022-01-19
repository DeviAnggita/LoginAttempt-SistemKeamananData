<?php $pagename = "Login Attempt"; ?>

<?php
session_start();
include_once('koneksi.php');
$msg = '';
if (isset($_POST['submit'])) {
    $time = 0;
    $ip_address = getIpAddr();
    //Mendapatkan jumlah total hit berdasarkan IP
    $query = mysqli_query($con, "select count(*) as total_count from loginlogs where TryTime > $time and IpAddress='$ip_address'");
    $check_login_row = mysqli_fetch_assoc($query);
    $total_count = $check_login_row['total_count'];
    //Memeriksa apakah percobaan sudah 5 kali
    if ($total_count == 5) {
        $msg = "Akun anda terblokir";
    } else {
        //Mengambil Nilai Post
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        //Proses Login
        $res = mysqli_query($con, "select * from user where username='$username' and  password='$password'");
        if (mysqli_num_rows($res)) {
            $rows = mysqli_fetch_assoc($res);
            $_SESSION['IS_LOGIN'] = 'yes';
            mysqli_query($con, "delete from loginlogs where IpAddress='$ip_address'");
            mysqli_query($con, "UPDATE `user` SET `ket`='unlock' WHERE username='$username'");

            header("Location: dashboard.php?id=$rows[id]");
        } else {
            $total_count++;
            $rem_attm = 5 - $total_count;
            if ($rem_attm == 0) {
                $username = $_POST['username'];
                mysqli_query($con, "UPDATE `user` SET `ket`='lock' WHERE username='$username'");
                $msg = "Akun anda terblokir";
            } else {
                $msg = "Password yang anda masukan salah.<br/> Tersisa $rem_attm kesempatan.";
            }
            $try_time = time();
            mysqli_query($con, "insert into loginlogs(IpAddress,TryTime) values('$ip_address','$try_time')");
        }
    }
}

//Mengambil IP Address
function getIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ipAddr = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipAddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ipAddr = $_SERVER['REMOTE_ADDR'];
    }
    return $ipAddr;
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
    <div id="login">
        <div class="container">
            <div class="box">
                <div class="row contentForm">
                    <div class="col-sa-12 col-md-6 col-lg-6">
                        <img src="SalyNoted.png" width="300" height="350" alt="" class="img-fluid">
                    </div>
                    <div class="col-sa-12 col-md-6 col-lg-6">
                        <h4 class="text-center">
                            <font color='rgba(204, 180, 255, 0.5)'>LOGIN</font>
                        </h4>
                        <br />

                        <body>
                            <div id="login">
                                <div class="container">
                                    <div id="login-row" class="row justify-content-center align-items-center">
                                        <div id="login-column" class="col-md-6">
                                            <div id="login-box" class="col-md-12">
                                                <form id="login-form" class="form" method="post">
                                                    <div class="mb-3">
                                                        <div class="form-group">
                                                            <label for="username" class="text-info">
                                                                <h4>
                                                                    <font color='rgba(204, 180, 255, 0.5)'>Username</font>
                                                                </h4>
                                                            </label><br>
                                                            <input type="text" name="username" id="username" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-group">
                                                            <label for="password" class="text-info">
                                                                <h4>
                                                                    <font color='rgba(204, 180, 255, 0.5)'>Password</font>
                                                                </h4>
                                                            </label><br>
                                                            <input type="password" name="password" id="password" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="submit" name="submit" class="btn btn-info btn-md" value="Submit">
                                                    </div>
                                                    <div id="result"><?php echo $msg ?></div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </body>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
$db_host = 'localhost';
$db_name = 'keamananlogin';
$db_username = 'root';
$db_password = '';
$con = mysqli_connect($db_host, $db_username, $db_password,
$db_name);
?>

<!-- Check connection -->
<?php if(!$con): ?>
<div class="alert alert-danger m-5" role="alert">
    <?php die("Connection failed: " . mysqli_connect_error()); ?>
</div>
<?php endif; ?>
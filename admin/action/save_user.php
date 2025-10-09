<?php
$cn = new mysqli("localhost", "root", "", "doorstap");
 $cn ->set_charset("utf8");
if ($cn->connect_error) {
    die("Connection failed: " . $cn->connect_error);
}

$id         = (isset($_POST['txt-id']) && !empty($_POST['txt-id'])) ? $_POST['txt-id'] : null;

$username   = (isset($_POST['username']) && !empty($_POST['username'])) ? $_POST['username'] : '';

$email      = trim((isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : '');
$email      = $cn->real_escape_string($email);

$pass       = trim(isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : '';
$pass       = $cn->real_escape_string($pass);
$pass       = md5($pass);
$pass       = password_hash($pass, PASSWORD_DEFAULT );

$uType      = (isset($_POST['user_type']) && !empty($_POST['user_type'])) ? $_POST['user_type'] : '';
$status     = (isset($_POST['status']) && !empty($_POST['status'])) ? $_POST['status'] : '';
$ip         = '000';

if($id >0){
    // Update existing user
    $sql = "UPDATE tbl_user 
            SET u_name = '$username', 
                u_email = '$email', 
                u_pass = '$pass', 
                u_type = '$uType', 
                u_ip = '$ip', 
                code = '123',
                status = '$status' 
            WHERE id = $id";
} else {
    $sql        = "INSERT INTO tbl_user  
                    VALUES
                    (null, 
                    '$username', 
                    '$email', 
                    '$pass', 
                    '$uType',
                    '$ip',
                    '123', 
                    '$status')";
}
$res        = $cn->query($sql);

if ($res === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $cn->error;
}

?>
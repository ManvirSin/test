<?php
$username = $_POST['username'];
$password = $_POST['password'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone = $_POST['phone'];

if (!empty($username) || !empty($password) || !empty($gender) || !empty($email) || !empty($phone)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbpassword = "";
    $dbname = "register";

    //create connections
    $conn = new mysqli($host, $dbUsername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else { 
        $SELECT = "SELECT email From register Where email = ? Limit 1";
        $INSERT = "INSERT Into register(username, password, gender, email, phone) values(?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum==0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssssii", $Username, $password, $gender, $email, $phone);
            $stmt->execute();
            echo "New record inserted successfully";
        }else{
            echo "Somebody has already registered with this email";
        }
        $stmt->close();
        $conn->close();
        } 
    }
     else {
    echo "You have not filled in all of the fields. All of the fields are required to be filled in.";
    die();
}
?>
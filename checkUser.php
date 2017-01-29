<html>
<head><title>Message Board</title></head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

try {
    
    
// / $dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
   $servername = "localhost";
$username = "root";
$password = "";
$dbname = "cheapbooks"; 
$conn = new mysqli($servername, $username, $password, $dbname);
  
  $username = $_POST['username'];
  $password = $_POST['password']; 

$sql = "select * from Customer where username= '".$username."' and password= '".$password."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo '<div class="page-header"><h3> Successfully loged in</h3></div>';
    while($row = $result->fetch_assoc()) {
        print "<pre>";
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = $username;
        print_r('succesfully logged in.');
    }
  print "</pre>";
} else {
    
    echo "error";
}
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>
</body>
</html>

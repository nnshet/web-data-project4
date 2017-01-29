        <?php

 if(isset($_POST['action']) && $_POST["action"] == "register"){
     try {
    
            error_reporting(E_ALL);
ini_set('display_errors','On');
// / $dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
   $servername = "localhost";
$username = "root";
$password = "";
$dbname = "cheapbooks"; 
$conn = new mysqli($servername, $username, $password, $dbname);
  
  $username = $_POST['username'];
  $password = MD5($_POST['password']); 
  $address = $_POST['address']; 
  $number = $_POST['number']; 
  $email = $_POST['email']; 
//Customer ( username, address, email, phone, password )    
        
$sql = "insert into customer(username,address,email,phone,password) values('$username','$$address','$email','$number','$password')";
//$result = $conn->query($sql);

if ($conn->query($sql)) {
    // output data of each row
    //echo '<div class="page-header"><h3> Successfully loged in</h3></div>';
    $sql1 = "insert into shoppingbasket(basketID,username) values('".uniqid()."','$username')";
    if($conn->query($sql1) ){
        echo "User is succesfullly registered.";
    }
} else {
    
    echo "There was an error";
}
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
}

?>  

<html>
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>COMP5335-Assign#4 </title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
      <br/>
    <div class="container">
       
        <?php


        session_start();
    if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
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
$sql = "select * from customer where username= '".$username."' and password= '".$password."'";
$result = $conn->query($sql);
//error

if ($result->num_rows > 0) {
    // output data of each row
    //echo '<div class="page-header"><h3> Successfully loged in</h3></div>';
    
    while($row = $result->fetch_assoc()) {
        
        
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = $username;
        $getBasketId = "select * from shoppingbasket where username = '$username'";
        
        $queryResult = ($conn->query($getBasketId));
        while($basketID = $queryResult->fetch_assoc()){
        
           $_SESSION["basketID"] = $basketID["basketID"];
            
        }
        $basketID = $_SESSION["basketID"];
        //"select * from book where ISBN IN (select ISBN from author JOIN writtenby ON author.ssn= writtenby.ssn where name LIKE   '%$searchString%')"
        $getBasketdetails = "select * from book JOIN contains ON book.ISBN=contains.ISBN where contains.ISBN IN (select ISBN from contains JOIN shoppingbasket ON contains.basketID = shoppingbasket.basketID where shoppingbasket.basketID = '$basketID') and contains.basketID = '$basketID'";
        $resultOfCart = ($conn->query($getBasketdetails));
        
        $_SESSION["totalBasketItems"] =  $resultOfCart->num_rows;
        
        $_SESSION['cartItems'] = array();
        if($resultOfCart->num_rows > 0) {
            while($basketResult = $resultOfCart->fetch_assoc()) {
                
                $_SESSION['cartItems'][]= $basketResult;
                
            }
        }
        
        
        
        //echo var_dump($_SESSION['cartItems']);
        
        
        header("Location:books.php");
       // print_r('succesfully logged in.');
    }
} else {
    
    echo "<div class='alert alert-danger'>
  <strong>Error!</strong> Please try with valid credentials.
</div>";
}
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
}
?>
<div class="jumbotron">
        
            <h3>Cheapbooks </h3>
        
   
    <form class="form-signin" method="POST" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="username" class="sr-only">User Name</label>
        <input type="text" name="username" class="form-control" placeholder="User name" id="username" required="" autofocus="">
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required=""><br/>
        <button type="submit" name="login" class="btn btn-primary btn-block">Login</button><br/>
        <p>New users must register <a href="register.php" class="btn btn-success">here</a></p>
        
    </form>
</div>

<!--
        
        <form  >
              <div class="form-group" method="POST" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <label for="exampleInputEmail1">User name</label>
                <input type="text" class="form-control" name="username" id="exampleInputEmail1" placeholder="username">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
              </div>
              
              <button type="submit" name="login" class="btn btn-default">Submit</button>
        </form>
-->
    </div>
</body>
</html>
<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cheapbooks"; 
$sql = "";             
$conn = new mysqli($servername, $username, $password, $dbname);

    if(isset($_POST['id']) && isset($_POST['searchString'])) {

        $id = $_POST['id'];
        $searchString = $_POST['searchString'];
                    
        if($id === "searchByAuthor") {
            
            if($searchString == "") {
                $sql = "select * from book";
            } else {

            $sql = "select * from book where ISBN IN (select ISBN from author JOIN writtenby ON author.ssn= writtenby.ssn where name LIKE   '%$searchString%')";     
            }
                        
        } else {
                  
            if($searchString == "") {
                $sql = "select * from book";
            } else {

            $sql = "select * from book where title LIKE '%$searchString%'";
            }
        }
                    
       
        $result = $conn->query($sql); 
        $count = $result->num_rows;
        
        if ($result->num_rows > 0) {

            // output data of each row
            while($row = $result->fetch_assoc()) {
                
                $isbn = $row['ISBN'];
                $sqlCheckStock = "select SUM(number) as sum from stocks where ISBN='$isbn'";
                
                $resultCheckStock = $conn->query($sqlCheckStock);
                $resultOFStocks = $resultCheckStock->fetch_assoc();
              if($resultOFStocks['sum']>0) {
                  
                    echo '<div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a href="#">
                                <img src="images/books/'.$row["ISBN"].'.jpg" class="img-thumbnail" />   
                            </a> 

                            <div class="caption text-center">

                                <h6><a href="#" >'.$row['title'].', '.$row['year'].'</a></h6>
                                <h5> Items in stock: '.$resultOFStocks['sum'].'</h5>
                                <h5> ISBN: '.$row["ISBN"].'</h5>
                                <button class="btn btn-primary btn-xs addToCart" data-ISBN="'.$row["ISBN"].'" data-totalItems= '.$resultOFStocks['sum'].'"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Add to cart</button></span>
                                <label for="movie"></label><input style="width:60px;" id="number_'.$row["ISBN"].'" type="number" value="1" min="1" max="'.$resultOFStocks['sum'].'"/>
                         </div>
                    </div>
                    </div>';
                } else {
                    $count = $count - 1;
                }
              
                
            }
              if($count == 0) {
                    echo "<br/><div class='alert alert-danger'>The books searched for are not in stock</div>"; 
                }

        } else {
            
            echo "<br/><div class='alert alert-danger'>The books searched for are not in stock</div>"; 
        } 
    }
    else if(isset($_POST['action']) && $_POST['action'] === "addToCart"){

           // $action = $_POST['action'];
        $isbn = $_POST['isbn'];
        $number = $_POST['number'];
        $total_stock = $_POST['totalStock'];
        addToCart($isbn,$number,$total_stock,$conn);
        
    } else if(isset($_POST['action']) && $_POST['action'] === "buyBooks") {
            
        buyBooks($conn);
        
        
    }

    function addToCart($isbn,$number,$total_stock,$conn) {
            
        $basketID = $_SESSION["basketID"];
//        
//        $sql = "INSERT INTO contains (ISBN, basketID, number) 
//VALUES ('$isbn', '$basketID','$number')
//ON DUPLICATE KEY UPDATE
//ISBN='$isbn', basketID='$basketID', number= number + '$number'";
//        $resultSql = $conn->query($sql);
//        
//        if($resultSql) {
//            
//            echo "Added to cart succeffully";
//        } else {
//            
//            echo "error";
//        }
        
        $sqlCheckIfExists = "select * from contains where ISBN = '$isbn' and basketID = '$basketID'";
        
        
        $resultSql = $conn->query($sqlCheckIfExists);
        if ($resultSql->num_rows > 0) {

            // output data of each row
            while($row = $resultSql->fetch_assoc()) {
                if($number < ( $total_stock - $row['number'])){
                    $updateQuery = "update contains set number = number + '$number' where ISBN = '$isbn' and basketID = '$basketID'";
                    if($conn->query($updateQuery)) {

                        echo "Added to cart Succesfully";
                         $getBasketdetails = "select * from book JOIN contains ON book.ISBN=contains.ISBN where contains.ISBN IN (select ISBN from contains JOIN shoppingbasket ON contains.basketID = shoppingbasket.basketID where shoppingbasket.basketID = '$basketID') and contains.basketID = '$basketID'";
        $resultOfCart = ($conn->query($getBasketdetails));
        
        $_SESSION["totalBasketItems"] =  $resultOfCart->num_rows;
        
        $_SESSION['cartItems'] = array();
        if($resultOfCart->num_rows > 0) {
            while($basketResult = $resultOfCart->fetch_assoc()) {
                
                $_SESSION['cartItems'][]= $basketResult;
                
            }
        }
                    } else {

                        echo "There was an issue";
                      }
                } else if($number > ( $total_stock - $row['number']) && $total_stock - $row['number'] != 0){
                    
                    $number = $total_stock - $row['number'];
                     $updateQuery = "update contains set number = number + '$number' where ISBN = '$isbn' and basketID = '$basketID'";
                    if($conn->query($updateQuery)) {

                        echo "Added to cart Succesfully";
                         $getBasketdetails = "select * from book JOIN contains ON book.ISBN=contains.ISBN where contains.ISBN IN (select ISBN from contains JOIN shoppingbasket ON contains.basketID = shoppingbasket.basketID where shoppingbasket.basketID = '$basketID') and contains.basketID = '$basketID'";
                        $resultOfCart = ($conn->query($getBasketdetails));

                        $_SESSION["totalBasketItems"] =  $resultOfCart->num_rows;

                        $_SESSION['cartItems'] = array();
                        if($resultOfCart->num_rows > 0) {
                            while($basketResult = $resultOfCart->fetch_assoc()) {

                                $_SESSION['cartItems'][]= $basketResult;

                            }
                        }
                    } else {

                        echo "There was an issue in adding item to cart";
                    }
                    
                } else {
                    
                    echo "Cart already contains the total items in the stock. Cannot add more item.Select the items in stock.";
                }
            }
        } else {
            
            $sql= "insert into contains values('$isbn','$basketID','$number')";
            $result = $conn->query($sql);

            if ($result) {

                echo "Added to cart Successfully.";
                $_SESSION['cartItems'] = array();
                $getBasketdetails = "select * from book JOIN contains ON book.ISBN=contains.ISBN where contains.ISBN IN (select ISBN from contains JOIN shoppingbasket ON contains.basketID = shoppingbasket.basketID where shoppingbasket.basketID = '$basketID') and contains.basketID = '$basketID'";
                $resultOfCart = ($conn->query($getBasketdetails));
                $_SESSION['cartItems'] = array();
                $_SESSION["totalBasketItems"] =  $resultOfCart->num_rows;
                if($resultOfCart->num_rows > 0) {
                    while($basketResult = $resultOfCart->fetch_assoc()) {

                        $_SESSION['cartItems'][]= $basketResult;

                    }
                }
        } else {

                echo "There was an issue in adding item to cart";
            }
        }
    }
                
            
    function buyBooks($conn) {
    
        
        $basketID = $_SESSION["basketID"];
        $username = $_SESSION["username"];
        $getBasketdetails = "select * from contains where basketID = '$basketID'";
        $resultOfCart = ($conn->query($getBasketdetails));
        
        while($cartDetails = $resultOfCart->fetch_assoc()) {
            
            $ISBN = $cartDetails['ISBN'];
            $cartItemsNumber = $cartDetails['number'];
            $getQueryForStocks = "select * from stocks where ISBN = '$ISBN' and number > 0";
            $resultOfQueryForStocks = ($conn->query($getQueryForStocks));
            if($resultOfQueryForStocks->num_rows > 0) {
                while($stockDetails = $resultOfQueryForStocks->fetch_assoc()) {
                    
                    $wareHouseCode = $stockDetails['warehouseCode'];
                    if($cartItemsNumber > 0) {
                        if($cartItemsNumber <= $stockDetails['number']) {
                            //insert normal way
                            //decrement from stcks
                            $insertIntoShiping = "insert into shippingorder values('$ISBN','$wareHouseCode','$username','$cartItemsNumber')";
                            
                            if($conn->query($insertIntoShiping)){
                                
                                
                                $updateStockTable = "update stocks set `number` = `number` - $cartItemsNumber where ISBN = '$ISBN' and warehouseCode = '$wareHouseCode'";
                                if($conn->query($updateStockTable)) {
                                    
                                    echo "successfully updated stocks table";
                                } else {
                                    echo "There was an error updating stocks table";
                                }
                            } else {
                                
                                echo "successfully inserted into shipppng table.";
                            }

                        } else if($stockDetails['number'] != 0 && $cartItemsNumber>$stockDetails['number']) {
                            //insert with stock number
                            
                            $cartItemsNumber = $cartItemsNumber -($cartItemsNumber - $stockDetails['number']);
                            $insertIntoShiping = "insert into shippingorder values('$ISBN','$wareHouseCode','$username','$cartItemsNumber')";
                            if($conn->query($insertIntoShiping)){
                                
                                $updateStockTable = "update stocks set number = number - '$cartItemsNumber' where ISBN = '$ISBN' and warehouseCode = '$wareHouseCode'";
                                
                                if($conn->query($updateStockTable)) {
                                    
                                    echo "successfully updated stocks table";
                                } else {
                                    echo "There was an error updating stocks table";
                                }
                            } else {
                                
                                echo "suceesffully inserted into shipppng table";
                            }
                        } else {
                               // echo "here in break";    
                               break;
                        }
                    } else {
                        echo "no more items in the cart";
                        break;
                    }
                    
                }
                //$_SESSION['totalBasketItems']
                $deleteFromContain = "delete from contains where ISBN = '$ISBN' and basketID = '$basketID'";
                if($conn->query($deleteFromContain)) {
                    $_SESSION["cartItems"] = array();
                    $_SESSION['totalBasketItems'] = 0;
                    echo "items are deleted from the cart";
                } else {
                     echo "could not delete ";
                }
                
            } else {
                //no stock available 
                echo "items are no longer available.";
            }
            
            
        }
        
        
    }
?>
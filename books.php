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
         <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
      <script>
     $(document).ready(function(){
        $('.carousel').carousel({
          interval: 3000
        });
        $(document).on('click','.addToCart',function(){
       
            var isbn = $(this).attr("data-ISBN");
            var number = $("#number_"+isbn).val();
            var total_stock = $(this).attr("data-totalItems");
            
          //  alert("here")
            console.log(isbn);
            console.log(number);
            console.log(total_stock);
             $.ajax({ // this bit doesn't seem to do anything

                    url: 'searchScript.php',
                    data: {
                        
                        isbn:isbn,
                        number:number,
                        totalStock:total_stock,
                        action:'addToCart'
                    
                    },
                    type: 'POST',
                    success: function(data) {
                      
                        console.log(data);
                    alert(data);
                        window.location.reload();
                        
                    },
                    error: function(log) {
                        alert("error")
                        //$('#ajaxdata').html('<div class="alert alert-danger"><strong>There was an error processing your request</strong></div>')
                        //console.log(log.message);
                    }
                }); 
        }); 
         
         
         $(".searchBooks").click(function(){
             
             var id = $(this).attr('id');
             var searchString = $("#searchById").val();
             console.log(searchString)
             console.log(id)
             var data = {
                 
                 id:id,
                 searchString : searchString
             }
         
                $.ajax({ // this bit doesn't seem to do anything

                    url: 'searchScript.php',
                    data: data,
                    type: 'POST',
                    success: function(data) {
                        
                        //console.log(data);
                        $('#booksdisplay').empty().append(data);
                        //$('#searchTitle').val("");
                    },
                    error: function(log) {
                        alert("error")
                        //$('#ajaxdata').html('<div class="alert alert-danger"><strong>There was an error processing your request</strong></div>')
                        //console.log(log.message);
                    }
                });
         
         
         });
         

         
  }); 
    </script>
  </head>
  <body>
      <?php 
        session_start();
        if(!isset($_SESSION['valid']) && !isset($_SESSION['username'])) {
            
            header("Location:login.php");
            
        }  
      
    ?>

      <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Assign 4</a>
            <a class="navbar-brand text-center">CHEAPBOOKS</a>
            
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        
          <form method="POST" class="navbar-form navbar-right" action="logoutScript.php">
                <li><button type="submit" class="btn btn-primary btn-lg" name="logout"> Logout <span class="glyphicon glyphicon-off"> </span></button></li>
            </form>
        
        <ul class="nav navbar-nav navbar-right">
            <li><a  href="showCartItems.php" class="btn btn-default btn-lg"><?php echo $_SESSION['totalBasketItems']?> <span class="glyphicon glyphicon-shopping-cart"> </span> </a></li>
            
        </ul>
            <ul class="nav navbar-nav navbar-right">
            <li><a> <?php echo "Welcome ".$_SESSION['username']?></a></li>
        </ul>
        </div><!--/.nav-collapse -->
           
      </div>
    </nav>
      
      
      <div class="container">
     <div class="row">

            

            <div class="col-md-9">
                <div clas="row">
                    <h3>Search Books</h3>
                    <input type="text" id="searchById" />
                    <button id="searchByAuthor" class="btn btn-primary searchBooks"> Search By Author</button> 
                    <button id="searchByTitle" class="btn btn-primary searchBooks">Search by Title</button>
                </div>
                <br/>
<!--
                <div class="row carousel-holder">

                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="carousel-example-generic" data-slide-to="1"></li>
                                
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="slide-image" src="images/display/1.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="images/display/2.jpg" alt="">
                                </div>
                                
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div>
-->
  <div id="booksdisplay">

<?php
//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "cheapbooks"; 
//   $sql = "";             
//$conn = new mysqli($servername, $username, $password, $dbname);
//
//                
//                    $sql = "select * from book";
//                
//            
//$result = $conn->query($sql);
//
//                
//                
//if ($result->num_rows > 0) {
//    
//    // output data of each row
//    while($row = $result->fetch_assoc()) {
//    
//        echo '<div class="col-sm-6 col-md-3">
//                <div class="thumbnail">
//                    <a href="#">
//                        <img src="images/books/'.$row["ISBN"].'.jpg" class="img-thumbnail" />   
//                    </a> 
//                    
//                    <div class="caption text-center">
//                    
//                        <h6><a href="#" >'.$row['title'].', '.$row['year'].'</a></h6>
//                        <a class="btn btn-primary btn-xs" href="#"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;View</a>&nbsp;<button class="btn btn-primary btn-xs" data-ISBN="'.$row["ISBN"].'" class="addToCart" data-isbn="" data-><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp; Cart</button></span>
//                        <br/>
//                        <label for="movie"></label><input id="movie" type="number" value="0"/>
//                 </div>
//            </div>
//        </div>';
//    }
//    
//}

    
?>

            <input id="username" type="hidden" value="<?php $_SESSION['username']?>"/>
         </div>
         </div>
      </div>
      </div>
</body>
</html>
<!DOCTYPE html>
<?php session_start(); ?>
<html>
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/barberHomePage.css">
        <link rel="stylesheet" type="text/css" href="assets/barberProfile.css">
        <!-- Latest compiled and minified CSS -->
        <link rel="icon" href="assets/ICONS/favicon.png" type="image/x-icon" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <title>Barber Profile</title>

    </head>
    <body>
        <?php
        include './functions/dbconnect.php';
        include './functions/postrequest.php';
        include './functions/getrequest.php';

        date_default_timezone_set("America/New_York");

        $_SESSION['LoggedIn'] = true;
        $db = getDatabase();
        $id = $_GET['id'];
        //GET ALL BARBER DATA
        $stmt = $db->prepare("SELECT * FROM barber_accounts WHERE BarberID = '$id';");

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "ERROR";
        }
        ?>
        <!-- Use any element to open the sidenav -->
        <div class="top">
            <span class="mainmenu" onclick="openNav()"><span class="glyphicon glyphicon-menu-hamburger" style="color: whitesmoke; font-size: 50px; float:left;"></span></span>
            <div ><a class='options' href="logout.php">Logout</a></div>
            <div align="center"><h2 class='header-text-red'>Barbers</h2></div>

        </div>
        <br/>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="position:absolute;" >&times;</a>
            <p style="color:whitesmoke; font-size: 25px;; font-family: Raleway; font-weight: bold;">
                Barber<span style="color: red; font-size: 25px; font-family: Raleway; font-weight: bolder;">Stop </span>
            </p>
            <a class="a-hamburg" style="    font-family: 'Acme', sans-serif;text-decoration: none;"href="BarberHomePage.php">Home</a>
            <a class="a-hamburg" style="    font-family: 'Acme', sans-serif;text-decoration: none;"href="barber_profiles.php">Barbers</a>
            <a class="a-hamburg" style="    font-family: 'Acme', sans-serif;text-decoration: none;"href="#">Services</a>
            <a class="a-hamburg" style="    font-family: 'Acme', sans-serif;text-decoration: none;"href="#">Contact</a>
        </div>

        <div class='bodyFill'>
            <center>
                <label class='header-text-white'>Heres Our Currently Registered Barbers</label>
            </center>

            <div class="div">
                <?php
                foreach ($results as $barberData):
                    $img = $barberData['image_path'];
                    $name = strtoupper($barberData['barberName']);
                    $uname = $barberData['barberUserName'];
                    $id = $barberData['BarberID'];
                    $email = $barberData['barberEmail'];
                    ?>



                <?php endforeach; ?>
                <div style="width:100%;">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
                                <div class="well profile">
                                    <div class="col-sm-12">
                                        <div class="col-xs-12 col-sm-8">
                                            <h2><?php echo $name;?></h2>
                                            <p><strong>Username: </strong> <?php echo $uname; ?> </p> 
                                            <p><strong>Email: </strong> <?php echo $email; ?> </p> 
                                            <p><strong>Skills: </strong>
                                                <span class="tags">Cutting Hair</span> 
                                            </p>
                                        </div>             
                                        <div class="col-xs-12 col-sm-4 text-center">
                                            <figure>
                                                <img src="USER_BARBER_IMAGES/<?php echo $img ?>" alt="" class="img-circle img-responsive">
                                                <figcaption class="ratings">
                                                    <p>Ratings
                                                        <a href="#">
                                                            <span class="fa fa-star"></span>
                                                        </a>
                                                        <a href="#">
                                                            <span class="fa fa-star"></span>
                                                        </a>
                                                        <a href="#">
                                                            <span class="fa fa-star"></span>
                                                        </a>
                                                        <a href="#">
                                                            <span class="fa fa-star"></span>
                                                        </a>
                                                        <a href="#">
                                                            <span class="fa fa-star-o"></span>
                                                        </a> 
                                                    </p>
                                                </figcaption>
                                            </figure>
                                        </div>
                                    </div>            
                                    <div class="col-xs-12 divider text-center">
                                        <div class="col-xs-12 col-sm-4 emphasis">
                                            <h2><strong> 20,7K </strong></h2>                    
                                            <p><small>Followers</small></p>
                                            <button class="btn btn-success btn-block"><span class="fa fa-plus-circle"></span> Follow </button>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 emphasis">
                                            <h2><strong>245</strong></h2>                    
                                            <p><small>Following</small></p>
                                            <button class="btn btn-info btn-block"><span class="fa fa-user"></span> View Profile </button>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 emphasis">
                                            <h2><strong>43</strong></h2>                    
                                            <p><small>Snippets</small></p>
                                        </div>
                                    </div>
                                </div>                 
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript" src="assets/js/js_functions.js">
        </script>
    </body>



</html>

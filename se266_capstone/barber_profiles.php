<!DOCTYPE html>
<?php session_start(); ?>
<html>
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="assets/ICONS/favicon.png" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="assets/barberHomePage.css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <title>Barbers</title>

    </head>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Acme');
        html{
            font-family: 'Acme', sans-serif;
            padding-top:none;
            background-image: none;
        }
        body{
            display:table;
            font-family: 'Acme', sans-serif;
            padding-top:none;
            background-image: none;
            overflow:auto;
            height:100%;
            position: absolute;
        }
        .div{
            overflow:auto;
            display: flex;
            flex-direction: column;
            width:1200px;
            background-color:rgba(0, 0, 0, 0.9);
            border-radius:10px;
            border:3px solid red;
            padding:10px;
            padding-bottom: 3px;
            min-height: 120px;
            position:relative;
        }
        .div-text{
            padding-top:100px;
            overflow:auto;
            width:850px;
            height: 95px;
            border-radius:10px;
            border:3px solid red;
            padding:4px;
        }

        .label{
            color:whitesmoke;
            font-size: 1.3em;

        }
        .btnlink{
            background:none;
            color:red;
            font-size: 14px;
            border:none;
        }
        .commentform{
            position: relative;
            bottom: 0;
        }
        .textarea{
            outline: none;
            padding:10px;
            font-family: 'Acme', sans-serif;
            width:400px;
            resize: none;
            border: 2px solid red;
            border-radius: 10px;
            background-color: black;
            color:whitesmoke;
        }
        .btnlink:hover{

            color:whitesmoke;
        }
        .likeOptions{
            background: none;
            color:red;
            padding:5px;
            font-size: 20px;
            float: right;
            border:none;
        }
        .top{
            background-color:rgba(0, 0, 0, 0.8);
            height:125px;
            position:relative;
            padding-top: 5px;          
        }
        .mainmenu{
            color:red;
        }
        .header-text-red{
            font-family: 'Acme', sans-serif;
            font-weight: bold;
            color:red;
            font-size:4em;
            height:105px;
        }
        .header-text-white{
            font-family: 'Acme', sans-serif;
            font-weight: bold;
            color:white;
            font-size:2em;
            height:105px;
        }
        .like-div{
            float:right;
        }
        .err-white{
            color:whitesmoke;
            font-size:16px;
        }
        .alert {
            transition: opacity 2s ease-in;
            width:1200px;
            padding: 20px;
            background-color: #f44336;
            color: white;
            display:none;
            position:inherit;
        }
        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: opacity 2s ease-in;
        }
        .closebtn:hover {
            color: black;
        }
        .profile_pic_small{
            border-radius:50%;
            border: 2px solid red;
        }
        .bodyFill{
            background-color:rgba(0, 0, 0, 0.85);
            padding:15px;
            width:100%;
            height:100%;
        }
        .label-date{
            color:white;
            float:left;

        }
        .checked {
            color: orange;
        }
        #ratingDiv{
            color:white;
            width:100px;
            padding-bottom: 3px;
        }
        .likes{
            color:white;
            float:right;
            width:100px;
        }
        a-hamburg{
            font-family: 'Acme', sans-serif;
            text-decoration: none;
        }
        .card {
            position:relative;
            float:left;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 300px;
            height:350px;
            background-color: white;
            margin: 10px;;
            padding-bottom:none;
            border-bottom: none;
            text-align: center;
        }
        .imgdiv{
            height:200px;
        }
        img{
            max-width:100%; 
            max-height:100%;
            margin:auto;
            display:block;
        }
        .title {
            color: grey;
            font-size: 18px;
        }

        .button {
            border: none;
            outline: 0;
            display: inline-block;
            padding: 8px;
            color: red;
            background-color: #000;
            text-align: center;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
        }
        .button:hover{
            text-decoration: none;
            transition:1s;       
            color:white;
        }
        .options{
            color:white;
            float:right;
            padding:5px;
            font-size: 14px;
        }
    </style>
    <body>
        <?php
        include './functions/dbconnect.php';
        include './functions/postrequest.php';
        include './functions/getrequest.php';

        date_default_timezone_set("America/New_York");

        $_SESSION['LoggedIn'] = true;
        $db = getDatabase();

        //GET ALL BARBER DATA
        $stmt = $db->prepare("SELECT * FROM barber_accounts;");

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
            <a class="a-hamburg" style="    font-family: 'Acme', sans-serif;text-decoration: none;"href="#">About</a>
            <a class="a-hamburg" style="    font-family: 'Acme', sans-serif;text-decoration: none;"href="#">Services</a>
            <a class="a-hamburg" style="    font-family: 'Acme', sans-serif;text-decoration: none;"href="#">Contact</a>
        </div>

        <div class='bodyFill'>
            <center>
                <label class='header-text-white'>Heres Our Currently Registered Barbers</label>
            </center>
            <?php
            foreach ($results as $barberData):
                $img = $barberData['image_path'];
                $name = strtoupper($barberData['barberName']);
                $uname = $barberData['barberUserName'];
                $id = $barberData['BarberID'];
                ?>
                <div class="card">
                    <div class='imgdiv'>
                        <img class="img" src="USER_BARBER_IMAGES/<?php echo $img ?>" alt="" style="width:100%; display: inline-block;">
                    </div>
                    <h1><?php echo $name ?></h1>
                    <p class="title">@<?php echo $uname; ?></p>
                    <p></p>
                    <p><a class="button" href="barber_profile_page.php?id=<?php echo $id; ?>">View Profile</a></p>
                </div>









            <?php endforeach; ?>



        </div>
        <script type="text/javascript" src="assets/js/js_functions.js">
        </script>
    </body>



</html>

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
        <title>Barber Home</title>

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
        .header-text-white{
            font-family: 'Acme', sans-serif;
            font-weight: bold;
            color:red;
            font-size:4em;
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

        $getDB = getDatabase();
        // print_r($getDB);
        $db = getDatabase();
        //DECLARE ERRORS
        $likes_err = "";



        $stmt = $db->prepare("SELECT * FROM reviews;");

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $message = "Data Read";
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $message = "No Data Has Been Read, There Was An Error";
        }

        //comment
        if (isset($_POST['comment_submit'])) {
            $username = $_SESSION['uname'];
            $stmt_uname = $db->prepare("SELECT UserID FROM user_accounts WHERE uname = '$username';");
            if ($stmt_uname->execute() && $stmt_uname->rowCount() > 0) {
                $name = $stmt_uname->fetchAll(PDO::FETCH_ASSOC);
                foreach ($name as $nameData) {
                    $_SESSION['UserID'] = $nameData['UserID'];
                }
            }

            $id = filter_input(INPUT_POST, 'review_id');
            $_SESSION['id'] = $id;
            $comment = filter_input(INPUT_POST, 'com_text');
            $userid = $_SESSION['UserID'];
            $stmt_com = $db->prepare("INSERT INTO review_comments (comment_text, UserID, reviewID) VALUES ('$comment','$userid','$id');");
            echo "INSERT INTO review_comments (comment_text, UserID, reviewID) VALUES ('$comment','$userid','$id')";

            if ($stmt_com->execute() && $stmt_com->rowCount() > 0) {
                echo '<script language="javascript">';
                echo 'alert("Comment Successfully Added")';
                echo '</script>';
            }
        }


        //ADD LIKE
        if (isset($_POST['like'])) {
            $username = $_SESSION['uname'];
            $stmt_uname = $db->prepare("SELECT UserID FROM user_accounts WHERE uname = '$username';");

            if ($stmt_uname->execute() && $stmt_uname->rowCount() > 0) {
                $name = $stmt_uname->fetchAll(PDO::FETCH_ASSOC);
                foreach ($name as $nameData) {
                    $_SESSION['UserID'] = $nameData['UserID'];
                }
            }
            $userID = $_SESSION['UserID'];
            $id_review = filter_input(INPUT_POST, 'review_id_likes');

            //CHECK IF USER ALREADY LIKED
            $stmt_validate = $db->prepare("SELECT * FROM review_likes WHERE likes = 'YES' AND UserID = '$userID' AND reviewID = '$id_review';");
            if ($stmt_validate->execute() && $stmt_validate->rowCount() > 0) {

                $likes_err = "<label class='err-white'>You've Already Liked This Review!</label>";
                echo '<style type="text/css">.alert {transition:0.8s;display: inline-block;}</style>';
            } else {
                //ADD LIKE
                $datetime = date("Y-m-d h:i:sa");
                $stmt = $db->prepare("INSERT INTO review_likes (likes, dislikes, date_submitted, UserID, reviewID) VALUES ('YES', 'NO', '$datetime', '$userID', '$id_review');");
                if ($stmt->execute() && $stmt->rowCount() > 0) {
                    $likes_err = "<label class='err-white'>Your Like Has Been Added!</label>";
                    echo '<style type="text/css">.alert {transition:0.8s;display: inline-block; background-color:limegreen;}</style>';
                }
            }
        }

        //ADD DISLIKE
        if (isset($_POST['dislike'])) {
            $username = $_SESSION['uname'];
            $stmt_uname = $db->prepare("SELECT UserID FROM user_accounts WHERE uname = '$username';");
            $id_review = filter_input(INPUT_POST, 'review_id_likes');
            if ($stmt_uname->execute() && $stmt_uname->rowCount() > 0) {
                $name = $stmt_uname->fetchAll(PDO::FETCH_ASSOC);
                foreach ($name as $nameData) {
                    $_SESSION['UserID'] = $nameData['UserID'];
                }
            }
            $userID = $_SESSION['UserID'];


            //CHECK IF USER ALREADY DISLIKED
            $stmt_validate = $db->prepare("SELECT * FROM review_likes WHERE dislikes = 'YES' AND UserID = '$userID' AND reviewID = '$id_review';");
            if ($stmt_validate->execute() && $stmt_validate->rowCount() > 0) {

                $likes_err = "<label class='err-white'>You've Already Disliked This Review!</label>";
                echo '<style type="text/css">.alert {transition:0.8s;display: inline-block;}</style>';
            } else {
                //ADD DISLIKE
                $datetime = date("Y-m-d h:i:sa");
                $id_review = filter_input(INPUT_POST, 'review_id_likes');

                $stmt = $db->prepare("INSERT INTO review_likes (likes, dislikes, date_submitted, UserID, reviewID) VALUES ('NO', 'YES', '$datetime', '$userID', '$id_review');");
                if ($stmt->execute() && $stmt->rowCount() > 0) {
                    $likes_err = "<label class='err-white'>Your Dislike Has Been Added!</label>";
                    echo '<style type="text/css">.alert {transition:0.8s;display: inline-block; background-color:limegreen;}</style>';
                }
            }
        }
        ?>
        <!-- Use any element to open the sidenav -->
        <div class="top">
            <span class="mainmenu" onclick="openNav()"><span class="glyphicon glyphicon-menu-hamburger" style="color: whitesmoke; font-size: 50px; float:left;"></span></span>
            <div ><a class='options' href="logout.php">Logout</a></div>
            <div align="center"><h2 class='header-text-white'>Barber Reviews</h2></div>
        </div>
        <br/>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="position:absolute;" >&times;</a>
            <p style="color:whitesmoke; font-size: 25px;; font-family: Raleway; font-weight: bold;">
                Barber<span style="color: red; font-size: 25px; font-family: Raleway; font-weight: bolder;">Stop </span>
            </p>
            <a class="a-hamburg" style="    font-family: 'Acme', sans-serif;text-decoration: none;"href="#">About</a>
            <a class="a-hamburg" style="    font-family: 'Acme', sans-serif;text-decoration: none;"href="#">Services</a>
            <a class="a-hamburg" style="    font-family: 'Acme', sans-serif;text-decoration: none;"href="barber_profiles.php">Barbers</a>
            <a class="a-hamburg" style="    font-family: 'Acme', sans-serif;text-decoration: none;"href="#">Contact</a>
        </div>
        <div class='bodyFill'>
            <!-- ALERTS FOR LIKES AND DISLIKES -->
            <center style='position:relative;'>
                <div id='alert' class="alert" align='center'>
                    <span class="closebtn" onclick="this.parentElement.style.display = 'none';">&times;</span> 
                    <?php echo $likes_err; ?>
                </div>
            </center>

            <!-- EACH REVIEW AND ITS DATA -->
            <?php
            foreach ($results as $data): $barberID = $data['BarberID'];
                $userID = $data['UserID'];
                ?>
                <div align="center" style='position:relative;'>
                    <div class="div">
                        <?php
                        //GET LIKES AND DISLIKES FOR CURRENT REVIEW
                        $likes = "";
                        $dislikes = "";
                        $likes_id = $data['reviewID'];
                        $likes_stmt = $db->prepare("SELECT * FROM review_likes WHERE likes = 'YES' and reviewID = '$likes_id';");
                        $dislikes_stmt = $db->prepare("SELECT * FROM review_likes WHERE dislikes = 'YES' and reviewID = '$likes_id';");

                        if ($likes_stmt->execute() && $likes_stmt->rowCount() > 0) {
                            $results_likes = $likes_stmt->fetchAll(PDO::FETCH_ASSOC);
                        }
                        if ($dislikes_stmt->execute() && $dislikes_stmt->rowCount() > 0) {
                            $results_dislikes = $dislikes_stmt->fetchAll(PDO::FETCH_ASSOC);
                        }
                        ?>
                        <div class="div-text-left" style="float:left;">

                            <div class='like-div'>
                                <form method='post' action=''>
                                    <input type="hidden" name="review_id_likes" value="<?php echo $data['reviewID']; ?>">
                                    <input type='submit' class='likeOptions' name='like' value='&#128077;'>&nbsp;<input type='submit' class='likeOptions' name='dislike' value='&#128078;'>


                                </form>
                            </div>
                            <label class='likes'><?php echo $likes_stmt->rowCount(); ?></label> 
                            &nbsp;&nbsp;&nbsp;
                            <label class='likes'><?php echo $dislikes_stmt->rowCount(); ?></label>

                            <?php
                            //GET USER IMAGE + USERNAME
                            $user_name_stmt = $db->prepare("SELECT uname, image_path FROM user_accounts Where UserID = '$userID';");
                            if ($user_name_stmt->execute() && $user_name_stmt->rowCount() > 0) {
                                $results_users = $user_name_stmt->fetchAll(PDO::FETCH_ASSOC);
                            }
                            foreach ($results_users as $userdata) {
                                echo "<label class='label' style='float:left; color:red;'>By:&nbsp;&nbsp;" . "<img src='USER_BARBER_IMAGES/" . $userdata['image_path'] . "' class='profile_pic_small' height='46' width='46'>" . "&nbsp;<span style='color:whitesmoke;padding-top:12px;'>" . $userdata['uname'] . "</span></label>";
                            }

                            //GET BARBER IMAGE + USERNAME
                            $barber_name_stmt = $db->prepare("SELECT barberUserName, image_path FROM barber_accounts Where BarberID = '$barberID';");
                            if ($barber_name_stmt->execute() && $barber_name_stmt->rowCount() > 0) {
                                $results_barbers = $barber_name_stmt->fetchAll(PDO::FETCH_ASSOC);
                            }
                            foreach ($results_barbers as $barberdata) {
                                echo "<label class='label' style='float:left; color:red;'>Barber Reviewed:&nbsp;&nbsp;" . "<img src='USER_BARBER_IMAGES/" . $barberdata['image_path'] . "' class='profile_pic_small' height='46' width='46'>" . "&nbsp;<span style='color:whitesmoke;padding-top:12px;'>" . $barberdata['barberUserName'] . "</span></label>";
                            }

                            //GET RATING
                            $s1 = $s2 = $s3 = $s4 = $s5 = "";
                            $rating = $data['rating'];
                            if ($rating == "1") {
                                $s1 = "fa fa-star checked";
                                $s2 = "fa fa-star";
                                $s3 = "fa fa-star";
                                $s4 = "fa fa-star";
                                $s5 = "fa fa-star";
                            } else if ($rating == "2") {
                                $s1 = "fa fa-star checked";
                                $s2 = "fa fa-star checked";
                                $s3 = "fa fa-star";
                                $s4 = "fa fa-star";
                                $s5 = "fa fa-star";
                            } else if ($rating == "3") {
                                $s1 = "fa fa-star checked";
                                $s2 = "fa fa-star checked";
                                $s3 = "fa fa-star checked";
                                $s4 = "fa fa-star";
                                $s5 = "fa fa-star";
                            } else if ($rating == "4") {
                                $s1 = "fa fa-star checked";
                                $s2 = "fa fa-star checked";
                                $s3 = "fa fa-star checked";
                                $s4 = "fa fa-star checked";
                                $s5 = "fa fa-star";
                            } else if ($rating == "5") {
                                $s1 = "fa fa-star checked";
                                $s2 = "fa fa-star checked";
                                $s3 = "fa fa-star checked";
                                $s4 = "fa fa-star checked";
                                $s5 = "fa fa-star checked";
                            } else {
                                $s1 = "fa fa-star";
                                $s2 = "fa fa-star";
                                $s3 = "fa fa-star";
                                $s4 = "fa fa-star";
                                $s5 = "fa fa-star";
                            }
                            ?>

                            <div id='ratingDiv'>
                                <h2 >Rating</h2>
                                <span class="<?php echo $s1; ?>"></span>
                                <span class="<?php echo $s2; ?>"></span>
                                <span class="<?php echo $s3; ?>"></span>
                                <span class="<?php echo $s4; ?>"></span>
                                <span class="<?php echo $s5; ?>"></span>
                            </div>
                        </div>

                        <div class="div-text" style="float:right;">
                            <label class="label" style="float:left;"><?php echo $data["review_text"]; ?></label>
                        </div>

                        <br/>
                        <form method='post' class='commentform'>
                            <input type='hidden' name='review_id' value="<?php echo $data['reviewID']; ?>">
                            <?php
                            $id = "ID_" . $data['reviewID'];
                            $btn = "btn_" . $data['reviewID'];
                            ?>
                            <button type='button' onclick='document.querySelector("#<?php echo $id ?>").style.display = "block"; document.querySelector("#<?php echo $btn ?>").style.display = "block"; this.style.display = "none"' class='btnlink'>Leave a Comment</button>
                            &nbsp;&nbsp;

                            <a href='view_comments.php' class='btnlink'>View Comments</a>
                            <textarea id='<?php echo $id; ?>' class='textarea' name='com_text' placeholder="Enter Comment Here" style='display: none;' required></textarea>
                            <input type='submit' id='<?php echo $btn; ?>' style='display: none;' class='btnlink' name='comment_submit' value ='Comment'>
                        </form>
                        <div class="date_submitted">
                            <?php
                            $rev = $data['reviewID'];
                            $review_stmt2 = $db->prepare("SELECT date_submitted FROM reviews Where UserID = '$userID' AND reviewID = '$rev';");
                            if ($review_stmt2->execute() && $review_stmt2->rowCount() > 0) {
                                $results_users = $review_stmt2->fetchAll(PDO::FETCH_ASSOC);
                            }
                            foreach ($results_users as $userdata2) {
                                echo "<label class='label-date'>Submitted: " . $userdata2['date_submitted'] . " </label>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <br/>
            <?php endforeach; ?>
        </div>
        <script type="text/javascript" src="assets/js/js_functions.js">
        </script>

    </body>



</html>

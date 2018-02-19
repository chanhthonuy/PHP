<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BarberStop</title>
        <link rel="stylesheet" type="text/css" href="assets/landingStyles.css">
        <link rel="icon" href="assets/ICONS/favicon.png" type="image/x-icon" />
    </head>
    <body>

        <?php
        if(isset($_POST['submit_reg'])){
            $choice = filter_input(INPUT_POST,'registry');
            if($choice =="user"){
                header('location: userRegistry.php');
            }
            else if($choice == "barber"){
                header('location: barberRegistry.php');
            }
            else{
                echo "<script type='tex/javascript>'";
                echo "alert('There Was An Error, Please Contact An Admin ASAP');";
                echo "</script>";
            }
        }
        ?>

        <section class="intro">

            <div class="inner">
                <div class="content">

                    <h1 style="background-color: whitesmoke; border: solid black 3px; border-radius: 9px">Barber<span style="color: red;">Stop</span></h1>
                    <div class="btndiv">
                        <br><br><br>


                        <center>
                            <div class="landingBtn"><a  href="UserLogin.php" class="div-a">Login</a></div>
                            <br>
                            <br>
                            <br>
                            <form method="post" class="landingBtn"><label style="font-weight:bold;">Registry</label><br/>
                                Select An Account Type:<br/>Barber <input type="radio" name="registry" value="barber" required>&nbsp;&nbsp;&nbsp;User: <input type="radio" name="registry" value="user" required>
                                <br/><input type="submit" name="submit_reg" class="btn" value="Go &rarr;">
                                <br/>
                            </form>
                            <br>
                        </center>

                        <br><br><br>
                    </div>    
                </div>
            </div>



        </section>    






    </body>
    <style>
        .div-a{
            color:red; 
            background-color: whitesmoke;
            font-family: 'Oswald', sans-serif;
            font-size: 135%; 
            padding: 10px 20px;
            text-transform: uppercase;
            text-decoration: none;
            align-content: center;
            text-decoration: none;
        }
        .btn{
            position: relative;
            color:red; 
            background-color: whitesmoke;
            border: 1px solid red ; 
            border-radius: 9px;
            font-family: 'Oswald', sans-serif;
            font-size: 135%; 
            outline:none;
        }
        .btn:hover{
            color:red;
            font-weight: bold;
            outline:none;
            border:2px solid red;
        }
        .landingBtn{
            color:red; 
            background-color: whitesmoke;
            width:250px;
            border: 3px solid red ; 
            border-radius: 9px;
            font-family: 'Oswald', sans-serif;
            font-size: 135%; 
            padding: 10px 20px;
            text-transform: uppercase;
            text-decoration: none;
            align-content: center;
            margin: 0;
            outline:none;
        }        
        .landingBtn:hover{
            color:red;
            font-weight: bold;
            border:2px solid red;
            outline: none;
        }
    </style>
</html>

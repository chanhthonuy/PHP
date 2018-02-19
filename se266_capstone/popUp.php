<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="popup.css">
    </head>
    <body>
        <?php
        session_start();

        $_SESSION['LoggedIn'] = true;

        include './functions/dbconnect.php';

        $db = getDatabase();

        //TEST FOR A CONNECTION TO THE DATABASE 
        //print_r($db);  -->> WE GOT A CONNECTION 

        if (isset($_POST['submit'])) {

            $barberID = filter_input(INPUT_POST, 'barberID');
            $barberName = filter_input(INPUT_POST, 'barberID'); 
            $name = filter_input(INPUT_POST, 'name');
            $date = filter_input(INPUT_POST, 'date');
            $time = filter_input(INPUT_POST, 'time');
            $phone = filter_input(INPUT_POST, 'phone');
            $description = filter_input(INPUT_POST, 'description');

            $stmt = $db->prepare("INSERT INTO appointments SET Name = $name, Date = $date, Time = $time, Description = $description, PhoneNumber = $phone");


            //TESTING THE SQL STATEMENT 
            echo "INSERT INTO appointments SET Name = '$name', Date = '$date', Time = '$time', Description = '$description', PhoneNumber = '$phone'";



            if ($stmt->execute() && $stmt->rowCount() > 0) {
                echo "You Have Successfully Booked Your Appointment";
            } else {
                echo "Something Went Wrong Please Try Again";
            }

            $sql_barb = $getDB->prepare("SELECT * FROM barber_accounts;");
            if ($sql_barb->execute() && $sql_barb->rowCount() > 0) {
                $results_barb = $sql_barb->fetchAll(PDO::FETCH_ASSOC);
            }
        } // END ISSET 
        ?>
        <!-- Trigger/Open The Modal -->
        <button id="myBtn">Open Modal</button>


        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content" style="background-color: black;">
                <!-- Close the Modal -->
                <span class="close">&times;</span>


                <center>
                    <!-- form inside the modal to book an appointment--> 
                    <form action="#" method="POST" style="background-color: black;  opacity: 0.6;">
                        <h1 style="font-family: Raleway; font-weight: bold;">Barber<span style="color: red; border: solid black 3px; border-radius: 9px; font-family:Raleway; font-weight: bolder;">Stop</span></h1>
                        <input type="text" name="name" id="name" placeholder="Name" autocomplete="off" required><br><br>
                        <input type="text" name="date" id="date" placeholder="Date" autocomplete="off" required><br><br>
                        <input type="text" name="time" id="time" placeholder="Time" autocomplete="off" required><br><br>
                        <input type="text" name="phone" id="phone" placeholder="Phone Number" autocomplete="off" required> <br><br>
                        <input type="text" name="description" id="description" placeholder="Description" autocomplete="off" required><br><br>
                        <select name="barbername" id="selectbarber" >
                            <option  value='Select Your Barber' disabled selected>Select Your Barber</option><br><br>
                            
                            <?php 
                            $sql_barb = $db->prepare("SELECT * FROM barber_accounts"); 
                            echo "SELECT * FROM barber_accounts"; 
                            
                            if($sql_barb->execute() && $sql_barb->rowCount() > 0)
                            {
                                $results2 = $sql_barb->fetchAll(PDO::FETCH_ASSOC); 
                            }
                            
                            echo $results2; 
                            ?>

                            
                            <?php foreach ( $results2 as $selectData): ?>

                                <option value="<?php echo $selectData['BarberID'] ?>"><?php echo $selectData['barberName'] ?></option>
                            <?php endforeach; ?> 

                        </select>

                        <input type="submit" name="submit" id="submit">
                    </form>
                </center>
            </div>

        </div>




        <script type="text/javascript" src="popup.js">


        </script>

    </body>
</html>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Week 1 - Random Grid</title>
        <style type="text/css">
            input[type="text"] { width: 40px; } 
            .red {background-color: red;}
            .blue {background-color: blue;}
            .transparent {background-color: transparent;}

        </style>

    </head>
    <body>
        <div style="margin-left:200px; margin-top:50px;">
            <h2>Week 1 - Random Grid</h2>
            <form name="random" action="randomGrid.php" method="post">
                <label>Number:</label>
                <input type="text" name="num" value="">
                <input type="submit" name="generateGrid" value="Generate Grid">
            </form>

            <table border="1">
                <?php
                if (isset($_POST['generateGrid'])) {

                    $num = $_POST['num'];

                    for ($row = 0; $row < $num; $row++) {
                        echo "<tr>";
                        for ($col = 0; $col < $num; $col++) {
                            $randomNumber = rand(1, 100);
                                $total =0;

                            $color = "";
                            if ($randomNumber % 3 == 0) {
                                echo "<td class = 'red'>$randomNumber</td>";
                            } else if ($randomNumber % 2 == 0) {
                                echo "<td class = 'blue'>$randomNumber</td>";
                            } else {
                                echo"<td class = 'transparent'>$randomNumber</td>";
                            }
                        }
                        
                        echo "<tr />";
                       
                    }
                     $total = $randomNumber / ($num * $num);

                        echo "<p>The average is ";
                        echo $total;
                        echo "</p>";
                }
                
                ?>
            </table>
            
    </body>
</html>

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
    </head>
    <body>
        <?php
        $shoeSize = 10;
        for ($i=0; $i<100; $i++){
            if ($i % 2==0 && $i% 3==0) {
            echo "fizz buzz<br />";            
            }
            else if ($i%2 == 0){
            echo "fizz<br />";  
            } 
         else if ($i%3 == 0) {
                echo "buzz<br />";               
         }else {
             echo "$i<br />";
         }
            
            
        }
        
        ?>
    </body>
</html>

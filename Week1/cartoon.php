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
      <form action="cartoon.php" method="post">

  What's your favorite cartoon character?<br>
 
  <input type="radio" name="cartoon" value="Mickey Mouse"> Mickey Mouse<br>
  <input type="radio" name="cartoon" value="Donald Duck"> Donald Duck<br>
  <input type="radio" name="cartoon" value="Goofy"> Goofy<br><br>

  <input type="submit" name="submit" value="Submit"><br>
  
 <?php
if (isset($_POST['cartoon'])) {
$favorite = filter_input (INPUT_POST, 'cartoon');
echo $favorite;
} else {
    echo "You did not select a character.";
}
?>

</form>
    </body>
</html>

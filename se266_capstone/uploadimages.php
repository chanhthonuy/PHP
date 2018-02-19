<?php
  include './functions/dbconnect.php'; 
    include './functions/postrequest.php';
    include './functions/salt.php'; 
$db = getDatabase();
$file = $_FILES['image']['tmp_name'];

if (isset ($_FILES['image'])) {
$tmp_name = $_FILES['image']['tmp_name'];
$path = getcwd() .DIRECTORY_SEPARATOR . 'uploads';
$new_name = $path . DIRECTORY_SEPARATOR . $_FILES['image']['tmp_name'];
//move_uploaded_file($tmp_name, $new_name);
$file = $_FILES['image']['tmp_name'];


//while (!feof($file)) {
//   $school = fgetcsv($file);
//   echo ($school[0]) . "<br />";
//}
//$school = fgetcsv($file);
//$school = fgetcsv($file);

 $stmt = $db->prepare("INSERT INTO store SET id=:id, name = :name, image = :image");
 
 while (!feof($file)) {
  
   $name = $name[0];
            $image = $name[1];
            
 
 $binds = array(
                ":name" => $name,
                ":image" => $image
                
          );
 


            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $results = 'Data Added';
            }
            
            
        }
        
 }       

 
//$sql ="INSERT into school (schoolName,city, state)         values ('".$school[0]."','".$school[1]."','".$school[2]."')";
//move_uploaded_file($tmp_name, $new_name);

?>
 <h3><?php echo $results; ?></h3>

<form action="uploadimages.php" method="post" enctype="multipart/form-data">
<input type="file" name="image">
<input type="submit" value="Upload">
</form>
<!-- <form action="search.php" method="post" enctype="multipart/form-data">

<input type="submit" value="Search Schools">
</form>-->
  
   


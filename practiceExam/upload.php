<?php
include './dbconnect.php';
include_once './header.php';

$db = getDatabase();

if (isset ($_FILES['file1'])) {
$tmp_name = $_FILES['file1']['tmp_name'];
$path = getcwd() .DIRECTORY_SEPARATOR . 'uploads';
$new_name = $path . DIRECTORY_SEPARATOR . $_FILES['file1']['name'];
//move_uploaded_file($tmp_name, $new_name);
$file = fopen ('uploads/schools.csv', 'rb');

//while (!feof($file)) {
//   $school = fgetcsv($file);
//   echo ($school[0]) . "<br />";
//}
//$school = fgetcsv($file);
//$school = fgetcsv($file);

 $stmt = $db->prepare("INSERT INTO friends SET schoolName = :schoolName, city = :city, state= :state");
 
 while (!feof($file)) {
  $school = fgetcsv($file);
   $schoolName = $school[0];
            $city = $school[1];
            $state = $school[2];
 
 $binds = array(
                ":schoolName" => $schoolName,
                ":city" => $city,
                ":state" => $state
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

<form action="upload.php" method="post" enctype="multipart/form-data">
<input type="file" name="file1">
<input type="submit" value="Upload">
</form>
 <form action="search.php" method="post" enctype="multipart/form-data">

<input type="submit" value="Search Schools">
</form>
  
   


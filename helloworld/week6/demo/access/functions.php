<?php

function isLoggedIn() {
    
    if ( !isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false 
            ) {
            return false;
        }
        return true;
}
if(isset($_POST["Import"])){
		
		$filename=$_FILES["file"]["tmp_name"];		


		 if($_FILES["file"]["size"] > 0)
		 {
		  	$file = fopen($filename, "r");
	        while (($school = fgetcsv($file, 10000, ",")) !== FALSE)
	         {


	           $sql = "INSERT into school (schoolName,city,state) 
                   values ('".$school[0]."','".$school[1]."','".$school[2]."','".$school[3]."','".$school[4]."')";
                   $result = mysqli_query($con, $sql);
				if(!isset($result))
				{
					echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"upload.php\"
						  </script>";		
				}
				else {
					  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"upload.php\"
					</script>";
				}
	         }
			
	         fclose($file);	
		 }
	}	 


 ?>
<?php
    session_start();
    
    if ($_SESSION["loggedin"] == "TRUE") {
        
        
    } else if ($_SESSION["loggedin"] == "FALSE") {
        header('Location: login.php');
        // Just in case if login.php is bypass, die(). ##
        echo "You Are Not Logged In!";
        die();
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body>
        <?php
            
            include_once './functions/dbconnect.php';
            include_once './functions/dbData.php';
            
            $results = getAllTestData();
            
            $action = filter_input(INPUT_GET, 'action');
            if ($action === 'sort') {
                $column = filter_input(INPUT_GET, 'name');
                $order = filter_input(INPUT_GET, 'sort');
                $results = sortTest($column, $order);
            } else if ($action === 'search') {
                $column = filter_input(INPUT_GET, 'name');
                $searchWord = filter_input(INPUT_GET, 'search');
                $search = '%'.$searchWord.'%';
                $results = searchTest($column, $search);
            }
            
            include_once './includes/sort.php';
            include_once './includes/search.php';
            
        ?>
		<br />
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th>School Name</th>
                    <th>City</th>
                    <th>State</th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo $row['SchoolName']; ?></td>
                    <td><?php echo $row['City']; ?></td>
                    <td><?php echo $row['State']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>

<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <meta charset="UTF-8">
    <title></title>        
</head>
<div style="overflow:hidden; display:inline-block; border:2px solid black; border-radius: 10px; padding:20px; background-color: white; padding: 10px;">
    <br/><br/>
    <form action="view.php">
        <button type="submit">Get Rid Of Table</button>    
    </form>

    <br/><br/><br/>
    <h1 style="font-family: verdana;">Data Retrieved</h1>

    <table border="1" class="table table-striped">
        <thead ">
            <tr>
                <th>ID</th>
                <th>Corporation</th>
                <th>Email</th>
                <th>OWNER</th>
                <th>INCORP_DT</th>
                <th>PHONE</th>
                <th>ZIPCODE</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['corp']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['owner']; ?></td>
                    <td><?php echo $row['incorp_dt']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['zipcode']; ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>



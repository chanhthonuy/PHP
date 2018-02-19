<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

        <?php
        $action = filter_input(INPUT_GET, 'action');

        if ($action === 'sort') {
            echo 'Submitted Sort Form';
        }
        if ($action === 'search') {
            echo 'Submitted Search Form';
        }

        include_once './includes/form1.php';
        include_once './includes/form2.php';
        ?>
    </body>
</html>

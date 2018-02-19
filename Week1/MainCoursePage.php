
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SE 266 - Web Development using PHP and MySQL</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    </head>
    <body>

        <div class="container">
            <div class="page-header"><h1><span class="glyphicon glyphicon-home"></span>&nbsp;SE 266 - Web Development using PHP and MySQL</h1>
                <h1>Chan Uy</h1>
                <p>

                </p>
            </div>
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">Purpose of this web site</div>
                        <div class="panel-body">
                            <p>
                                This page hosts all of the assignments for the PHP course.
                            </p>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-8">
                    <div class="panel panel-info">
                        <div class="panel-heading">Assignments</div>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Week</th>
                                        <th>Lab Description</th>
                                        <th>Working Solution</th>
                                        <th>Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Git Tutorial</td>
                                        <td><a href="Git - Push.PNG">Screen Shot</a></td>
                                        <td>N/A</td>

                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Grid showing random numbers</td>
                                        <td><a href="randomGrid.php">Random Grid</a></td>
                                        <td><a href="week1.zip">Random Grid Solution</a></td>

                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>First database app</td>
                                        <td></td>
                                        <td><a href="week2.zip">Actor's Database</a></td>

                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>TBD</td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>TBD</td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>TBD</td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>TBD</td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>TBD</td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>TBD</td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>TBD</td>
                                        <td></td>
                                        <td></td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">

                    <div class="panel panel-primary">
                        <div class="panel-heading">Code</div>
                        <div class="panel-body">
                            <ul>
                                <li><a href="https://github.com/chanhthonuy/PHP.git" target="_blank">My GitHub Repo</a></li>

                            </ul></div>
                    </div>

                    <div class="panel panel-danger">
                        <div class="panel-heading">Resources</div>
                        <div class="panel-body">
                            <ul>
                                <li><a href="http://www.php.net/">php.net</a></li>
                                <li><a href="https://www.w3schools.com/php/">PHP Tutorial on w3schools</a></li>
                                <li><a href="https://www.mysql.com/">MySQL</a></li>
                                <li><a href="https://mariadb.com/kb/en/library/mariadb-vs-mysql-features/">MariaDB versus MySQL</a></li>

                            </ul>

                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div id="footer">
            <div class="container"> 
                <div class="text-muted pull-left">
                    <?php
                    $file = "MainCoursePage.php";
                    $mod_date = date("F d Y h:i:s A", filemtime($file));

                    echo "Last modified $mod_date";
                    ?>     
                </div>
                <div class="text-muted pull-right">&copy; Chan Uy 2017</div>
            </div>
        </div>
    </body>
</html>

<script>
    $(document).ready(function (e) {
        $(".notyet").click(function (e) {
            e.preventDefault();
            alert("In Progress. Check back later.");
        });
    });
</script>
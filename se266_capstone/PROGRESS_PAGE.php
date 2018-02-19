<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>


    </head>
    <body>
        <div class="container">

            <h2><span class="glyphicon glyphicon-user"></span> Patrick Sergi SE266 Main Course Page</h2> 
            <br>
            <br>
            <div class="col-lg-8">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="70"
                     aria-valuemin="0" aria-valuemax="100" style="width:100%">
                    100%
                </div>
            </div>
                 <p>
                We are 100% of the way Through the Quarter
            </p>
            </div>
           


            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Assignments <span class="glyphicon glyphicon-briefcase"></span></div>
                    <div class="panel-body">





                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Week</th>
                                    <th>Assignment</th>                           
                                    <th>Due Date</th>
                                    <th>Solution</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                               
                              
                                <tr>
                                    <td>Week1</td>
                                    <td>Project Proposal</td>
                                    <td>January 14, 2018</td>
                                    <td><a href="Progress_Files/Sergi_CapstoneProposal.docx"/>Download <span class="glyphicon glyphicon-download"></span> </a></td>
                                </tr>
                                
                                <tr>
                                    <td>Week1</td>
                                    <td>Status Report</td>
                                    <td>January 14, 2018</td>
                                    <td></td>
                                  
                                </tr>
                                
                                <tr>
                                    <td>Week 2</td>
                                    <td>Prototype</td>
                                    <td>January 19, 2018</td>
                                    <td></td>
                                </tr>
                                    

                               

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">

                <div class="panel panel-danger">
                    <div class="panel-heading">Code <span class="glyphicon glyphicon-pencil"></span></div>
                    <div class="panel-body">
                        <ul>
                            <li><a href="https://github.com/psergi091788/SE266.git">Click Here For My GitHub</a></li>

                        </ul></div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">Resources <span class="glyphicon glyphicon-folder-open"></span></div>
                    <div class="panel-body">
                        <ul>
                            <li><a href="https://www.youtube.com/playlist?list=PL442FA2C127377F07"/>Learn PHP on YouTube with The New Boston</a> </li>
                            <li><a href="https://www.w3schools.com/bootstrap/default.asp"/>Bootstrap Basics</a> </li>
                            <li><a href="https://www.w3resource.com/html-css-exercise/index.php"/>Sharpen Up on Your HTML and CSS Skills</a> </li>
                            
                            
                        </ul>

                    </div>
                </div>




            </div>             
        </div> <!-- END CLASS CONTAINER -->

        <div id="footer">
            <div class="container">
                <div class="text-muted pull-left">
                     <?php
                    $file = "index.php";
                    $mod_date = date("F d Y h:i:s A", filemtime($file));

                    echo "Last modified $mod_date";
                    ?> 
                </div>
                <div class="text-muted pull-right">&copy; Patrick Sergi 2017</div>
            </div>
        </div>








    </body>

</html>

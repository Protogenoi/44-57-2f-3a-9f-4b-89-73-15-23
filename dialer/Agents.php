<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /../CRMmain.php');
    die;
}

$RETURN = filter_input(INPUT_GET, 'RETURN', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html>
    <title>ADL | Agent Search</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
        <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/styles/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">
        <link rel="stylesheet" type="text/css" href="/js/jquery-ui-1.11.4/jquery-ui.css">
        <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>

        <?php require_once(__DIR__ . '/../includes/navbar.php'); ?>

        <div class="container">
            
            <?php
            
                    if(isset($RETURN)) {
                        if($RETURN=='DELETED') {?>
           <div class='notice notice-info' role='alert'><strong> <center>Agent removed from database</center></strong> </div>
    <?php    } 
    
    if($RETURN=='ADDED') { ?>
           <div class='notice notice-success' role='alert'><strong> <center>Agent added to database</center></strong> </div>
                    <?php } }?>
           
           <div class="col-md-12">
               
               <form class="form-inline" method="POST" action="php/Agents.php?EXECUTE=2">
<fieldset>

<legend>Add new agent</legend>

<div class="form-group"> 
  <div class="col-md-4">
  <input id="NAME" name="NAME" type="text" placeholder="Agent Full Name" class="form-control input-md">
  </div>
</div>

<div class="form-group">
  <div class="col-md-6">
    <select id="TYPE" name="TYPE" class="form-control" required>
      <option value="AGENT">Agent</option>
      <option value="CLOSER">Closer</option>
    </select>
  </div>
</div>

<div class="form-group">
  <div class="btn-group">
    <button id="SUBMIT" name="SUBMIT" class="btn btn-success"><i class="fa fa-check-circle-o"></i> ADD</button>
    <a href="Agents.php" id="RESET" name="RESET" class="btn btn-danger"><i class="fa fa-refresh"></i> RESET</a>
  </div>
</div>

</fieldset>
               </form>    
           </div>
           

                <table id="clients" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Agent Name</th>
                            <th>Group</th>
                            <th>DELETE</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Agent Name</th>
                            <th>Group</th>
                            <th>DELETE</th>
                        </tr>
                    </tfoot>
                </table>
         
  
        </div>

        <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="/js/datatables/jquery.DATATABLES.min.js"></script>
        <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 


        <script type="text/javascript">
            $(document).ready(function () {


                $('#LOADING').modal('show');
            })

                    ;

            $(window).load(function () {
                $('#LOADING').modal('hide');
            });
        </script> 
        <div class="modal modal-static fade" id="LOADING" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <center><i class="fa fa-spinner fa-pulse fa-5x fa-lg"></i></center>
                            <br>
                            <h3>Populating Agent details... </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>    

        <script type="text/javascript" language="javascript" >

            $(document).ready(function () {
                var table = $('#clients').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 10,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                    "ajax": "JSON/Agents.php?EXECUTE=1",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "dialer_agents_name"},
                        {"data": "dialer_agents_group"},
                        {"data": "dialer_agents_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="php/Agents.php?EXECUTE=1&AID=' + data + '">DELETE</a>';
                            }}
                    ]
                });

            });
        </script>
        
    </body>
</html>

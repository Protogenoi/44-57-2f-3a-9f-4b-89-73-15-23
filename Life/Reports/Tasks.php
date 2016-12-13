<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adlfunctions.php'); 
include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;

}

if ($fflife=='0') {
        
        header('Location: ../../CRMmain.php'); die;
    }

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Tasks</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../../styles/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="//cdn.oesmith.co.uk/morris-0.5.1.css">
<link href="../../img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php
    include('../../includes/navbar.php');
    include('../../includes/ADL_PDO_CON.php');
            include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    ?>

      <div class="container">
          
          <?php
          
           $taskassigned= filter_input(INPUT_GET, 'taskassigned', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($taskassigned)){
    
      $taskassigned= filter_input(INPUT_GET, 'taskassigned', FILTER_SANITIZE_SPECIAL_CHARS);
      $assignto= filter_input(INPUT_GET, 'assignto', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($taskassigned =='y') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Task assigned to $assignto!</div><br>");
    }

            if ($taskassigned =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>");
    }
}      
          
  ?>        
    
    <div  class="text-center">
       <label class="label label-success">Incomplete Tasks</label>
      <div id="bar-chart" ></div>
    </div>
  
          <br>
          
    <table id="task" class="display" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th>Added On</th>
                <th>ID</th>
                <th>Client Name</th>
                <th>Assigned</th>
                <th>Task</th>
                <th>Deadline</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Added On</th>
                <th>ID</th>
                <th>Client Name</th>
                <th>Assigned</th>
                <th>Task</th>
                <th>Deadline</th>
            </tr>
        </tfoot>
    </table>

</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.0/morris.min.js"></script>

<script type="text/javascript" language="javascript" src="../../js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>

<script type="text/javascript" language="javascript" src="../../js/datatables/jquery.DATATABLES.min.js"></script>
<script src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
<script>
    
    var json = (function () {
        var json = null;
        $.ajax({
            'async': false,
            'global': false,
            'url': '../JSON/GetAllTasks.php?agent=<?php echo $hello_name;?>',
            'dataType': "json",
            'success': function (data) {
                json = data;
            }
        });
        return json;
    })
    ();
     
    config = {
      data: json,
      xkey: 'Task',
      ykeys: ['Completed'],
      labels: ['Incompleted Tasks'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      pointFillColors:['#ffffff'],
      pointStrokeColors: ['black'],
      lineColors:['gray','red']
  };


config.element = 'bar-chart';
Morris.Bar(config);
</script>

<script type="text/javascript" language="javascript" >
function format ( d ) {

    return '<form action="../php/assigntask.php?assign=1" method="post"><table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Re-assigned to:</td>'+
            '<td><input type="hidden" name="taskid" value="'+d.id+'"><select name="assigned"><option value="'+d.assigned+'">'+d.assigned+'</option><option value="Roxy">Roxy</option><option value="Jakob">Jakob</option><option value="Nicola">Nicola</option><option value="Amelia">Amelia</option><option value="Abbiek">Abbiek</option><option value="carys">Carys</option><option value="Michael">Michael</option></select><button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-ok"></span> Assign</button></form></td>'+
        '</tr>'+
    '</table>';
}


$(document).ready(function() {
    var table = $('#task').DataTable( {
"fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
    if ( aData["deadline"] < aData["today"] )  {
          $('td', nRow).eq(6).addClass( 'red' );
    }
        if ( aData["deadline"] == aData["today"] )  {
          $('td', nRow).eq(6).addClass( 'orange' );
    }
   if ( aData["deadline"] > aData["today"] )  {
          $('td', nRow).eq(6).addClass( 'green' );

    }
},
"response":true,
					"processing": true,
"iDisplayLength": 500,
"aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
				"language": {
					"processing": "<div></div><div></div><div></div><div></div><div></div>"

        },
        "ajax": "../JSON/gettask.php?agent=<?php echo $hello_name;?>",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "date_added" },
            { "data": "client_id",
            "render": function(data, type, full, meta) {
                return '<a href="/Life/ViewClient.php?search=' + data + '">View</a>';
            } },
            { "data": "name" },
            { "data": "assigned" },
            { "data": "Task" },
            { "data": "deadline" }

         ],
        "order": [[6, 'asc']]
    } ); $('#min, #max').keyup( function() {
        table.draw();
    } );
     
    $('#task tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } ); 
} );
		</script>
</body>
</html>

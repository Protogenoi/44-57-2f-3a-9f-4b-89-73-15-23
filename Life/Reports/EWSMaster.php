<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/ADL_PDO_CON.php');
include('../../includes/ADL_MYSQLI_CON.php');
include('../../includes/adl_features.php');

if($ffews=='0') {
    header('Location: ../../CRMmain.php?FEATURE=EWS');
}


include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;

}

$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);

    require_once(__DIR__ . '/../../classes/database_class.php');
    require_once(__DIR__ . '/../../class/login/login.php');

        $SELECT_USER_TOKEN = new UserActions($hello_name,"NoToken");
        $SELECT_USER_TOKEN->SelectToken();
        $OUT=$SELECT_USER_TOKEN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
?>
<!DOCTYPE html>
<html>
    <title>ADL | Master EWS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">    
    <link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>   
    <link rel="stylesheet" type="text/css" href="//datatables.net/release-datatables/extensions/ColVis/css/dataTables.colVis.css">
    <link rel="stylesheet" type="text/css" href="/datatables/css/jquery-ui.css">  
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />   
    <style>
        div.smallcontainer {
            margin: 0 auto;
            font: 70%/1.45em "Helvetica Neue",HelveticaNeue,Verdana,Arial,Helvetica,sans-serif;
        }
        .panel-body .btn:not(.btn-block) { width:120px;margin-bottom:10px; }
    </style>
</head>
<body>
    
<?php include('../../includes/navbar.php'); 

    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
?>
    <div class="container">
        <ul class="nav nav-pills">
            <?php if (in_array($hello_name,$Level_10_Access, true)) { ?>
            <li class="active"><a data-toggle="pill" href="#home">Archive Master</a></li>
            <?php } ?>
        </ul>
    </div>
    
    <div class="tab-content">        
        <div id="home" class="tab-pane fade in active">
            <div class="smallcontainer">                
              
                <table id="example" class="display compact" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ID</th>
                            <th>Post Code</th>
                            <th>Policy Type</th>
                            <th>Warning</th>
                            <th>Last Full Premium Paid</th>
                            <th>Net Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start Date</th>
                            <th>Off Risk Date</th>
                            <th>Reqs</th>
                            <th>Orig Status</th>
                            <th>Our Notes</th>
                            <th>Color</th>
                        </tr>
                    </thead>
                        
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Date Added</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ID</th>
                            <th>Post Code</th>
                            <th>Policy Type</th>
                            <th>Warning</th>
                            <th>Last Full Premium Paid</th>
                            <th>Net Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start Date</th>
                            <th>Off Risk Date</th>
                            <th>Reqs</th>
                            <th>Orig Status</th>
                            <th>Our Notes</th>
                            <th>Color</th>
                        </tr>
                    </tfoot>
                </table>
                <br>
                <br>
                <br>
                    
            </div>       
        </div>
    </div>
 
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
        <script src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
        
       <script type="text/javascript" language="javascript" >
                function format ( d ) {

            return '<form action="../php/EWSNoteSubmit.php?EWS=1&REDIRECT=EWSMaster" method="POST" autocomplete="off">'+'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+

                    '<tr>'+

                    '<td>Our EWS Status:'+
                    '<select class="hook_to_change_colour" name="status" onchange="" required>'+
                    '<option value="'+d.warning+'">'+d.warning+'</option>'+
                    '<option value="RE-INSTATED">RE-INSTATED</option>'+
                    '<option value="WILL CANCEL">WILL CANCEL</option>'+
                    '<option value="REDRAWN">REDRAWN</option>'+
                    '<option value="WILL REDRAW">WILL REDRAW</option>'+
                    '<option value="CANCELLED">CANCELLED</option>'+
                    '</select>'+
                    '<select class="colour_hook" name="colour" required>' +

                    '<option value="green" style="background-color:green;color:white;">Green</option>' +
                    '<option value="orange" style="background-color:orange;color:white;">Orange</option>' +
                    '<option value="purple" style="background-color:purple;color:white;">Purple</option>' +
                    '<option value="red" style="background-color:red;color:white;">Red</option>' +
                    '<option value="black" style="background-color:black;color:white;">Black</option>' +
                    '<option value="blue" style="background-color:blue;color:white;">Blue</option>' +
                    '<option value="grey" style="background-color:blue;color:white;">Grey</option>' +
                    '</select></td>'+
                    
                                        '<td><label>Closer</label><input type="text" name="policy_number" value="'+d.closer+'" disabled></td>'+
                    '<td><label>Lead Gen</label><input type="text" name="policy_number" value="'+d.lead+'" disabled></td>'+

                    '</tr>'+

            '<tr>'+

                    '<td><input type="hidden" name="client_id" value="'+d.client_id+'"></td>'+
                    '<td><input type="hidden" name="policy_number" value="'+d.policy_number+'"></td>'+

            '<td><input type="hidden" name="warning" value="'+d.warning+'"></td>'+
                    '<td><input type="hidden" name="client_name" value="'+d.client_name+'"></td>'+
                    '<td><input type="hidden" name="edited" value="<?php echo $hello_name?>"></td>'+
                    '</tr>'+

                    '<tr>'+
                    '<td><div name="BLANK_ZOVOS"> </div></td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td><textarea name="notes" id="notes" rows="15" cols="85" placeholder="Add Notes Here" required></textarea></td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td><button type="submit" class="btn btn-primary "><span class="glyphicon glyphicon-plus"></span> Add Notes</button></td>'+

                    '</tr>'+

                    '</form>';
            '</table>';
        }
 
        $(document).ready(function() {
            var table = $('#example').DataTable( {
                dom: 'C<"clear">lfrtip',
                                "fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData["color_status"] != '' )  {
                        $('td', nRow).css("color", aData["color_status"]);
                    }
                    
                     if ( aData["ews_status_status"] == "NEW" )  {
                        $('td', nRow).addClass( 'black' );
                    }
                
    },
                "response":true,
                "processing": true,
                "iDisplayLength": 5,
                "aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 2500, 3000], [5, 10, 25, 50, 100, 125, 150, 200, 2500, 3000, 2500]],
                "language": {
                    "processing": "<div></div><div></div><div></div><div></div><div></div>"

                },
                "ajax": "../../datatables/EWSData.php?EWS=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",

                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "deferRender": true,
                        "defaultContent": ''
                    },
                    { "data": "date_added"},
                    { "data": "policy_number"},
                    { "data": "client_name"},
                    { "data": "client_id",
                        "render": function(data, type, full, meta) {
                            return '<a href="/Life/ViewClient.php?search=' + data + '" target="_blank">"' + data + '"</a>';
                        } },
                    { "data": "post_code" },
                    { "data": "policy_type" },
                    { "data": "warning" },
                    { "data": "last_full_premium_paid" },
                    { "data": "net_premium" },
                    { "data": "premium_os" },
                    { "data": "clawback_due" },
                    { "data": "clawback_date" },
                    { "data": "policy_start_date" },
                    { "data": "off_risk_date" },
                    { "data": "reqs" },
                    { "data": "ews_status_status" },
                    { "data": "ournotes" },
                    { "data": "color_status" }


                ],
                "order": [[1, 'asc']]
            } );

            $('#example tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
 
                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    row.child( format(row.data()) ).show();
                    
   var me = $(this);

                    $.ajax({ url: '../php/EWSNoteGet.php?query=EWSMaster',
                        data: {
                            cid: $(this).closest('tr').next('tr').find("input[name='client_id']").val(),
                            pid: $(this).closest('tr').next('tr').find("input[name='policy_number']").val()
                        },
                        type: 'post',
                        success: function(data) {
                            me.closest('tr').next('tr').find("div[name='BLANK_ZOVOS']").html(data);
                        }
                    });
                    
                    tr.addClass('shown');
                    
                                         $('.hook_to_change_colour').change(function(){
        
                         switch ($(this).val()) {
            
                             case "RE-INSTATED":
                                 $(this).next().val('green');
                                 break;
            
                             case "WILL CANCEL":
                                 $(this).next().val('orange');
                                 break;
            
                             case "REDRAWN":
                             case "WILL REDRAW":
                                 $(this).next().val('purple');
                                 break;
            
                             case "CANCELLED":
                                 $(this).next().val('red');
                                 break;
            
            
                         }
                     });
                }
            } );
        } );
    </script>  
        <script type="text/javascript">
    $(document).ready(function() {                                                                                                    
                                                                                                        
    
        $('#LOADINGEWS').modal('show');
    })
    
    ;
    
    $(window).load(function(){
        $('#LOADINGEWS').modal('hide');
    });
</script> 
<div class="modal modal-static fade" id="LOADINGEWS" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <center><i class="fa fa-spinner fa-pulse fa-5x fa-lg"></i></center>
                    <br>
                    <h3>Loading EWS... </h3>
                </div>
            </div>
        </div>
    </div>
</div> 
</body>
</html>


<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

 include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: ../index.php?AccessDenied'); die;

}

include('../../includes/adlfunctions.php');

$MONTH= filter_input(INPUT_GET, 'MONTH', FILTER_SANITIZE_SPECIAL_CHARS);
$YEAR= filter_input(INPUT_GET, 'YEAR', FILTER_SANITIZE_SPECIAL_CHARS);
$ASSETID= filter_input(INPUT_GET, 'ASSETID', FILTER_SANITIZE_SPECIAL_CHARS);
$DEVICE= filter_input(INPUT_GET, 'DEVICE', FILTER_SANITIZE_SPECIAL_CHARS);

include('../../classes/database_class.php');
        $RETURN= filter_input(INPUT_GET, 'RETURN', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(isset($RETURN)) {
            $DATE= filter_input(INPUT_GET, 'DATE', FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
           $DATE= filter_input(INPUT_POST, 'DATE', FILTER_SANITIZE_SPECIAL_CHARS); 
        }
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Company Assets</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../bootstrap-3.3.5-dist/cosmo/bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap-3.3.5-dist/cosmo/bootstrap.css">
    <link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../styles/sweet-alert.min.css" />
    <link rel="stylesheet" href="../../styles/Notices.css" />
    <link rel="stylesheet" href="../../styles/LargeIcons.css" type="text/css" />
    <link rel="stylesheet" href="../../styles/datatables/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

</head>
<body>
    
    <?php 
    include('../../includes/navbar.php');
     
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
?> 
    
<div class="container">
    
    <div class='notice notice-default' role='alert'><h1><strong> <center>Asset Management</center></strong></h1> </div>
    <br>    
    <?php include('../php/Notifications.php'); ?>
    <br>
          <div class="row fixed-toolbar">
                <div class="col-xs-5">
                    <a href="../Main_Menu.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
                <div class="col-xs-7">
                    <div class="text-right">
                        <?php if(isset($DEVICE)) { ?>
                        <a class="btn btn-warning" data-toggle="modal" data-target="#comp_modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus-square"></i> Add Item Details</a>
                        <?php } else { ?>
                        <a class="btn btn-warning" data-toggle="modal" data-target="#AddModal" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus-square"></i> Add Item</a>
                        <?php } ?>
                        <a class="btn btn-info" href='?RETURN=Search'><i class="fa fa-search"></i> Search Inventory</a>
                    </div>
                </div>
            </div>
    <br>
    
    <?php if(isset($ASSETID)) {
        if($ASSETID>'0') {
            if(isset($DEVICE)) {
                    ?> 

<div class="modal fade" id="comp_modal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Add asset details</h4>
        </div>
        <div class="modal-body">

                <div class="row">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#Modal1">Add Item</a></li>
                    </ul>
                </div>
            
            <div class="panel">
                        <div class="panel-body">
                            
                            <?php
                            
                            switch ($DEVICE) {
                            case "Computer";
                                $EXECUTE_ID=2;
                                break;
                            case "Keyboard";
                                $EXECUTE_ID=3;
                                break;
                            case "Mouse";
                                $EXECUTE_ID=4;
                                break;
                            case "Headset";
                                $EXECUTE_ID=5;
                                break;
                            case "Hardphone";
                                $EXECUTE_ID=6;
                                break;
                            case "Network Device";
                                $EXECUTE_ID=7;
                                break;
                            case "Printer";
                                $EXECUTE_ID=8 ;
                                break;
                            case "Monitor";
                                $EXECUTE_ID=9 ;
                                break;
                            default:
                                $EXECUTE_ID=0;
                                
                            }
                            
                            ?>
                            
                            <form class="form" action="../php/Assets.php?EXECUTE=<?php echo $EXECUTE_ID; ?>&ASSETID=<?php echo $ASSETID; ?>" method="POST" id="ASSETform">
                            
                                <div class="tab-content">
                                <div id="Modal1" class="tab-pane fade in active"> 
            
            <div class="col-lg-12 col-md-12">
                
                                                    <div class="row">
                 <?php if($DEVICE=='Computer') { ?>                       
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">OS</label>
                                                <input type="text" name="OS" class="form-control" value="" placeholder="Windows/Linux/MAC">
                                            </div>
                                        </div>
    
                                                        
                             <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">MAC</label>
                                                <input type="text" name="MAC" class="form-control" value="" placeholder="Ethernet Address">
                                            </div>
                                        </div>  
                                                        
                                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">RAM</label>
                                                <input type="text" name="RAM" class="form-control" value="" placeholder="Ethernet Address">
                                            </div>
                                        </div>
                                                        
                                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Hostname</label>
                                                <input type="text" name="HOSTNAME" class="form-control" value="" placeholder="BIOS Name">
                                            </div>
                                        </div>
                                                        
                                                        <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Notes</label>
                                <textarea name="NOTES" class="form-control" rows="5" placeholder="Any other details"></textarea>
                            </div> 
                        </div>
                    </div>      
                                 <?php }
                                 
                                 if($DEVICE=='Keyboard' || $DEVICE=='Mouse') { ?>   
                                                    <div class="row">    
                                                    <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Connection Type</label>
                                                <select name="CONNECTION" class="form-control" required>
                                                    <option value=""></option>
                                                    <option value="USB">USB</option>
                                                    <option value="Serial">Serial</option>
                                                </select>
                                            </div>
                                        </div>       
                                                    </div>             
                                                        
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Notes</label>
                                <textarea name="NOTES" class="form-control" rows="5" placeholder="Any other details"></textarea>
                            </div> 
                        </div>
                    </div>                                                           
                    
                                 <?php }   if($DEVICE=='Headset' || $DEVICE=='Monitor') { ?>   
                                      
            
                                                        
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Notes</label>
                                <textarea name="NOTES" class="form-control" rows="5" placeholder="Any other details"></textarea>
                            </div> 
                        </div>
                    </div>                                                           
                    
                                 <?php } if($DEVICE=='Hardphone')  { ?>   
                              
                                                        <div class="row">
                             <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">MAC</label>
                                                <input type="text" name="MAC" class="form-control" value="" placeholder="Ethernet Address">
                                            </div>
                                        </div>
                                                        </div>
                                                        
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Notes</label>
                                <textarea name="NOTES" class="form-control" rows="5" placeholder="Any other details (condition/fault reason)"></textarea>
                            </div> 
                        </div>
                    </div>                                                           
                    
                                 <?php } if($DEVICE=='Network Device' || $DEVICE=='Printer') { ?>                       
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">IP</label>
                                                <input type="text" name="IP" class="form-control" value="" placeholder="192.168.1.1">
                                            </div>
                                        </div>
    
                                                        
                             <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">MAC</label>
                                                <input type="text" name="MAC" class="form-control" value="" placeholder="Ethernet Address">
                                            </div>
                                        </div>  
                                                                                                                
                                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Hostname</label>
                                                <input type="text" name="HOSTNAME" class="form-control" value="" placeholder="Hostname">
                                            </div>
                                        </div>
                                                        
                                                        <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Notes</label>
                                <textarea name="NOTES" class="form-control" rows="5" placeholder="Any other details"></textarea>
                            </div> 
                        </div>
                    </div>      
                                 <?php } ?>                                                             
                                                        
                                    </div>
               </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
          
          <div class="modal-footer">
              <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Save</button>
                  
<script>
        document.querySelector('#ASSETform').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Add Asset details?",
                text: "Confirm to add asset details to inventory!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Asset updated!',
                        text: 'Asset details Updated!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No changes were made", "error");
                }
            });
        });

</script>
          </form>
                            
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
          </div>
      </div>
    </div>
</div>  
    <script type="text/javascript">
    $(window).load(function(){
        $('#comp_modal').modal('show');
    });
</script> 
<?php
               

            }
            
      
            
        }
    }
    
    ?>
    
</div>
  
<div class="modal fade" id="AddModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Add Item to inventory stock</h4>
        </div>
        <div class="modal-body">

                <div class="row">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#Modal1">Add Item</a></li>
                    </ul>
                </div>
            
            <div class="panel">
                        <div class="panel-body">
                            <form class="form" action="../php/Assets.php?EXECUTE=1" method="POST" id="Addform">
                            <div class="tab-content">
                                <div id="Modal1" class="tab-pane fade in active"> 
            
            <div class="col-lg-12 col-md-12">
                
                                                    <div class="row">
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Asset Name</label>
                                                <input type="text" name="ASSET_NAME" class="form-control" value="" placeholder="Computer DELL XPS">
                                            </div>
                                        </div>
    
                                                        
                             <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Manufacturer</label>
                                                <input type="text" name="MANUFACTURER" class="form-control" value="" placeholder="Dell/Intel">
                                            </div>
                                        </div>                                              
                                    
                                    </div>
                
                <div class="row">
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Device</label>
                            <select name="DEVICE" class="form-control">
                                <option value=""></option>
                                <option value="Computer">Computer</option>
                                <option value="Keyboard">Keyboard</option>
                                <option value="Mouse">Mouse</option>
                                <option value="Headset">Headset</option>
                                <option value="Hardphone">Hardphone</option>
                                <option value="Network Device">Network Device</option>
                                <option value="Printer">Printer</option>
                                <option value="Monitor">Monitor</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
          
          <div class="modal-footer">
              <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Save</button>
<script>
        document.querySelector('#Addform').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Add Asset?",
                text: "Confirm to add asset to inventory!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Asset added!',
                        text: 'Inventory Updated!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No changes were made", "error");
                }
            });
        });

</script>
          </form>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
          </div>
      </div>
    </div>
</div>
     
<script type="text/javascript" language="javascript" src="../../js/sweet-alert.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>

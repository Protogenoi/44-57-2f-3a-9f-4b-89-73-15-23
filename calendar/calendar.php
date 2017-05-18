<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adlfunctions.php'); 
include('../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Calendar</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link href='fullcalendar-2.4.0/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar-2.4.0/fullcalendar.print.css' rel='stylesheet' media='print' />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/styles/sweet-alert.min.css" />
    <link rel="stylesheet" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="../clockpicker-gh-pages/dist/jquery-clockpicker.min.css">
    <link rel="stylesheet" type="text/css" href="../clockpicker-gh-pages/assets/css/github.min.css">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/summernote-master/dist/summernote.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<style>
     .clockpicker-popover {
    z-index: 999999;
}
 #calendar {
  width: 700px;
  margin: 0 auto;
  }
.ui-datepicker { 
    z-index:1151 !important; 
}
</style>
</head>
<body>

<?php include('../includes/navbar.php'); 

if ($ffcalendar=='0') {
        
        header('Location: /CRMmain.php'); die;
    }

?>
    
    <div class="container">
        
        <?php
        
         $callback= filter_input(INPUT_GET, 'callback', FILTER_SANITIZE_SPECIAL_CHARS);
                                                
        
        if(isset($callback)) {            
            $callbackid= filter_input(INPUT_GET, 'callbackid', FILTER_SANITIZE_NUMBER_INT);            
            if($callback=='complete') {                
                echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o fa-lg\"></i> Success:</strong> Callback $callbackcompletedid completed!</div>";
                
            }
            
            if($callback=='incomplete') {                
                echo "<div class=\"notice notice-warning\" role=\"alert\"><strong><i class=\"fa fa-check fa-lg\"></i> Success:</strong> Callback set to incomplete!</div>";
                
            }
            
        }
        
        ?>
        
    </div>
    <br>
<div class="container">
    <div class="col-md-12">
    <div class="col-md-8">
<div id='calendar'></div>

    </div>
        
    <div class="col-md-4">
    
                        <?php
                  if(isset($fflife)) { 
                      if($fflife=='1') {
                    
                    $query = $pdo->prepare("SELECT CONCAT(callback_time, ' - ', callback_date) AS calltimeid, callback_date, callback_time, reminder, CONCAT(callback_date, ' - ',callback_time)AS ordersort, client_id, id, client_name, notes, complete from scheduled_callbacks WHERE assign=:hello ORDER BY ordersort ASC");
                    $query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
                  }
                  }


                    
                    $query->execute();
                    if ($query->rowCount()>0) { 
                        $i=0;
                        ?>
        
                        <table class="table">
                    <thead>
                        <tr>
                            <th colspan='2'><h3><span class="label label-info">Call backs</span></h3></th>
                        </tr>
                    <th>Client</th>
                    <th>Callback</th>
                    <th></th>
                    </thead>
                
                <?php
                        while ($calllist=$query->fetch(PDO::FETCH_ASSOC)){
                           $i++;
                            $callbackid = $calllist['id'];
                            $search = $calllist['client_id'];
                            $NAME=$calllist['client_name'];
                            $TIME=$calllist['calltimeid'];
                            $NOTES=html_entity_decode($calllist['notes']);
                            $REMINDER=$calllist['reminder'];
                            $CB_DATE=$calllist['callback_date'];
                            $CB_TIME=$calllist['callback_time'];

                            echo '<tr>';
                            
                            if($fflife=='1') {
                            
                            echo "<td class='text-left'><a href='/Life/ViewClient.php?search=$search'>".$calllist['client_name']."</a></td>";
                            
                            }
  
                            
                            echo "<td class='text-left'>".$calllist['calltimeid']."</td>"; 
                                          
                         if($fflife=='1') {
                            
                          echo "<td class='text-left'><a data-toggle='modal' data-target='#myModal$i' class=\"btn btn-info btn-xs\"><i class='fa fa-cogs'></i> Options</a></td>";
                        }
                        
                            echo "</tr>"; ?>
                
                <div id='myModal<?php echo $i;?>' class='modal fade' role='dialog'>
                    <div class='modal-dialog modal-lg'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                <h4 class='modal-title'><?php echo "$NAME ($TIME | Reminder at $REMINDER)"; ?></h4>
                            </div>
                            <div class='modal-body'>
        
                        <form class="form-horizontal" action='php/Callbacks.php?search=<?php echo "$search&callbackid=$callbackid&cb=c"; ?>' method='POST'>                
                    <fieldset>
                        
                        <div class='container'>
                            <div class='row'>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <select id='getcallback_client' name='callbackclient' class='form-control'>
                                            <option value='<?php echo $NAME;?>'><?php echo $NAME;?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class='row'>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <select id='assign' name='assign' class='form-control'>
                                            <option value='<?php echo $hello_name;?>'><?php echo $hello_name;?></option>
                                            
                                            <?php
                                            
                                            try {
                                            
                                            $calluser = $pdo->prepare("SELECT login, real_name from users where extra_info ='User'");
                                            
                                            $calluser->execute()or die(print_r($calluser->errorInfo(), true));
                                            if ($calluser->rowCount()>0) {
                                                while ($row=$calluser->fetch(PDO::FETCH_ASSOC)){
                                           
                                            
                                            ?>
                                            
                                            <option value='<?php echo $row['login'];?>'><?php echo $row['real_name'];?></option>
                                            
                                            <?php
                                            
                                                }
                                                
                                                }
                                                  }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                                                ?>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class='col-md-4'>
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control" id="callback_date" name="callbackdate" placeholder="YYYY-MM-DD" value="<?php if(isset($CB_DATE)) { echo $CB_DATE; } ?>" required />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>                       
                            
                            <div class="row">
                                <div class='col-md-4'>
                                    <div class="form-group">
                                        <div class='input-group date clockpicker'>
                                            <input type='text' class="form-control" id="clockpicker" name="callbacktime" placeholder="24 Hour Format" value="<?php if(isset($CB_TIME)) { echo $CB_TIME; } ?>" required  />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class='col-md-4'>
                                    <div class="form-group">
                                        <select id="callreminder" name="callreminder" class="form-control" required>
                                            <option value="">Reminder</option>
                                            <option value="-5 minutes">5mins</option>
                                            <option value="-10 minutes">10mins</option>
                                            <option value="-15 minutes">15mins</option>
                                            <option value="-20 minutes">20mins</option>
                                        </select>
                                    </div>
                                </div>
                            </div>   
                            
                            <div class="row">
                                <div class='col-md-8'>
                                    <div class="form-group"> 
                                        <textarea class="form-control summernote" id="textarea" name="callbacknotes" placeholder="Call back notes"><?php if(isset($NOTES)) { echo $NOTES; } ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        
                        <div class="btn-group">
                        <button class="btn btn-primary"><i class='fa  fa-check-circle-o'></i> Save</button>
                        <a href='/php/AddCallback.php?search=<?php echo "$search&callbackid=$callbackid&cb=y"; ?>' class="btn btn-success"><i class='fa fa-check'></i> Complete</a>
                        <a href='/php/AddCallback.php?search=<?php echo "$search&callbackid=$callbackid&cb=n"; ?>' class="btn btn-warning"><i class='fa fa-times'></i> In-complete</a>
                        </div>
                    </fieldset>
                </form> 
        
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
      </div>
    </div>

  </div>
</div>
                <?php } ?>
                  </table>   
                      
                      <?php } 
                      
                      else {
                          echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No call backs found</div>";
                            
                        }
                        
                        ?>
    
    </div>
    </div>
</div>
    
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
<script src='fullcalendar-2.4.0/moment.js'></script>
<script src='fullcalendar-2.4.0/lib/jquery.min.js'></script>
<script src='fullcalendar-2.4.0/fullcalendar.min.js'></script>
<script>
 $(document).ready(function() {
  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();

  var calendar = $('#calendar').fullCalendar({
   editable: true,
   header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
   },
   
   events: "events.php",

   eventRender: function(event, element, view) {
    if (event.allDay === 'true') {
     event.allDay = true;
    } else {
     event.allDay = false;
    }
   },
   selectable: true,
   selectHelper: true,
   select: function(start, end, allDay) {
   var title = prompt('Event Title:');
   var url = prompt('Type Event url, if exits:');
   if (title) {
   var start = $.fullCalendar.moment(start).format();
   var end = $.fullCalendar.moment(end).format();
   $.ajax({
   url: 'add_events.php',
   data: 'title='+ title+'&start='+ start +'&end='+ end +'&url='+ url ,
   type: "POST",
   success: function(json) {
   alert('Added Successfully');
   }
   });
   calendar.fullCalendar('renderEvent',
   {
   title: title,
   start: start,
   end: end,
   allDay: allDay
   },
   true
   );
   }
   calendar.fullCalendar('unselect');
   },
   
   editable: true,
   eventDrop: function(event, delta) {
   var start = $.fullCalendar.moment(event.start).format();
   var end = $.fullCalendar.moment(event.end).format();
   $.ajax({
   url: 'update_events.php',
   data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
   type: "POST",
   success: function(json) {
    alert("Updated Successfully");
   }
   });
   },
   eventResize: function(event) {
   var start = $.fullCalendar.moment(event.start).format();
   var end = $.fullCalendar.moment(event.end).format();
   $.ajax({
    url: 'update_events.php',
    data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
    type: "POST",
    success: function(json) {
     alert("Updated Successfully");
    }
   });

},
eventClick: function(event) {
var decision = confirm("Delete callback?"); 
if (decision) {
$.ajax({
type: "POST",
url: "delete_events.php",

data: "&id=" + event.id
});
$('#calendar2').fullCalendar('removeEvents', event.id);

} else {
}
}
   
  });
  
 });

</script>    
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="/clockpicker-gh-pages/dist/jquery-clockpicker.min.js"></script>
<script type="text/javascript">
    $('.clockpicker').clockpicker();
$('.clockpicker').clockpicker()
	.find('input').change(function(){
	});

</script>
<script type="text/javascript" src="/clockpicker-gh-pages/assets/js/highlight.min.js"></script>
<script>
  $(function() {
    $( "#callback_date" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true
        });
  });
</script>   
<script type="text/javascript" src="/summernote-master/dist/summernote.js"></script>

  <script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200
      });


    });
  </script>
</body>
</html>

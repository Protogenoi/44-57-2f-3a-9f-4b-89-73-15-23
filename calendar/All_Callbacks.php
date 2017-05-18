<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 

$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 8); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adlfunctions.php'); 
include('../includes/Access_Levels.php'); 

if (!in_array($hello_name,$Level_8_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}

?>
<!DOCTYPE html>
<html lang="en">
<title>Active Callbacks</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link href='fullcalendar-2.4.0/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar-2.4.0/fullcalendar.print.css' rel='stylesheet' media='print' />
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src='fullcalendar-2.4.0/moment.js'></script>
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />

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
   
   // Convert the allDay from string to boolean
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
   true // make the event "stick"
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
//eventClick: function(event) {
//var decision = confirm("Delete event?"); 
//if (decision) {
//$.ajax({
//type: "POST",
//url: "delete_events.php",

//data: "&id=" + event.id
//});
//$('#calendar2').fullCalendar('removeEvents', event.id);

//} else {
//}
//}
   
  });
  
 });

</script>
<style>

 body {
  text-align: center;
  font-size: 14px;
  font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;

  }


 #calendar {
  width: 900px;
  margin: 0 auto;
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

<div id='calendar'></div>


<div class="container">
    
    
                        <?php
                  if(isset($fflife)) { 
                      if($fflife=='1') {
                    
                    $query = $pdo->prepare("SELECT CONCAT(callback_time, ' - ', callback_date) AS calltimeid, CONCAT(callback_date, ' - ',callback_time)AS ordersort, client_id, id, client_name, notes, complete from scheduled_callbacks WHERE complete ='N' ORDER BY ordersort DESC");
                  }
                  }
                    ?>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan='2'><h3><span class="label label-info">Active Call backs</span></h3></th>
                        </tr>
                    <th>Client</th>
                    <th>Callback Time</th>
                    <th>Notes</th>
                    <th colspan="2">Callback Status</th>
                </thead>
                    
                    <?php
                    
                    $query->execute();
                    if ($query->rowCount()>0) {
                        while ($calllist=$query->fetch(PDO::FETCH_ASSOC)){
                            
                            $callbackid = $calllist['id'];
                            $search = $calllist['client_id'];
                            
                            echo '<tr>';
                            
                            if($fflife=='1') {
                            
                            echo "<td class='text-left'><a href='/Life/ViewClient.php?search=$search' target='_blank'>".$calllist['client_name']."</a></td>";
                            
                            }
                            

                            echo "<td class='text-left'>".$calllist['calltimeid']."</td>"; 
                            echo "<td class='text-left'>".$calllist['notes']."</td>"; 
                            
                         if($fflife=='1') {
                            
                            echo "<td class='text-left'><a href='/php/AddCallback.php?search=$search&callbackid=$callbackid&cb=y' class=\"btn btn-success btn-xs\"><i class='fa fa-check'></i> Complete</a></td>";
                            echo "<td class='text-left'><a href='/php/AddCallback.php?search=$search&callbackid=$callbackid&cb=n' class=\"btn btn-warning btn-xs\"><i class='fa fa-times'></i> In-complete</a></td>";
                            
                        }
                        
                            echo "</tr>";
                            
                        }
                        
                        }
                        
                        else {
                            echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No call backs found</div>";
                            
                        }
                        
                        ?>
                        
                        </table>
                        
                        
    
    
</div>

</body>
</html>

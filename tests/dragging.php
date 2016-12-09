<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
	$test_access_level->log_out();
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dragging</title>
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/cus-jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/jquery.sortable.min.js"></script>
        <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
        <style>ul.source, ul.target {
  min-height: 50px;
  margin: 0px 25px 10px 0px;
  padding: 2px;
  border-width: 1px;
  border-style: solid;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  list-style-type: none;
  list-style-position: inside;
}
ul.source {
  border-color: #f8e0b1;
}
ul.target {
  border-color: #add38d;
}
.source li, .target li {
  margin: 5px;
  padding: 5px;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
}
.source li {
  background-color: #fcf8e3;
  border: 1px solid #fbeed5;
  color: #c09853;
}
.target li {
  background-color: #ebf5e6;
  border: 1px solid #d6e9c6;
  color: #468847;
}
.sortable-dragging {
  border-color: #ccc !important;
  background-color: #fafafa !important;
  color: #bbb !important;
}
.sortable-placeholder {
  height: 40px;
}
.source .sortable-placeholder {
  border: 2px dashed #f8e0b1 !important;
  background-color: #fefcf5 !important;
}
.target .sortable-placeholder {
  border: 2px dashed #add38d !important;
  background-color: #f6fbf4 !important;</style>
    </head>
    <body>
        
        <?php 
        include('includes/navbar.php');
        include('includes/PDOcon.php');
        ?>
        
<div class="container">
    
<div class="row">
        <div id="step1" class="col-sm-3">
        <ul class="source connected">
            
<?php $query = $pdo->prepare("select id, login from users");
$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
    echo "<li id='".$result['id']."'>".$result['login']."</li>";
}
}
  ?>
        </ul>
        </div>

    
    
    
        <div id="step2" class="col-sm-3">
        <ul class="target connected">
            <li>boo</li>
        </ul>
        </div>
    
            <div id="step3" class="col-sm-3">
        <ul class="target connected2">
            <li>boo</li>
        </ul>
        </div>
                <div id="step4" class="col-sm-3">
        <ul class="target connected3">
            <li>boo</li>
        </ul>
        </div>
</div>


</div>
        
    <script type="text/javascript">
      $(function () {
        $(".source, .target").sortable({
          connectWith: ".connected"
         }).bind("sortupdate", function() {
    updateValues();
  });
});
      
      function updateValues() {
        var items = [];
        $("ul.target").children().each(function() {
          var item = {manufacturer: $(this).text()};
          items.push(item);
        });
        var jsonData = JSON.stringify(items);						
        $.ajax ({
          url: "dnd.xsp/setfavourites",
          type: "PUT",
          data: jsonData,
          dataType: "json",
          contentType: "application/json; charset=utf-8",
          success: function(){},
          error: function(){}
        });
      };
    </script>
    
    </body>
</html>

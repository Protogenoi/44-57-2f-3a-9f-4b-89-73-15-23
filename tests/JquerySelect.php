<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
    </head>
    <body>

  
<form method="post" id="myForm">
<input name="foo" value="bar">
<input name="foo1" value="bar1">
</form>

<script>
var form = $("#myForm"); // or $("form"), or any selector matching an element containing your input fields
var foo = $("[name='foo']", form).val();
var foo1 = $("[name='foo1']", form).val();
</script>

     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script> 
    </body>
</html>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 

class Admin_user extends Access_user {
	
	var $user_found = false;
	var $user_id;
	var $user_name;
	var $old_user_email;
	var $user_access_level;
	var $activation;

	function get_userdata($for_user, $type = "login") {
		if ($type == "login") {
			$sql = sprintf("SELECT id, login, email, access_level, active FROM %s WHERE login = '%s'", $this->table_name, trim($for_user));
		} else {
			$sql = sprintf("SELECT id, login, email, access_level, active FROM %s WHERE id = %d", $this->table_name, intval($for_user));
		}
		$result = mysql_query($sql);
		if (mysql_num_rows($result) == 1) {
			$obj = mysql_fetch_object($result);
			$this->user_id = $obj->id;
			$this->user_name = $obj->login;
			$this->old_user_email = $obj->email;
			$this->user_access_level = $obj->access_level;
			$this->activation = $obj->active;
			if ($this->user_name != $_SESSION['user']) {
				$this->user_found = true;
			} else {
				$this->user_found = false;
				$this->the_msg = "It's not allowed to change your own data!";
			}
			mysql_free_result($result);
		} else {
			$this->the_msg = "Sorry, no data for this loginname!";
		}	
	}
	function update_user_by_admin($new_level, $user_id, $def_pass, $new_email, $active, $confirmation = "no") {
		$this->user_found = true;
		$this->user_access_level = $new_level;
		if ($def_pass != "" && strlen($def_pass) < 4) {
			$this->the_msg = "Password is to short use the min. of 4 chars.";
		} else {
			if ($this->check_email($new_email)) {
				$sql = "UPDATE %s SET access_level = %d, email = '%s', active = '%s'";
				$sql .= ($def_pass != "") ? sprintf(", pw = '%s'", md5($def_pass)) : "";
				$sql .= " WHERE id = %d";
				$sql_compl = sprintf($sql, $this->table_name, $new_level, $new_email, $active, $user_id);
				if (mysql_query($sql_compl)) {
					$this->the_msg = "Data is modified for user with id#<b>".$user_id."</b>";
					if ($confirmation == "yes") {
						if ($this->send_confirmation($user_id)) {
							$this->the_msg .= "...a confirmation mail is send to the user.";
						} else {
							$this->the_msg .= "...ERROR no confirmation mail is send to the user.";
						}
					}
				} else {
					$this->the_msg = "Database error, please try again!";
				}
			} else {
				$this->the_msg = "The e-mail address is invalid!";
			}
		}
	}
	function access_level_menu($curr_level, $element_name = "level") {
		$menu = "<select name=\"".$element_name."\">\n";
		for ($i = MIN_ACCESS_LEVEL; $i <= MAX_ACCESS_LEVEL; $i++) {
			$menu .= "  <option value=\"".$i."\"";
			$menu .= ($curr_level == $i) ? " selected>" : ">";
			$menu .= $i."</option>\n";
		}
		$menu .= "</select>\n";
		return $menu;
	}
	// modified in version 1.97
	function activation_switch($formelement = "activation") {
		$radio_group = "<label for=\"".$formelement."\">Active?</label>\n";
		$labels = array("y"=>"yes", "n"=>"no", "b"=>"blocked");
		foreach ($labels as $key => $val) {
			$radio_group .= " <input name=\"".$formelement."\" type=\"radio\" value=\"".$key."\" ";
			$radio_group .= ($this->activation == $key) ? "checked=\"checked\" />\n" : "/>\n";
			$radio_group .= $val;
		}
		return $radio_group;        
	}
}
$admin_update = new Admin_user;
$admin_update->access_page($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], DEFAULT_ADMIN_LEVEL); // check the level inside the config file

if (isset($_POST['Submit'])) {
	if ($_POST['Submit'] == "Update") {
		$conf_str = (isset($_POST['send_confirmation'])) ? $_POST['send_confirmation'] : ""; // the checkbox value to send a confirmation mail 
		$admin_update->update_user_by_admin($_POST['level'], $_POST['user_id'], $_POST['password'], $_POST['email'], $_POST['activation'], $conf_str);
		$admin_update->get_userdata($_POST['login_name']); // this is needed to get the modified data after update
	} elseif ($_POST['Submit'] == "Search") {
		$admin_update->get_userdata($_POST['login_name']);
	}
} elseif (isset($_GET['login_id']) && intval($_GET['login_id']) > 0) {
		$admin_update->get_userdata($_GET['login_id'], "is_id");
} 
$error = $admin_update->the_msg; // error message

?>
<!DOCTYPE html>
<html lang="en">
<title>User Accounts</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>




		
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
		<link rel="stylesheet" type="text/css" href="../datatables/css/layoutcrm.css"/>
		<link rel="stylesheet" type="text/css" href="../datatables/css/dataTables.responsive.css">
		<link rel="stylesheet" type="text/css" href="../datatables/css/dataTables.customLoader.walker.css">
		<link rel="stylesheet" type="text/css" href="../datatables/css/jquery-ui.css">
  
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<script type="text/javascript" language="javascript" src="../js/tab.js"></script>		
<script type="text/javascript" language="javascript" src="../datatables/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" language="javascript" src="../datatables/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../datatables/js/jquery.dataTables.js"></script>



<script type="text/javascript" language="javascript" >
/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>User ID:</td>'+
            '<td>'+d.id+' </td>'+
        '</tr>'+
                '<tr>'+
            '<td>Password:</td>'+
            '<td>'+d.pw+' </td>'+
        '</tr>'+
       
    '</table>';
}
 
$(document).ready(function() {
    var table = $('#users').DataTable( {

"response":true,
					"processing": true,
"iDisplayLength": 500,
"aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
				"language": {
					"processing": "<div></div><div></div><div></div><div></div><div></div>"

        },
        "ajax": "/datatables/getusers.php",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "id" },
            { "data": "login"},
            { "data": "real_name" },
            { "data": "access_level" },
            { "data": "active" },
            { "data": "extra_info" },
        ],
        "order": [[1, 'asc']]
    } );
     
    // Add event listener for opening and closing details
    $('#users tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
} );
		</script>
		<style>
td.details-control {
    background: url('http://datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('http://datatables.net/examples/resources/details_close.png') no-repeat center center;
}
		</style>
<style type="text/css">
<!--
label {
	display: block;
	float: left;
	width: 140px;
}
-->
</style>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#999;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;border-top-width:1px;border-bottom-width:1px;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#999;color:#fff;background-color:#26ADE4;border-top-width:1px;border-bottom-width:1px;}
.tg .tg-e3zv{font-weight:bold}
.tg .tg-hgcj{font-weight:bold;text-align:center}
.tg .tg-0rnh{background-color:#D2E4FC;font-weight:bold;text-align:center}
.tg .tg-vn4c{background-color:#D2E4FC}
</style>
</head>
<body>

<?php include('../includes/navbar.php'); ?>

<div class="container">
<br>
<div class="panel panel-primary">

    <div class="panel-heading">
<h3 class="panel-title">Edit users</h3>
</div>
<div class="panel-body">


<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <?php if ($admin_update->user_found) { ?>
<p>Use this form to change the access level or change users password.</p>


<p>
  <label for="login">User name :</label>
  <b><?php echo $admin_update->user_name; ?></b>
</p>


<p>
  <label for="level">Access level</label>
  <?php echo $admin_update->access_level_menu($admin_update->user_access_level); ?>
</p>


<p>
  <label for="password">Password:</label>
  <input type="password" name="password" size="4" value="<?php echo (isset($_POST['password'])) ? $_POST['password'] : ""; ?>">
  (min. 4 chars.) 
</p>


<p>
  <label for="email">E-mail:</label>
  <input type="text" name="email" size="25" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : $admin_update->old_user_email; ?>">
</p>
  

<p>
  <?php echo $admin_update->activation_switch(); ?>
  <input type="hidden" name="user_id" value="<?php echo (isset($_POST['user_id'])) ? $_POST['user_id'] : $admin_update->user_id; ?>">
  <input type="hidden" name="login_name" value="<?php echo $admin_update->user_name; ?>">
</p>


<p>
  <input type="submit" name="Submit" value="Update">
</p>

  <p style="margin-top:50px;"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Search for another user...</a></p>
  <?php } else { ?>
<br>
<br>

  <?php // the next element name (login_name) is used inside the class don't use a different name ?>
  <input type="text" name="login_name" placeholder="Enter username" value="<?php echo (isset($_POST['login_name'])) ? $_POST['login_name'] : ""; ?>">

<button type="submit" name="Submit" value="Search" class="btn btn-info"><span class="glyphicon glyphicon-search"></span> Search</button>
  <?php } // end if / else show update search form ?>
</form>
<p><b><?php echo (isset($error)) ? $error : "&nbsp;"; ?></b></p>
<p>&nbsp;</p>


<br>
    <table id="users" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Login</th>
                <th>Real Name</th>
                <th>Access Level</th>
                <th>Active</th>
                <th>Role</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Login</th>
                <th>Real Name</th>
                <th>Access Level</th>
                <th>Active</th>
                <th>Role</th>
            </tr>
        </tfoot>
    </table>
</div>
</div>
</div>
</body>
</html>

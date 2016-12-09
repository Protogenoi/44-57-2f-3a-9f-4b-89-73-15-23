<!DOCTYPE html>
<html lang="en">
<title>The Review Bureau | Search Clients</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="styles/layout.css" type="text/css" />
<!--SCROLL UP-->
<script src="js/jquery-1.4.min.js"></script>
<script src="js/jquery.pjScrollUp.min.js"></script>
<script>
$(function() {
    $(document).pjScrollUp({
        offset: 210,
        duration: 850,
        aTitle: "Scroll Up",
        imgAlt: "Back to top",
        imgSrc: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAYAAACOEfKtAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAN1wAADdcBQiibeAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAVPSURBVHic7Z3dbxRVFMB/ZylRaipYsQo8FEkIGx76ggHfFGliGx98kDZqMOJ/ZpRoAuGBmFiQLSVV0lB5sSakpgapAYm1qR+NYDT0+HBv93vne+7MLPNL9qHdmTvn/nJ3Z+6ZO2dFVckKEdkFjABDHi+ATY/Xmqo+cht5A3EtUER2A0eAKnAQqMRscgu4CywDP6jqnzHbC4UTgSLyIkZYFdiX8uF+wchcVtW1lI+VnkAREeAocBLYm8pB/FkH5oDbmlJHUxEoIi8D48CBxBuPxn2gpqo/Jd1wogLtR3UcOJxYo8myghH5a1INJiJQRJ4FTgFjgMRuMF0UWAJmVfWvuI3FFigiB4FpYDBuMI55CJxX1btxGoklUEReASaBHXGCyJDHwIyq3oraQCSBIlIBJoDjUQ+cMxaBy6q6FXbH0ALt7GEKOBT2YDnnDnAh7KwmlEARGQbOAMPhYisMG8A5Vd0IukPgaZQdef0sD0zfzti+BiKQQPudN0V/y9tmGJiyffYl6AicoP++87w4hOmzL74C7aVKv5xtw3Dc9t0TT4H2InkyoYCKyKR10JOeAu30bJriXiQnwQ5g2rroitcIPEXxpmdpMIhx0ZWuAm1WZSytiArImHXSQa8ROE7+syouEYyTDjoE2mRoXvN5WXLYummhRaBNw3c1XQLAuHVUp30EHiU/afg8cgDjqE67wJPuYiksLY7qAu1ZJqu7Z0Vib/MZuXkEVjMIpqjUXZUCo9Eq0C63SHvFQD+xzzqrj8By9IWnCjDQ/EfO+A2zLONnTHxvkK+5eRW4OWDT16NZR9PG98AXqvqv/fuWiPwIvAu8lF1YLYyKyK4KZn1e3CVmSbKgqheb5AGgqn8AH2PWueSBCjBSobGIMQ/Mq+qVXm+q6j/Ap5glbHlgKE8Ca6p6zW+jJokP0g/Jl9wIvKKq3wTd2N78/gRzosmSXAi8qqoLYXeyEj8D/k4+pMBkLvCaqt6IurOq/g58DvyXXEihyFTgdVWd99tIRJ7yel9V7wEXMYvNXZOZwHlVve63kYi8BnwoIju9tlPVZeASZvGkS4ayuP67EeRsKyLHMLm3/cDp9kxwO6r6HfBlMiEGp4J5WMUVC6p61W8jEakCbzX96wgBllqo6rfAbPTwQrPpUuA94Cu/jURkFDhN5+zohIi86re/qn6NWevnAqcC5/ye1bCZ3vdoJDnaedOOTj98T04J4VSg5/RLRPZg1h8+7bUZ8I6I+N34cjVLcSrQax3OIPABwa4IdgLvi8hzPtu4wKnArksjrIizwPMh2noGOGuXHHdjf7jQIrM5gDuBEyKyAKxhnmHbg8lDvk60ROlu4CMRuQmsYvrxgn2dSCLgAGwOYDq0Rfo5wRHg7YTbHCK7lRRbwFrFTspXMwqiyKyq6qPtUbecaSjFZBkaH9tSYHgaAu1j8nnI8BaFB9ulBZpPHOUoDE7dVSkwGp0C7VPc65mEUyzWm594b7/2m3McTBFpcdQu8Db5uXGdR+5jHNVpEWjTTTWXERWMWntKrmP6ZkuDrDgLqTisdCub0mv+W8P9DZo80/OT2VWgPcsspRlRwVjqVWvGKwMziykN8qTzEI8bVT0F2qI05zGlQZ5UHmNqy/Qs0OOZA7RFaWYSDqpIzPgV5vFNotqiNItJRVQgFoMU5Amahb6Mu3uteeAOps++BBJoK/pcwNRV6Xc2MAV4Ai1WCnwfxKb+z9HfErcL7wSuXlSWfmqQfumn+k5l8bE6Zfm7LMrftTRQFmAsS4DGoSxCG5OyDHJMykLcMSlLwcek/DGCmDgX2HLwPvg5jP8BZQUTNqeQ8kYAAAAASUVORK5CYII=",
        selector: "my-id",
        easing: "linear",
        complete: function () {
            if (window.console && window.console.log) {
                console.log("complete!");
            }
        }
    });
});
</script>
</head>
<body id="top">
<div class="wrapper col1">

<!-- ####################################################################################################### -->
<?php include('includes/nav.php'); ?>
<!-- ####################################################################################################### -->

<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
?>

<div class="wrapper col4">
  <div class="container">
    <div class="content">

<?php if (login_check($mysqli) == true) : ?>

<?php
ob_start();
echo $_SESSION['username'];
$auditorStr = ob_get_contents();
ob_end_clean();

?>


<fieldset>

<p>Client Search</p>
<form name="form" method="POST" action="ViewClient.php" autocomplete="off">
<label for="edit_id">Enter the ID of Call Audit to edit:  <input type="text" name="search"> 


<?php
ob_start();
echo $_SESSION['username'];
$auditorStr = ob_get_contents();
ob_end_clean();

?>

<!--<?php echo $auditorStr ?> -->

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $datefrom = $_POST['datefrom'];
	$dateto = $_POST['dateto'];
	$searchpol = $_POST['searchpol'];
}
?>
</fieldset>





<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$servername = "localhost";
$username = "root";
$password = "Cerberus2^n";
$dbname = "secure_login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT submitted_date, client_id, first_name, last_name, post_code, email from client_details WHERE date_submitted between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) or date_edited between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) ORDER BY date_submitted DESC";

$result = $conn->query($sql);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo "<table border='1' align=\"center\" cellspacing=\"5\">";

echo "  <thead>
	<tr>
	<th colspan= 15>Recently Added Clients</th>
	</tr>
    	<tr>
	<th>ID</th>
	<th>Date Added</th>
	<th>Client Name</th>
	<th>DOB</th>
	<th>Post Code</th>
	</tr>
	</thead>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {



	echo '<tr class='.$class.'>';
	echo "<td>".$row['client_id']."</td>";
         echo "<td>".$row['submitted_date']."</td>";
	echo "<td>".$row['Client Name']."</td>";
	echo "<td>".$row['dob']."</td>";
	echo "<td>".$row['Post Code']."</td>";
   echo "<td>
      <form action='EditClient.php' method='POST' name='form'>
	<input type='hidden' name='search' value='".$row['client_id']."' >
         <input type='submit'  value='Edit'/>
      </form>
   </td>";
   echo "<td>
      <form action='ViewClient.php' method='POST' name='formview'>
	<input type='hidden' name='search' value='".$row['client_id']."' >
         <input type='submit'  value='View'/>
      </form>
   </td>";
   	echo "</tr>";
	echo "\n";
	}
} else {
    echo "0 results";
}
echo "</table>";

$conn->close();
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


 <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>


    </div>
  </div>
</div>

</body>
</html>

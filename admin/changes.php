<!--Audits TAB-->

<div id="tab6" class="tab">    

<div class="container">

<div class="column-left">


 <table border="1" class="Audit">
    <tr>
    <th colspan="4">Changes to Client Info<label></label></th>
    </tr>
    <tr>
    <td>Edited By</td>
    <td>Date Edited</td>

    </tr>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {


$search = $_GET['search'];

if(isset($_GET["search"])) $rf = $_GET["search"];

}

 $sql="SELECT edited_by, date_edited FROM client_details_his WHERE client_id = '$search' ORDER BY date_edited DESC";
 $result_set=mysqli_query($GLOBALS["___mysqli_ston"], $sql);
 while($row=mysqli_fetch_array($result_set))
 {
  ?>
        <tr>
        <td><?php echo $row['edited_by'] ?></td>
        <td><?php echo $row['date_edited'] ?></td>
        </tr>
        <?php
 }
 ?>
    </table>


</div>

<div class="column-center">


 <table border="1" class="Audit">
    <tr>
    <th colspan="4">Changes to Policy<label></label></th>
    </tr>
    <tr>
    <td>Edited By</td>
    <td>Date Edited</td>
    <td>Policy</td>
    <td>Policy Status</td>

    </tr>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {


$search = $_GET['search'];

if(isset($_GET["search"])) $rf = $_GET["search"];

}

 $sql="SELECT policy_number, policy_status, edited_by, date_edited FROM client_policy_his WHERE client_id = '$search' ORDER BY date_edited DESC";
 $result_set=mysqli_query($GLOBALS["___mysqli_ston"], $sql);
 while($row=mysqli_fetch_array($result_set))
 {
  ?>
        <tr>
        <td><?php echo $row['edited_by'] ?></td>
        <td><?php echo $row['date_edited'] ?></td>
        <td><?php echo $row['policy_number'] ?></td>
        <td><?php echo $row['policy_status'] ?></td>
        </tr>
        <?php
 }
 ?>
    </table>

</div>

<div class="column-right">
<p>3</p>
</div>
</div>
</div>
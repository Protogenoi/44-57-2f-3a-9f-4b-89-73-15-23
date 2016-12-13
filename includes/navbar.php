<?php

$Level_2_Access = array("Jade");

if (in_array($hello_name,$Level_2_Access, true)) {
    
    header('Location: /Life/Financial_Menu.php'); die;
    
}

include ($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
include ($_SERVER['DOCUMENT_ROOT']."/includes/ADL_PDO_CON.php");

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
$cnquery->execute()or die(print_r($query->errorInfo(), true));
$companydetailsq=$cnquery->fetch(PDO::FETCH_ASSOC);
$companynamere=$companydetailsq['company_name'];

if($companynamere=='The Review Bureau') {
    $Level_10_Access = array("Michael", "Matt", "leighton");
    $Level_8_Access = array("Michael", "Matt", "leighton", "Abbiek", "carys","Tina","Heidy","Nicola","Nathan","Mike");
    $Level_3_Access = array("Michael", "Matt", "leighton", "Abbiek", "carys","Roxy","Jakob","Nicola","Tina",'Heidy','Georgia','Amy',"Nathan","Mike","Matthew","Keith");
    $Level_1_Access = array("Michael", "Matt", "leighton", "Abbiek", "carys","Roxy","Jakob","Nicola","Tina",'Heidy','Georgia','Amy',"Nathan","Mike","Matthew","Keith");
    
}

if($companynamere=='Assura') {
    $Level_10_Access = array("Michael");
    $Level_8_Access = array("Michael", "Tina","Nathan","Charles");
    $Level_3_Access = array("Michael", "Tina","Nathan","Charles");
    $Level_1_Access = array("Michael", "Tina","Nathan","Charles");
    
}

if($companynamere=='HWIFS') {
    $Level_10_Access = array("Michael");
    $Level_8_Access = array("Michael");
    $Level_3_Access = array("Michael"); 
    $Level_1_Access = array("Michael");
    
}

                         
?>
<div class="bs-example">
    <nav role="navigation" class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/index.php" class="navbar-brand"> <?php if(isset($companynamere)) { echo "$companynamere";}?></a>
        </div>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/CRMmain.php"><i class="fa fa-home">  Home</i></a></li>
                <li><a href="/AddClient.php"><i class="fa fa-user-plus">  Add</i></a></li>
                <li><a href="/SearchClients.php"><i class="fa fa-search">  Search</i></a></li>
                <li><a href="/Life/QuickSearch.php"><i class="fa fa-flash">  Quick Search</i></a></li>


                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">CRM <b class="caret"></b></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="/CRMmain.php">Main Menu</a></li>
                        <li><a href="/AddClient.php">Add Client</a></li>
                        <li><a href="/SearchClients.php">Search Clients</a></li>
                        <li><a href="/SearchPolicies.php?query=Life">Search Policies</a></li>
                        <li><a href="/CRMReports.php">Reports</a></li>
                            
                            <?php 
                            
                            if($ffdialler=='1') { ?>
                        
                        <li><a href="/dialer/Recordings.php">Recordings</a></li>
                            
                            <?php } ?>
                        
                        <li><a href="/Emails.php">Emails</a></li>
                            
                            <?php if (in_array($hello_name,$Level_8_Access, true)) { ?>
                        
                        <li><a href="<?php if($fflife=='1') { echo "Life/Reports/AllTasks.php"; } elseif($ffpensions=='1') { echo "/Pensions/Reports/PensionStages.php"; } else { echo "#"; }?>">Tasks</a></li>
                            
                            <?php } 
                            
                            if($ffcalendar=='1') { ?>
                        
                        <li><a href="/calendar/calendar.php">Calendar</a></li>
                            
                            <?php } 
                            
                            if($hello_name=='Michael') { ?>
                        
                        <li><a href="/calendar/GoogleCalendar.php">Google Calendar</a></li>
                        <li><a href="/email/emailinbox.php">Email Inbox</a></li>
                            
                            <?php } ?>

                    </ul>
                </li>
                    
                    <?php if($ffaudits=='1') { ?>
                
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Audits <b class="caret"></b></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="/audits/main_menu.php">Main Menu</a></li>
                        <li><a href="/audits/lead_gen_reports.php?step=New">Lead Audits</a></li>
                        <li><a href="/audits/auditor_menu.php">Closer Audits</a></li>
                        <li><a href="/audits/WOL/Menu.php">WOL Audits</a></li>
                        <li><a href="/audits/reports_main.php">Reports</a></li>
                            <?php if($ffdialler=='1') { ?>
                        
                        <li><a href="/dialer/Recordings.php">Recordings</a></li>
                            
                            <?php } ?>
                        
                        <li><a href="/Emails.php">Emails</a></li>
                    </ul>
                </li>
                    
                    <?php } 
                    
                    if($ffdialler=='1' && (in_array($hello_name,$Level_10_Access, true))) { ?>
                
                <li class='dropdown'>
                    <a data-toggle='dropdown' class='dropdown-toggle' href='#'>Dialler <b class='caret'></b></a>
                    <ul role='menu' class='dropdown-menu'>
                        <li><a href='/dialer/RealTimeReport.php'>Real Time Report</a></li>
                        <li><a href='/dialer/LifeScore.php'>Life Real Time Report</a></li>
                        <li><a href="/dialer/Recordings.php">Recordings</a></li>
                    </ul>  
                </li>
                    
                    <?php } if($hello_name == 'Michael') { ?>
                
                <li class='dropdown'>
                    <a data-toggle='dropdown' class='dropdown-toggle' href='#'>Admin <b class='caret'></b></a>
                    <ul role='menu' class='dropdown-menu'>
                        <li><a href='/admin/Admindash.php?admindash=y'>Admin Control Panel</a></li>
                        
                        <li><a href='/admin/users.php'>User Accounts</a></li>
                    </ul>  
                </li>
                    
                    <?php } ?>
            
            </ul>
                   
                <?php if($hello_name=='Michael' || (!in_array($hello_name,$Level_10_Access, true))) { ?>
            <div class="LIVERESULTS">

        </div>
                <?php }  ?>
        </div>
    </nav>
</div>
<?php if($hello_name=='Michael' || (!in_array($hello_name,$Level_10_Access, true))) { ?>
<script>
    function refresh_div() {
        jQuery.ajax({
            url:'/php/NavbarLiveResults.php?name=<?php echo $hello_name;?>',
            type:'POST',
            success:function(results) {
                jQuery(".LIVERESULTS").html(results);
            }
        });
    }

    t = setInterval(refresh_div,1000);
</script>
<?php } ?>
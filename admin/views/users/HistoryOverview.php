

    <?php foreach ($HistoryOverviewList as $HistoryOverview): ?>
    
        <?php

        $LG_Audit = $HistoryOverview['LG_Audit'];
        $Lead_Audit = $HistoryOverview['Lead_Audit'];
        $Aviva_Audit = $HistoryOverview['Aviva_Audit'];
        $WOL_Audit= $HistoryOverview['WOL_Audit'];
        
        $Client_Views= $HistoryOverview['Client_Views'];
        $Add_Client= $HistoryOverview['Add_Client'];
        $Edit_Client= $HistoryOverview['Edit_Client'];
        $Edit_Policy= $HistoryOverview['Edit_Policy'];
        $Client_Notes= $HistoryOverview['Client_Notes'];
        $Add_Policy= $HistoryOverview['Add_Policy'];
        
        $Email_Client= $HistoryOverview['Email_Client'];
        $Sent_SMS= $HistoryOverview['Sent_SMS'];
        $View_Policy= $HistoryOverview['View_Policy'];
        $Uploads= $HistoryOverview['Uploads'];
        $Advanced_Client_Search= $HistoryOverview['Advanced_Client_Search'];
        
        $Basic_Client_Search= $HistoryOverview['Basic_Client_Search'];
        $Advanced_Policy_Search= $HistoryOverview['Advanced_Policy_Search'];
        $Keyfacts_Email= $HistoryOverview['Keyfacts_Email'];
        $Tracker_Added= $HistoryOverview['Tracker_Added'];
        

           echo  "   
        <div class='col-xs-12'>
<div class='row'>
        <div class='col-xs-2'><center><strong>Client Views</strong><br>$Client_Views</center></div>
        <div class='col-xs-2'><center><strong>Client Adds</strong><br> $Add_Client</center></div>
        <div class='col-xs-2'><center><strong>Client Edits</strong><br> $Edit_Client</center></div>
        <div class='col-xs-2'><center><strong>Policy Edits</strong><br> $Edit_Policy</center></div>
        <div class='col-xs-2'><center><strong>Client Notes</strong><br> $Client_Notes</center></div> 
        <div class='col-xs-2'><center><strong>Added Policy</strong><br> $Add_Policy</center></div> 
        <div class='col-xs-2'><center><strong>Client Uploads</strong><br> $Uploads</center></div>     
        <div class='col-xs-2'><center><strong>Client Emails</strong><br> $Email_Client</center></div> 
        <div class='col-xs-2'><center><strong>Client SMS</strong><br> $Sent_SMS</center></div> 
        <div class='col-xs-2'><center><strong>View Policy</strong><br> $View_Policy</center></div> 
        <div class='col-xs-2'><center><strong>Advanced Search</strong><br> $Advanced_Client_Search</center></div> 
        <div class='col-xs-2'><center><strong>Basic Search</strong><br> $Basic_Client_Search</center></div>
        <div class='col-xs-2'><center><strong>Policy Search</strong><br> $Advanced_Policy_Search</center></div>
            </div>
            </div>
<div class='col-xs-12'>
<div class='row'>
        <div class='col-xs-2'><center><strong>LG Audits</strong><br>$LG_Audit</center></div>
        <div class='col-xs-2'><center><strong>Lead Audits</strong><br>$Lead_Audit</center></div>
        <div class='col-xs-2'><center><strong>Aviva Audits</strong><br>$Aviva_Audit</center></div>
        <div class='col-xs-2'><center><strong>WOL Audits</strong><br>$WOL_Audit</center></div>
</div>       
</div>        <div class='col-xs-12'>
<div class='row'>
        <div class='col-xs-2'><center><strong>Tracker Added</strong><br>$Tracker_Added</center></div>
        <div class='col-xs-2'><center><strong>Keyfacts Email</strong><br>$Keyfacts_Email</center></div>
            </div>
        </div>";  

    
        ?>

    <?php endforeach ?>

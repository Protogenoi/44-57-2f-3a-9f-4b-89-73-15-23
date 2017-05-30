<?php
require_once(__DIR__ . '/ADL_PDO_CON.php');

$query = $pdo->prepare("SELECT compliance, ews, financials, trackers, dealsheets, employee, post_code, pba, error, twitter, gmaps, analytics, callbacks, dialler, intemails, clientemails, keyfactsemail, genemail, recemail, sms, calendar, audits, life, home, pension FROM adl_features LIMIT 1");
$query->execute()or die(print_r($query->errorInfo(), true));
$checkfeatures=$query->fetch(PDO::FETCH_ASSOC);
            
            $ffdialler=$checkfeatures['dialler'];
            $ffintemails=$checkfeatures['intemails'];
            $ffclientemails=$checkfeatures['clientemails'];
            $ffkeyfactsemail=$checkfeatures['keyfactsemail'];
            $ffgenemail=$checkfeatures['genemail'];
            $ffrecemail=$checkfeatures['recemail'];
            $ffsms=$checkfeatures['sms'];
            $ffcalendar=$checkfeatures['calendar'];
            $ffaudits=$checkfeatures['audits'];
            $fflife=$checkfeatures['life'];
            $ffhome=$checkfeatures['home'];
            $ffpensions=$checkfeatures['pension'];
            $ffcallbacks=$checkfeatures['callbacks'];
            $ffanalytics=$checkfeatures['analytics'];
            $ffgmaps=$checkfeatures['gmaps'];
            $fftwitter=$checkfeatures['twitter'];
            $fferror=$checkfeatures['error'];
            $ffpba=$checkfeatures['pba'];
            $ffpost_code=$checkfeatures['post_code'];
            $ffemployee=$checkfeatures['employee'];
            $ffdealsheets=$checkfeatures['dealsheets'];
            $fftrackers=$checkfeatures['trackers'];
            $ffews=$checkfeatures['ews'];
            $fffinancials=$checkfeatures['financials'];
            $ffcompliance=$checkfeatures['compliance'];
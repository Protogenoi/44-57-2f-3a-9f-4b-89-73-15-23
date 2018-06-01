<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2018
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 *  Webshim - https://github.com/aFarkas/webshim/releases/latest
 * 
*/ 

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
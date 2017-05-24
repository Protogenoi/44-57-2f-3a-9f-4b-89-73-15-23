<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

require('../fpdf17/fpdf.php');

$auditid = '0';
if(isset($_GET["auditid"])) $auditid = $_GET["auditid"];
 
  
$auditid=$_GET['auditid'];

$search=$_POST['search'];

$query = $pdo->prepare("SELECT * FROM closer_audits WHERE id = :searchplaceholder OR id = :auditidplaceholder");

$query->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
$query->bindParam(':auditidplaceholder', $auditid, PDO::PARAM_STR, 12);
  
$query->execute();
while($result=$query->fetch(PDO::FETCH_ASSOC)){

$date_submitted=$result['date_submitted'];
$auditor=$result['auditor'];
$total=$result['total'];
$id=$result['id'];
$closer=$result['closer'];
$keyfield=$result['keyfield'];
$edited_by=$result['edited']; 
$policy_number=$result['policy_number']; 
$grade=$result['grade']; 
$q1=$result['q1'];
$c1=$result['c1'];
$q2=$result['q2'];
$c2=$result['c2'];
$q3=$result['q3'];
$c3=$result['c3'];
$q4=$result['q4'];
$c4=$result['c4'];
$q5=$result['q5'];
$c5=$result['c5'];
$q6=$result['q6'];
$c6=$result['c6'];
$q7=$result['q7'];
$c7=$result['c7'];
$q8=$result['q8'];
$c8=$result['c8'];
$q9=$result['q9'];
$c9=$result['c9'];
$q10=$result['q10'];
$c10=$result['c10'];
$q11=$result['q11'];
$c11=$result['c11'];
$q12=$result['q12'];
$c12=$result['c12'];
$q13=$result['q13'];
$c13=$result['c13'];
$q14=$result['q14'];
$c14=$result['c14'];
$q15=$result['q15'];
$c15=$result['c15'];
$q16=$result['q16'];
$c16=$result['c16'];
$q17=$result['q17'];
$c17=$result['c17'];
$q18=$result['q18'];
$c18=$result['c18'];
$q19=$result['q19'];
$c19=$result['c19'];
$q20=$result['q20'];
$c20=$result['c20'];
$q21=$result['q21'];
$c21=$result['c21'];
$q22=$result['q22'];
$c22=$result['c22'];
$q23=$result['q23'];
$c23=$result['c23'];
$q24=$result['q24'];
$c24=$result['c24'];
$q25=$result['q25'];
$c25=$result['c25'];
$q26=$result['q26'];
$c26=$result['c26'];
$q27=$result['q27'];
$c27=$result['c27'];
$q28=$result['q28'];
$c28=$result['c28'];
$q29=$result['q29'];
$c29=$result['c29'];
$q30=$result['q30'];
$c30=$result['c30'];
$q31=$result['q31'];
$c31=$result['c31'];
$q32=$result['q32'];
$c32=$result['c32'];
$q33=$result['q33'];
$c33=$result['c33'];
$q34=$result['q34'];
$c34=$result['c34'];
$q35=$result['q35'];
$c35=$result['c35'];
$q36=$result['q36'];
$c36=$result['c36'];
//$q37=$result['q37'];
//$c37=$result['c37'];
$q38=$result['q38'];
$c38=$result['c38'];
$q39=$result['q39'];
$c39=$result['c39'];
$q40=$result['q40'];
$c40=$result['c40'];
$q41=$result['q41'];
$c41=$result['c41'];
$q42=$result['q42'];
$c42=$result['c42'];
$q43=$result['q43'];
$c43=$result['c43'];
$q44=$result['q44'];
$c44=$result['c44'];
$q45=$result['q45'];
$c45=$result['c45'];
$q46=$result['q46'];
$c46=$result['c46'];
$q47=$result['q47'];
$c47=$result['c47'];
$q48=$result['q48'];
$c48=$result['c48'];
$q49=$result['q49'];
$c49=$result['c49'];
$q50=$result['q50'];
$c50=$result['c50'];
$q51=$result['q51'];
$c51=$result['c51'];
$q52=$result['q52'];
$c52=$result['c52'];
$q53=$result['q53'];
$c53=$result['c53'];
$q54=$result['q54'];
$c54=$result['c54'];
$q55=$result['q55'];
$c55=$result['c55'];
$lead_id=$result['lead_id'];
$lead_id2=$result['lead_id2'];
$lead_id3=$result['lead_id3'];

}

$no = array (255,0,0);
$textColour = array( 0, 0, 0 );
$headerColour = array( 100, 100, 100 );
$tableHeaderTopTextColour = array( 255, 255, 255 );
$tableHeaderTopFillColour = array( 125, 152, 179 );
$tableHeaderTopProductTextColour = array( 0, 0, 0 );
$tableHeaderTopProductFillColour = array( 143, 173, 204 );
$tableHeaderLeftTextColour = array( 99, 42, 57 );
$tableHeaderLeftFillColour = array( 184, 207, 229 );
$tableBorderColour = array( 50, 50, 50 );
$tableRowFillColour = array( 213, 170, 170 );
$reportName = "The Review Bureau Call Audit";
$reportNameYPos = 60;
$columnLabels = array( " ");
$resultLabels = array( "Auditor", "Closer(s)", "Date Submitted", "Policy Number" );

$chartColours = array(
                  array( 255, 100, 100 ),
                  array( 100, 255, 100 ),
                  array( 100, 100, 255 ),
                  array( 255, 255, 100 ),
                );

$data = array(
          array( $auditor ),
          array( $closer ),
          array( $date_submitted ),
          array( $policy_number ),
        );

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
//    $this->Image('img/logo.jpeg',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','I',8);
    // Move to the right
    $this->Cell(1);
    // Title
    $this->Cell(0,5,'The Review Bureau - Call Audit',0,0,'C');
    // Line break
    $this->Ln(10);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

$pdf = new PDF( 'P', 'mm', 'A4' );
$pdf->AliasNbPages();
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->AddPage();

// Logo
//$pdf->Image( $logoFile, $logoXPos, $logoYPos, $logoWidth );

// Report Name
$pdf->SetFont( 'Arial', 'B', 24 );
$pdf->Ln( $reportNameYPos );
$pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
$pdf->Ln( 25 );
/**
  Create the table
**/

$pdf->SetDrawColor( $tableBorderColour[0], $tableBorderColour[1], $tableBorderColour[2] );

// Create the table header row
$pdf->SetFont( 'Helvetica', '', 10 );

// "PRODUCT" cell
$pdf->SetTextColor( $tableHeaderTopProductTextColour[0], $tableHeaderTopProductTextColour[1], $tableHeaderTopProductTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopProductFillColour[0], $tableHeaderTopProductFillColour[1], $tableHeaderTopProductFillColour[2] );


$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->Cell( 190, 5, " Call Audit: $id", 1, 1, 'C', true );
$pdf->SetFont( 'Helvetica', '', 10 );
if($grade=="Red")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetFillColor(255,0,0);
$pdf->Cell( 190, 5, " Grade: $grade", 1, 2, 'C', true );
$pdf->SetTextColor(0,0,0);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor( $tableHeaderTopProductTextColour[0], $tableHeaderTopProductTextColour[1], $tableHeaderTopProductTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopProductFillColour[0], $tableHeaderTopProductFillColour[1], $tableHeaderTopProductFillColour[2] );

}
else if ($grade=="Amber")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetFillColor(255,191,0);
$pdf->Cell( 190, 5, " Grade: $grade", 1, 2, 'C', true );
$pdf->SetTextColor(0,0,0);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor( $tableHeaderTopProductTextColour[0], $tableHeaderTopProductTextColour[1], $tableHeaderTopProductTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopProductFillColour[0], $tableHeaderTopProductFillColour[1], $tableHeaderTopProductFillColour[2] );
}
else if ($grade=="Green")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetFillColor(0,255,0);
$pdf->Cell( 190, 5, " Grade: $grade", 1, 2, 'C', true );
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor( $tableHeaderTopProductTextColour[0], $tableHeaderTopProductTextColour[1], $tableHeaderTopProductTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopProductFillColour[0], $tableHeaderTopProductFillColour[1], $tableHeaderTopProductFillColour[2] );
}
$pdf->Cell( 190, 5, " $total/54 answered correctly", 1, 3, 'C', true );
$pdf->Cell( 190, 5, " Auditor: $auditor", 1, 4, 'C', true );
$pdf->Cell( 190, 5, " Closer(s): $closer $closer2", 1, 5, 'C', true );
$pdf->Cell( 190, 5, " Date Submitted: $date_submitted", 1, 6, 'C', true );
$pdf->Cell( 190, 5, " Policy Number: $policy_number", 1, 7, 'C', true );
$pdf->Ln( 7 );

$pdf->AddPage();
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->SetFont( 'Helvetica', '', 10 );

$pdf->SetFont( 'Helvetica', 'B', 12 );
$pdf->Write(6,'Opening Declaration');
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->Ln( 10 );

$pdf->Write(6,'Q1. Was The Customer Made Aware That Calls Are Recorded For Training And Monitoring Purposes?');
$pdf->Ln( 5 );
if($q1=="Yes")
{
$pdf->MultiCell(0,11,"$q1 $c1", 0, 1);
}
else if ($q1=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q1 $c1", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q2. Was The Customer Informed That General Insurance Is Regulated By The FCA?');
$pdf->Ln( 5 );
if($q2=="Yes")
{
$pdf->MultiCell(0,11,"$q2 $c2", 0, 1);
}
else if ($q2=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q2 $c2", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q3. Did The Customer Consent To The Abbreviated Script Being Read? (If no, was the full disclosure read?)');
$pdf->Ln( 5 );
if($q3=="Yes")
{
$pdf->MultiCell(0,11,"$q3 $c3", 0, 1);
}
else if ($q3=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q3 $c3", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q4. Did The Sales Agent Provide The Name And Details Of The Firm Who Is Regulated With The FCA?');
$pdf->Ln( 5 );
if($q4=="Yes")
{
$pdf->MultiCell(0,11,"$q4 $c4", 0, 1);
}
else if ($q4=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q4 $c4", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->SetFont( 'Helvetica', 'B', 12 );
$pdf->Write(6,'Customer Information');
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->Ln( 10 );

$pdf->Write( 6,'Q5. Did The Sales Agent Make The Customer Aware That They Are Unable To Offer Advice Or Personal Opinion They Will Only Be Providing Them With An Information Based Service To Make Their Own Informed Decision?');
$pdf->Ln( 5 );
if($q5=="Yes")
{
$pdf->MultiCell(0,11,"$q5 $c5", 0, 1);
}
else if ($q5=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q5 $c5", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q6. Were All Clients Titles And Names Recorded Correctly?');
$pdf->Ln( 5 );
if($q6=="Yes")
{
$pdf->MultiCell(0,11,"$q6 $c6", 0, 1);
}
else if ($q6=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q6 $c6", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q7. Was The Clients Gender Accurately Recorded?');
$pdf->Ln( 5 );
if($q7=="Yes")
{
$pdf->MultiCell(0,11,"$q7 $c7", 0, 1);
}
else if ($q7=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q7 $c7", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q8. Was The Clients Date Of Birth Accurately Recorded?');
$pdf->Ln( 5 );
if($q8=="Yes")
{
$pdf->MultiCell(0,11,"$q8 $c8", 0, 1);
}
else if ($q8=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q8 $c8", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q9. Was The Clients Smoker Status Recorded Correctly?');
$pdf->Ln( 5 );
if($q9=="Yes")
{
$pdf->MultiCell(0,11,"$q9 $c10", 0, 1);
}
else if ($q9=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q9 $c9", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q10. Was The Clients Employment Status Recorded Correctly?');
$pdf->Ln( 5 );
if($q10=="Yes")
{
$pdf->MultiCell(0,11,"$q10 $c10", 0, 1);
}
else if ($q10=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q10 $c10", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q11. Did The Sales Agent Confirm The Policy Was A Single Or Joint Application?');
$pdf->Ln( 5 );
if($q11=="Yes")
{
$pdf->MultiCell(0,11,"$q11 $c11", 0, 1);
}
else if ($q11=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q11 $c11", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->SetFont( 'Helvetica', 'B', 12 );
$pdf->Write(6,'Identifying Clients Needs');
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->Ln( 10 );

$pdf->Write( 6,'Q12. Did The Agent Check All Details Of What The Client Has With Their Existing Life Insurance Policy?');
$pdf->Ln( 5 );
if($q12=="Yes")
{
$pdf->MultiCell(0,11,"$q12 $c12", 0, 1);
}
else if ($q12=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q12 $c12", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q13. Did the agent mention waiver, indexation, or TPD?');
$pdf->Ln( 5 );
if($q53=="Yes")
{
$pdf->MultiCell(0,11,"$q53 $c53", 0, 1);
}
elseif($q53=="N/A")
{
$pdf->MultiCell(0,11,"$q53 $c53", 0, 1);
}
else if ($q53=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q53 $c53", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q14. Did The Agent Ensure That The Client Was Provided With A Policy That Meet Their Needs? More Cover,Cheaper Premium Etc?');
$pdf->Ln( 5 );
if($q13=="Yes")
{
$pdf->MultiCell(0,11,"$q13 $c13", 0, 1);
}
else if ($q13=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q13 $c13", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}


$pdf->Write( 6,'Q15. Did The Sales Agent Provide The Customer With A Sufficient Amount Of Features And Benefits For The Policy?');
$pdf->Ln( 5 );
if($q14=="More than sufficient")
{
$pdf->MultiCell(0,11,"$q14 $c14", 0, 1);
}
elseif($q14=="Sufficient")
{
$pdf->MultiCell(0,11,"$q14 $c14", 0, 1);
}
else if ($q14=="Adaquate")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q14 $c14", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}
else if ($q14=="Poor")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q14 $c14", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}


$pdf->Write( 6,'Q16. Agent confirmed This Policy Will Be Set Up With Legal And General?');
$pdf->Ln( 5 );
if($q15=="Yes")
{
$pdf->MultiCell(0,11,"$q15 $c15", 0, 1);
}
else if ($q15=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q15 $c15", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->SetFont( 'Helvetica', 'B', 12 );
$pdf->Write(6,'Eligibility');
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->Ln( 10 );

$pdf->Write( 6,'Q17. Important customer information declaration?');
$pdf->Ln( 5 );
if($q55=="Yes")
{
$pdf->MultiCell(0,11,"$q55 $c55", 0, 1);
}
else if ($q55=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q55 $c55", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q18. Were All Clients Contact Details Recorded Correctly?');
$pdf->Ln( 5 );
if($q17=="Yes")
{
$pdf->MultiCell(0,11,"$q17 $c17", 0, 1);
}
else if ($q17=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q17 $c17", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q19. Were All Clients Address Details Recorded Correctly?');
$pdf->Ln( 5 );
if($q16=="Yes")
{
$pdf->MultiCell(0,11,"$q16 $c16", 0, 1);
}
else if ($q16=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q16 $c16", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}


$pdf->Write( 6,'Q20. Were All Doctors Details Recorded Correctly?');
$pdf->Ln( 5 );
if($q31=="Yes")
{
$pdf->MultiCell(0,11,"$q31 $c31", 0, 1);
}
else if ($q31=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q31 $c31", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q21. Did The Agent Ask And Accurately Record The Work And Travel Questions And Record The Details Correctly?');
$pdf->Ln( 5 );
if($q18=="Yes")
{
$pdf->MultiCell(0,11,"$q18 $c18", 0, 1);
}
else if ($q18=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q18 $c18", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q22. Did The Agent Ask And Accurately Record The Hazardous Activities Questions?');
$pdf->Ln( 5 );
if($q19=="Yes")
{
$pdf->MultiCell(0,11,"$q19 $c19", 0, 1);
}
else if ($q19=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q19 $c19", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q23. Did The Agent Ask And Accurately Record The Height And Weight Details And Record The Details Correctly?');
$pdf->Ln( 5 );
if($q20=="Yes")
{
$pdf->MultiCell(0,11,"$q20 $c20", 0, 1);
}
else if ($q20=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q20 $c20", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q24. Did The Agent Ask And Accurately Record The Smoking Details Correctly?');
$pdf->Ln( 5 );
if($q21=="Yes")
{
$pdf->MultiCell(0,11,"$q21 $c21", 0, 1);
}
else if ($q21=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q21 $c21", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q25. Did The Agent Ask And Accurately Record The Smoking Details Correctly?');
$pdf->Ln( 5 );
if($q22=="Yes")
{
$pdf->MultiCell(0,11,"$q22 $c22", 0, 1);
}
else if ($q22=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q22 $c22", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q26. Did The Agent Ask And Accurately Record The Alcohol Consumption Details Correctly?');
$pdf->Ln( 5 );
if($q23=="Yes")
{
$pdf->MultiCell(0,11,"$q23 $c23", 0, 1);
}
else if ($q23=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q23 $c23", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q27. Were All Health Ever Questions Asked And Details Recorded Correctly?');
$pdf->Ln( 5 );
if($q24=="Yes")
{
$pdf->MultiCell(0,11,"$q24 $c24", 0, 1);
}
else if ($q24=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q24 $c24", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q28. Were All Health Last 5 Years Questions Asked And Details Recorded Correctly?');
$pdf->Ln( 5 );
if($q25=="Yes")
{
$pdf->MultiCell(0,11,"$q25 $c25", 0, 1);
}
else if ($q25=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q25 $c25", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q29. Were All Health Last 2 Years Questions Asked And Details Recorded Correctly?');
$pdf->Ln( 5 );
if($q26=="Yes")
{
$pdf->MultiCell(0,11,"$q26 $c26", 0, 1);
}
else if ($q26=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q26 $c26", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q30. Were All Health Continued Questions Asked And Details Recorded Correctly?');
$pdf->Ln( 5 );
if($q27=="Yes")
{
$pdf->MultiCell(0,11,"$q27 $c27", 0, 1);
}
else if ($q27=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q27 $c27", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}


$pdf->Write( 6,'Q31. Were All Family History Questions Asked And Details Recorded Correctly?');
$pdf->Ln( 5 );
if($q28=="Yes")
{
$pdf->MultiCell(0,11,"$q28 $c28", 0, 1);
}
else if ($q28=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q28 $c28", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q32. Were Term For Term Details Recorded Correctly?');
$pdf->Ln( 5 );
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->MultiCell(0,11,"$q29 $c29", 0, 1);

$pdf->SetFont( 'Helvetica', 'B', 12 );
$pdf->Write(6,'Declarations of Insurnace');
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->Ln( 10 );

$pdf->Write( 6,'Q33. Customer declaration read out?');
$pdf->Ln( 5 );
if($q30=="Yes")
{
$pdf->MultiCell(0,11,"$q30 $c30", 0, 1);
}
else if ($q30=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q30 $c30", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q34. If applicable did the agent confirm the exclusions on the policy?');
$pdf->Ln( 5 );
if($q54=="Yes")
{
$pdf->MultiCell(0,11,"$q54 $c54", 0, 1);
}
else if($q54=="N/A")
{
$pdf->MultiCell(0,11,"$q54 $c54", 0, 1);
}
else if ($q54=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q54 $c54", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}



$pdf->SetFont( 'Helvetica', 'B', 12 );
$pdf->Write(6,'Payment Information');
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->Ln( 10 );

$pdf->Write( 6,'Q35. Was The Clients Policy Start Date Accurately Recorded?');
$pdf->Ln( 5 );
if($q32=="Yes")
{
$pdf->MultiCell(0,11,"$q32 $c32", 0, 1);
}
else if ($q32=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q32 $c32", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q36. Did The Agent Offer To Read The Direct Debit Guarantee?');
$pdf->Ln( 5 );
if($q33=="Yes")
{
$pdf->MultiCell(0,11,"$q33 $c33", 0, 1);
}
else if ($q33=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q33 $c33", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q37. Did The Agent Offer A Preferred Premium Collection Date?');
$pdf->Ln( 5 );
if($q34=="Yes")
{
$pdf->MultiCell(0,11,"$q34 $c34", 0, 1);
}
else if ($q34=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q34 $c34", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q38. Did The Agent Take Bank Details Correctly?');
$pdf->Ln( 5 );
if($q35=="Yes")
{
$pdf->MultiCell(0,11,"$q35 $c35", 0, 1);
}
else if ($q35=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q35 $c35", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q39. Did They Have Consent Off The Premium Payer?');
$pdf->Ln( 5 );
if($q36=="Yes")
{
$pdf->MultiCell(0,11,"$q36 $c36", 0, 1);
}
else if ($q36=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q36 $c36", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->SetFont( 'Helvetica', 'B', 12 );
$pdf->Write(6,'Consolidation Declaration');
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->Ln( 10 );

$pdf->Write( 6,'Q40. Agent confirmed The Customers Rights To Cancel The Policy At Any Anytime And If The Customer Changes Their Mind Within The First 30 Days Of Starting There Will Be A Refund Of Premiums?');
$pdf->Ln( 5 );
if($q38=="Yes")
{
$pdf->MultiCell(0,11,"$q38 $c38", 0, 1);
}
else if ($q38=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q38 $c38", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q41. Agent confirmed If The Policy Is Cancelled At Any Other Time The Cover Will End And No Refund Will Be Made And That The Policy Has No Cash In Value?');
$pdf->Ln( 5 );
if($q39=="Yes")
{
$pdf->MultiCell(0,11,"$q39 $c39", 0, 1);
}
else if ($q39=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q39 $c39", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q42. Like Mentioned Earlier Did The Sales Agent Make The Customer Aware That They Are Unable To Offer Advice Or Personal Opinion They Will Only Be Providing Them With An Information Based Service To Make Their Own Informed Decision?');
$pdf->Ln( 5 );
if($q40=="Yes")
{
$pdf->MultiCell(0,11,"$q40 $c40", 0, 1);
}
else if ($q40=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q40 $c40", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q43. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.');
$pdf->Ln( 5 );
if($q41=="Yes")
{
$pdf->MultiCell(0,11,"$q41 $c41", 0, 1);
}
else if ($q41=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q41 $c41", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q44. Did the closer confirm that the customer will be getting a my account email from Legal and General?');
$pdf->Ln( 5 );
if($q42=="Yes")
{
$pdf->MultiCell(0,11,"$q42 $c42", 0, 1);
}
else if ($q42=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q42 $c42", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q45. Agent confirmed The Check Your Details Procedure?');
$pdf->Ln( 5 );
if($q43=="Yes")
{
$pdf->MultiCell(0,11,"$q43 $c43", 0, 1);
}
else if ($q43=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q43 $c43", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}


$pdf->Write( 6,'Q46. Agent Confirmed an approximate Direct Debit date and informed the customer it is not an exact date, but legal and general will write to them with a more specific date?');
$pdf->Ln( 5 );
if($q44=="Yes")
{
$pdf->MultiCell(0,11,"$q44 $c44", 0, 1);
}
else if ($q44=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q44 $c44", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q47. Did the closer confirm to the customer to cancel their existing direct debit');
$pdf->Ln( 5 );
if($q45=="Yes")
{
$pdf->MultiCell(0,11,"$q45 $c45", 0, 1);
}
if($q45=="N/A")
{
$pdf->MultiCell(0,11,"$q45 $c45", 0, 1);
}
else if ($q45=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q45 $c45", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->SetFont( 'Helvetica', 'B', 12 );
$pdf->Write(6,'Quality Control');
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->Ln( 10 );

$pdf->Write( 6,'Q48. Agent confirmed That They Have Set The Client Up On A Level/Decreasing/CIC Term Policy With Legal And General With Client Confirmation?');
$pdf->Ln( 5 );
if($q46=="Yes")
{
$pdf->MultiCell(0,11,"$q46 $c46", 0, 1);
}
else if ($q46=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q46 $c46", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q49. Agent confirmed The Length Of The Policy In Years With Client Confirmation?');
$pdf->Ln( 5 );
if($q47=="Yes")
{
$pdf->MultiCell(0,11,"$q47 $c47", 0, 1);
}
else if ($q47=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q47 $c47", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q50. Agent confirmed The Amount Of Cover On The Policy With Client Confirmation?');
$pdf->Ln( 5 );
if($q48=="Yes")
{
$pdf->MultiCell(0,11,"$q48 $c48", 0, 1);
}
else if ($q48=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q48 $c48", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q51. Agent confirmed With The Client That They Have Understood Everything Today With Client Confirmation?');
$pdf->Ln( 5 );
if($q49=="Yes")
{
$pdf->MultiCell(0,11,"$q49 $c49", 0, 1);
}
else if ($q49=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q49 $c49", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q52. Agent confirmed With The Client That They Have Understood Everything Today With Client Confirmation?');
$pdf->Ln( 5 );
if($q50=="Yes")
{
$pdf->MultiCell(0,11,"$q50 $c50", 0, 1);
}
else if ($q50=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q50 $c50", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q53. Agent confirmed With The Client That They Have Understood Everything Today With Client Confirmation?');
$pdf->Ln( 5 );
if($q51=="Yes")
{
$pdf->MultiCell(0,11,"$q51 $c51", 0, 1);
}
else if ($q51=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q51 $c51", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'Q54. Did The Sales Agent Keep To The Requirements Of A Non-Advised Sale, Providing An Information Based Service And Not Offering Advice Or Personal Opinion?');
$pdf->Ln( 5 );
if($q51=="Yes")
{
$pdf->MultiCell(0,11,"$q51 $c51", 0, 1);
}
else if ($q51=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$q51 $c51", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Output("Call_Audit_$id%_%$policy_number.pdf", "I");
?>

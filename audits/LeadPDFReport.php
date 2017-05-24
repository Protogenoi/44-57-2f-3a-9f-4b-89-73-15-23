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

$new= filter_input(INPUT_GET, 'new', FILTER_SANITIZE_SPECIAL_CHARS);

if($new=='y') {
    
    $viewauditid= filter_input(INPUT_GET, 'auditid', FILTER_SANITIZE_NUMBER_INT);
    
    $query = $pdo->prepare("SELECT an_number, q1s4q1n, q1s4c1n, auditor, submitted_date, id, agent, grade, sq1, sq2, sq3, sq4, sq5, s2aq1, s2aq2, s2aq3, s2aq4, s2aq5, s2aq6, s2aq7, s2aq8, s2aq9, s2aq10, s2aq11, s2bq1, q1s2bc1, q2s2bq2, q1s3q1, q2s2bc2, q1s3c1 from Audit_LeadGen where id =:id");
    $query->bindParam(':id', $viewauditid, PDO::PARAM_INT);
    $query->execute()or die(print_r($query->errorInfo(), true));
    $data3=$query->fetch(PDO::FETCH_ASSOC);
    
    $callauditid=$data3['id'];
    $auditor=$data3['auditor'];
    $agent=$data3['agent'];
    $an_number=$data3['an_number'];
    $submitted_date=$data3['submitted_date'];
    $grade=$data3['grade'];
    
    
    $q2s2bc2= filter_var($data3['q2s2bc2'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $q1s2bc1= filter_var($data3['q1s2bc1'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    class PDF extends FPDF
{

    function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'The Review Bureau Lead Gen Call Audit.',0,0,'C');
    
    
}
    
}

$pdf = new PDF('P','mm','A4');


// First page
$pdf->AddPage();
$pdf->SetMargins(30, 20 ,30);
$pdf->SetFont('Arial','',10);
$pdf->Image('../img/rblogonew.png',140,6,40);
$pdf->Ln( 5 );

$pdf->Cell(0,12,"Auditor: $auditor", 0, 0,'C');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"Agent: $agent", 0, 0,'C');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"AN number: $an_number", 0, 0,'C');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"Date Submitted: $submitted_date", 0, 0,'C');
$pdf->Ln( 10 );
if(isset($grade)) {
    if($grade=='Red') {
        $pdf->SetFillColor(255,0,0);
$pdf->Cell(0,12,"Red", 0, 0,'C','Red');
$pdf->Ln( 10 );
    }
}
if(isset($grade)) {
    if($grade=='Green') {
        $pdf->SetFillColor(17,255,0);
$pdf->Cell(0,12,"Green", 0, 0,'C','Green');
$pdf->Ln( 10 );
    }
}
if(isset($grade)) {
    if($grade=='Amber') {
        $pdf->SetFillColor(255,128,0);
$pdf->Cell(0,12,"Amber", 0, 0,'C','Orange');
$pdf->Ln( 10 );
    }
}
$pdf->SetFont('Arial','I',8);
    $pdf->Cell(0,12,"Only answers that were marked as No are shown", 0, 0,'C');
    $pdf->Ln( 10 );
$pdf->SetFont('Arial','',10);
if($data3['sq1']=="No") {
    $pdf->Cell(0,12,"Q1. Agent said their name?", 0, 0,'L');
    $pdf->Ln( 10 );
}

if($data3['sq2']=="No") {
    $pdf->Cell(0,12,"Q2. Said where they were calling from?", 0, 0,'L');
    $pdf->Ln( 10 );   
}

if($data3['sq3']=="No") {
    $pdf->Cell(0,12,"Q3. Said the reason for the call?", 0, 0,'L');
    $pdf->Ln( 10 );  
}

if($data3['sq4']=="No") {
    $pdf->Cell(0,12,"Q4. Used EU gender directive correctly?", 0, 0,'L');
    $pdf->Ln( 10 ); 
}

if($data3['sq5']=="No") {
    $pdf->Cell(0,12,"Q5. Agent followed the script?", 0, 0,'L');
    $pdf->Ln( 10 ); 
}

if($data3['s2aq1']=="No") {
    
     $pdf->Cell(0,12,"Q1. Were all questions asked?", 0, 0,'L');
    $pdf->Ln( 10 );    
    
}

if($data3['s2aq2']=="No") {
    
       $pdf->Cell(0,12,"Q2. What was the main reason you took out the policy?", 0, 0,'L');
    $pdf->Ln( 10 );    
    
}

if($data3['s2aq3']=="No") {

       $pdf->Cell(0,12,"Q3. Repayment or interest only?", 0, 0,'L');
    $pdf->Ln( 10 );      
    
}

if($data3['s2aq4']=="No") {
  
           $pdf->Cell(0,12,"Q4. When was your last review on the policy?", 0, 0,'L');
    $pdf->Ln( 10 );   
    
}

if($data3['s2aq5']=="No") {
    
             $pdf->Cell(0,12,"Q5. How did you take out the policy?", 0, 0,'L');
    $pdf->Ln( 10 );  
}
    if($data3['s2aq6']=="No") {
        
                     $pdf->Cell(0,12,"Q6. How much are you paying on a monthly basis?", 0, 0,'L');
    $pdf->Ln( 10 );  
        
    }
    
        if($data3['s2aq7']=="No") {
        
                     $pdf->Cell(0,12,"Q7. How much are you covered for?", 0, 0,'L');
    $pdf->Ln( 10 );  
        
    }
    
            if($data3['s2aq8']=="No") {
        
                     $pdf->Cell(0,12,"Q8. How long do you have left on the policy?", 0, 0,'L');
    $pdf->Ln( 10 );  
        
    }

                if($data3['s2aq9']=="No") {
        
                     $pdf->Cell(0,12,"Q9. Is your policy single, joint or separate?", 0, 0,'L');
    $pdf->Ln( 10 );  
        
    }
    
                if($data3['s2aq10']=="No") {
        
                     $pdf->Cell(0,12,"Q10. Have you or your partner smoked in the last 12 months?", 0, 0,'L');
    $pdf->Ln( 10 );  
        
    }
    
                if($data3['s2aq11']=="No") {
        
                     $pdf->Cell(0,12,"Q11. Have you or your partner got or has had any health issues?", 0, 0,'L');
    $pdf->Ln( 10 );  
        
    }
    
    if($data3['s2bq1']=="No") {
        $pdf->Cell(0,12,"Q1. Were all questions asked correctly?", 0, 0,'L');
        $pdf->Ln( 10 );  
        $pdf->MultiCell(0,7,"$q1s2bc1");
        $pdf->Ln( 5 );  
        
    }
    
        if($data3['q2s2bq2']=="No") {
        $pdf->Cell(0,12,"Q2. Were all questions recorded correctly?", 0, 0,'L');
        $pdf->Ln( 10 );  
        $pdf->MultiCell(0,7,"$q2s2bc2");
        $pdf->Ln( 5 );  
        
    }
    
    if($data3['q1s4q1n']=="No") {
        
                $pdf->Cell(0,12,"Q1. Did the agent stick to branding compliance?", 0, 0,'L');
        $pdf->Ln( 10 );  
        $pdf->MultiCell(0,7,"$data3[q1s4c1n]");
        $pdf->Ln( 5 );  
    }

        
    if($data3['q1s3q1']=="No") {
        
                $pdf->Cell(0,12,"Q1. Were all personal details recorded correctly?", 0, 0,'L');
        $pdf->Ln( 10 );  
        $pdf->MultiCell(0,7,"$data3[q1s3c1]");
        $pdf->Ln( 5 );  
    }

    
$pdf->Output();
    
    
}

else {

include('../includes/PDOcon.php');

$auditid = '0';
if(isset($_GET["auditid"])) $auditid = $_GET["auditid"];
 
  
$auditid=$_GET['auditid'];

$search=$_POST['search'];

$result = mysqli_query($mysqli,'SELECT * FROM `lead_gen_audit` WHERE id ="'.$search.'" OR id ="'.$auditid.'"
;');
while($row = mysqli_fetch_array($result))

{

$date_submitted=$row['date_submitted'];
$auditor=$row['auditor'];
$total=$row['total'];
$id=$row['id'];
$full_name=$row['lead_gen_name'];
$full_name2=$row['lead_gen_name2'];
$keyfield=$row['keyfield'];
$edited_by=$row['edited']; 
$policy_number=$row['policy_number']; 
$grade=$row['grade']; 
$c1=$row['c1'];
$call_opening=$row['call_opening'];
$c2=$row['c2'];
$full_info=$row['full_info'];
$c3=$row['c3'];
$obj_handled=$row['obj_handled'];
$c4=$row['c4'];
$rapport=$row['rapport'];
$c5=$row['c5'];
$dealsheet_questions=$row['dealsheet_questions'];
$c6=$row['c6'];
$brad_compl=$row['brad_compl'];
$c7=$row['c7'];



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
$rowLabels = array( "Auditor", "Closer(s)", "Date Submitted", "Policy Number" );

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
$pdf->Cell( 190, 5, " $total/6 answered correctly", 1, 3, 'C', true );
$pdf->Cell( 190, 5, " Auditor: $auditor", 1, 4, 'C', true );
$pdf->Cell( 190, 5, " Agent(s): $full_name - $full_name2", 1, 5, 'C', true );
$pdf->Cell( 190, 5, " Date Submitted: $date_submitted", 1, 6, 'C', true );
$pdf->Ln( 7 );

$pdf->AddPage();
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->SetFont( 'Helvetica', '', 10 );

//$pdf->Write(6,'Overall compliance grade');
//$pdf->Ln( 5 );
//if($grade=="Green")
//{
//$pdf->MultiCell(0,11,"$grade $c1", 0, 1);
//}
//else if ($grade=="Red")
//{
//$pdf->SetFont( 'Helvetica', 'B', 10 );
//$pdf->SetTextColor(255,0,0);
//$pdf->MultiCell(0,11,"$grade $c1", 0, 1);
//$pdf->SetFont( 'Helvetica', '', 10 );
//$pdf->SetTextColor(0,0,0);
//}

///OPENING
$pdf->Write( 6,'Auditor Comments');
$pdf->Ln( 5 );
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,11,"$c1", 0, 1);
$pdf->Ln( 5 );

$pdf->Write( 6,'1. Call opening?');
$pdf->Ln( 5 );
if($call_opening=="Excellent")
{
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,11,"$call_opening $c2", 0, 1);
}
else if($call_opening=="Good")
{
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,11,"$call_opening $c2", 0, 1);
}
else if($call_opening=="Acceptable")
{
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,11,"$call_opening $c2", 0, 1);
}
else if ($call_opening=="Unacceptable")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$call_opening $c2", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

///INFO

$pdf->Write( 6,'2. Did the agents provide full information?');
$pdf->Ln( 5 );
if($full_info=="Excellent")
{
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,11,"$full_info $c3", 0, 1);
}
else if($full_info=="Good")
{
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,11,"$full_info $c3", 0, 1);
}
else if($full_info=="Acceptable")
{
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,11,"$full_info $c3", 0, 1);
}
else if ($full_info=="Unacceptable")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$full_info $c3", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}


///OBJECTIONS

$pdf->Write( 6,'3. Objections handled');
$pdf->Ln( 5 );
if($obj_handled=="Excellent")
{
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,11,"$obj_handled $c4", 0, 1);
}
else if($obj_handled=="Good")
{
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,11,"$obj_handled $c4", 0, 1);
}
else if($obj_handled=="Acceptable")
{
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,11,"$obj_handled $c4", 0, 1);
}
else if ($obj_handled=="Unacceptable")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$obj_handled $c4", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

//////RAPPORT

$pdf->Write( 6,'4. Rapport');
$pdf->Ln( 5 );
if($rapport=="Excellent")
{
$pdf->MultiCell(0,11,"$rapport $c5", 0, 1);
}
else if($rapport=="Good")
{
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,11,"$rapport $c5", 0, 1);
}
else if($rapport=="Acceptable")
{
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,11,"$rapport $c5", 0, 1);
}
else if ($rapport=="Unacceptable")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$rapport $c5", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'5. Did the agent ask all the questions on the dealsheet?');
$pdf->Ln( 5 );
if($dealsheet_questions=="Yes")
{
$pdf->MultiCell(0,11,"$dealsheet_questions $c6", 0, 1);
}
else if ($dealsheet_questions=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$dealsheet_questions $c6", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}

$pdf->Write( 6,'6. Did the agent stick to branding compliance?');
$pdf->Ln( 5 );
if($brad_compl=="Yes")
{
$pdf->MultiCell(0,11,"$brad_compl $c7", 0, 1);
}
else if ($brad_compl=="No")
{
$pdf->SetFont( 'Helvetica', 'B', 10 );
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(0,11,"$brad_compl $c7", 0, 1);
$pdf->SetFont( 'Helvetica', '', 10 );
$pdf->SetTextColor(0,0,0);
}



$pdf->Output("Call_Audit_$id%.pdf", "I");

}
?>


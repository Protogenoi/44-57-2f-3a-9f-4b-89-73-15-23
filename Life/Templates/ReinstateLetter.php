<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php'); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../fpdf17/fpdf.php');
require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);

$clientone =filter_input(INPUT_GET, 'clientone', FILTER_SANITIZE_SPECIAL_CHARS);
$clienttwo =filter_input(INPUT_GET, 'clienttwo', FILTER_SANITIZE_SPECIAL_CHARS);
$joint =filter_input(INPUT_GET, 'joint', FILTER_SANITIZE_SPECIAL_CHARS);

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
                            $cnquery->execute()or die(print_r($query->errorInfo(), true));
                            $companydetailsq=$cnquery->fetch(PDO::FETCH_ASSOC);
                            
                            $companynamere=$companydetailsq['company_name'];
                            
                            if(isset($companynamere)) {
                                if($companynamere=='The Review Bureau') {

    $main = $pdo->prepare("SELECT CONCAT(title,' ',first_name,' ', last_name) AS NAME, CONCAT(title2,' ', first_name2,' ', last_name2) AS NAMET, address1, address2, address3, town, post_code FROM client_details WHERE client_id = :searchplaceholder");
    $main->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
    $main->execute();
    $data2=$main->fetch(PDO::FETCH_ASSOC);
    
    $NAMEONE=$data2['NAME'];
    $NAMETWO=$data2['NAMET'];
    $ADD1=$data2['address1'];
    $ADD2=$data2['address2'];
    $ADD3=$data2['address3'];
    $TOWN=$data2['town'];
    $POSTCODE=$data2['post_code'];
    
    $TODAY = date("Y-m-d");
    

 

class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

function WriteHTML($html)
    {
        //HTML parser
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                elseif($this->ALIGN=='right')
                    $this->Cell(0,5,$e,0,1,'R');
                else
                    $this->Write(5,$e);
                
            }
            
            
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract properties
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$prop);
                }
            }
        }
    }

    function OpenTag($tag,$prop)
    {
        //Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(5);
        if($tag=='P')
            $this->ALIGN=$prop['ALIGN'];
        if($tag=='HR')
        {
            if( !empty($prop['WIDTH']) )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
    }

    function SetStyle($tag,$enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }

    function PutLink($URL,$txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }

    function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'The Review Bureau LTD. Registered in England and Wales with registered number 08519932.',0,0,'C');
    $this->Ln( 5 );
    $this->Cell(0,10,'Registered office: 4th Floor The Post House, Adelaide Street, SA1 1SB.',0,0,'C');
    
    
}
    
}


$html = '
<br /><br><p>As you may be aware there has been an issue with the direct debit for your Legal & General life insurance. I have enclosed two forms that need to be completed in order for your policy to continue.</p>
<br /><br><p>The first document is a Declaration of Reinstatement form; this must be completed to let Legal & General know if you have developed any health conditions or lifestyle changes that may affect the terms of your cover.</p>
<br /><br><p>I have also enclosed a direct debit mandate for you to complete so your direct debit can be reinstated. Once received Legal and General will reinstate the direct debit and usually attempt a payment for any arrears in about 10-14 working days.</p>
<br /><br><p>Please fill in these forms using block capitals and in blue or black ink and once fully completed please sign and return to the freepost address using the envelope enclosed.</p>
<br /><br><p>If you have any queries please do not hesitate to contact our customer care team on 0845 095 0041.</p>

<br /><br>
<br /><br>';

$pdf = new PDF('P','mm','A4');


// First page
$pdf->AddPage();
$pdf->SetMargins(30, 20 ,30);
$pdf->SetFont('Times','',12);
if(file_exists("../../img/rblogonew.png")){ 
$pdf->Image('../../img/rblogonew.png',140,6,40);
}
else{
 $pdf->Cell("COMPANY LOGO",140,6,40);   
}
$pdf->Ln( 5 );

$pdf->Cell(0,12,"The Review Bureau", 0, 0,'R');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"4th Floor The Post House", 0, 0,'R');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"Adelaide Street", 0, 0,'R');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"Swansea", 0, 0,'R');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"SA1 1SB", 0, 0,'R');
$pdf->Ln( 10 );
$pdf->Cell(0,12,"$TODAY", 0, 0,'R');
$pdf->Ln( 5 );


if(isset($clientone)) {
    if($clientone=='1') {
       $pdf->Cell(0,12,"$NAMEONE ", 0, 0,'L');
       $pdf->Ln( 5 ); 
    }
}

if(isset($clienttwo)) {
    if($clienttwo=='1') {
       $pdf->Cell(0,12,"$NAMETWO ", 0, 0,'L');
       $pdf->Ln( 5 ); 
    }
}

if(isset($joint)) {
    if($joint=='1') {
        
        $pdf->Cell(0,12,"$NAMEONE & $NAMETWO ", 0, 0,'L'); 
        $pdf->Ln( 5 ); 
        
    }
    
    }

if(!empty($ADD1)) {
    $pdf->Cell(0,12,"$ADD1 ", 0, 0,'L');
    $pdf->Ln( 5 );
}

if(!empty($ADD2)) {
    $pdf->Cell(0,12,"$ADD2 ", 0, 0,'L');
    $pdf->Ln( 5 );
}

if(!empty($ADD3)) {
    $pdf->Cell(0,12,"$ADD3 ", 0, 0,'L');
    $pdf->Ln( 5 );
}

if(!empty($TOWN)) {
    $pdf->Cell(0,12,"$TOWN ", 0, 0,'L');
    $pdf->Ln( 5 );
}

if(!empty($POSTCODE)) {
    $pdf->Cell(0,12,"$POSTCODE ", 0, 0,'L');
    $pdf->Ln( 15 );
}

$pdf->WriteHTML($html);

if(isset($hello_name)) {
    
     switch ($hello_name) {
         case "Michael":
             $hello_name_full="Michael Owen";
             break;
         case "Jakob":
             $hello_name_full="Jakob Lloyd";
             break;
         case "leighton":
             $hello_name_full="Leighton Morris";
             break;
         case "Roxy":
             $hello_name_full="Roxanne Studholme";
             break;
         case "Nicola":
             $hello_name_full="Nicola Griffiths";
             break;
         case "Rhibayliss":
             $hello_name_full="Rhiannon Bayliss";
             break;
         case "Amelia":
             $hello_name_full="Amelia Pike";
             break;
         case "Abbiek":
             $hello_name_full="Abbie Kenyon";
             break;
         case "carys":
             $hello_name_full="Carys Riley";
             break;
         case "Matt":
             $hello_name_full="Matthew Jones";
             break;
         case "Tina":
             $hello_name_full="Tina Dennis";
             break;
         case "Nick":
             $hello_name_full="Nick Dennis";
             break;
        case "Amy":
             $hello_name_full="Amy Clayfield";
             break;
        case "Georgia":
             $hello_name_full="Georgia Davies";
             break;
                           case "Victoria":
             $hello_name_full="Victoria Hubbert";
             break;
         default:
             $hello_name_full=$hello_name;
             
     }
     
     }





$pdf->Cell(0,12,"Many thanks", 0, 0,'L');
$pdf->Ln( 10 );
$pdf->Cell(0,12,"$hello_name_full", 0, 0,'L');

$pdf->Output();

        }

        if($companynamere=='Assura') {
            $search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);

    $main = $pdo->prepare("SELECT CONCAT(title,' ',first_name,' ', last_name) AS NAME, CONCAT(title2,' ', first_name2,' ', last_name2) AS NAMET, address1, address2, address3, town, post_code FROM client_details WHERE client_id = :searchplaceholder");
    $main->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
    $main->execute();
    $data2=$main->fetch(PDO::FETCH_ASSOC);
    
    $NAMEONE=$data2['NAME'];
    $NAMETWO=$data2['NAMET'];
    $ADD1=$data2['address1'];
    $ADD2=$data2['address2'];
    $ADD3=$data2['address3'];
    $TOWN=$data2['town'];
    $POSTCODE=$data2['post_code'];
    
    $TODAY = date("Y-m-d");
    

 

class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

function WriteHTML($html)
    {
        //HTML parser
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                elseif($this->ALIGN=='right')
                    $this->Cell(0,5,$e,0,1,'R');
                else
                    $this->Write(5,$e);
                
            }
            
            
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract properties
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$prop);
                }
            }
        }
    }

    function OpenTag($tag,$prop)
    {
        //Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(5);
        if($tag=='P')
            $this->ALIGN=$prop['ALIGN'];
        if($tag=='HR')
        {
            if( !empty($prop['WIDTH']) )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
    }

    function SetStyle($tag,$enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }

    function PutLink($URL,$txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }

    function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Assura is a trading name of CJTD Limited investments, registered in England and Wales with registered number 08403633.',0,0,'C');
    $this->Ln( 5 );
    $this->Cell(0,10,'Registered office: Churchill house, 120 Bunns Lane, London, NW7 2AS.',0,0,'C');
    
    
}
    
}


$html = '
<br /><br><p>Please find enclosed your Discretionary Trust Deed, as discussed you can use this to name the people you would like to leave the money to if something should happen to you within the term of your policy.</p>
<br /><br><p>Please fill this form in using block capitals and in blue or black ink.</p>
<br /><br><p>I have also included an optional Letter of Wishes should you wish to provide instructions for your Truestee/s.</p>
<br /><br><p>Once fully completed, please sign and return using the cover letter at the back of the forms. Please note, the return address is freepost so you do not have to use a stamp.</p>
<br /><br><p>If you have any queries please do not hesitate to contact our customer care team on 03334 432 484.</p>

<br /><br>
<br /><br>';

$pdf = new PDF('P','mm','A4');


// First page
$pdf->AddPage();
$pdf->SetMargins(30, 20 ,30);
$pdf->SetFont('Times','',12);
$pdf->Image('../../img/assuralogo.png',155,6,30);

$pdf->Ln( 10 );
$pdf->Cell(0,12,"Assura", 0, 0,'R');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"4th Floor The Post House", 0, 0,'R');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"Adelaide Street", 0, 0,'R');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"Swansea", 0, 0,'R');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"SA1 1SB", 0, 0,'R');
$pdf->Ln( 10 );
$pdf->Cell(0,12,"$TODAY", 0, 0,'R');
$pdf->Ln( 5 );




if(!empty($NAMETWO)) {
$pdf->Cell(0,12,"$NAMEONE ", 0, 0,'L');
$pdf->Ln( 5 );
}
else {
 $pdf->Cell(0,12,"$NAMEONE & $NAMETWO ", 0, 0,'L');  
$pdf->Ln( 5 ); 
}

if(!empty($ADD1)) {
    $pdf->Cell(0,12,"$ADD1 ", 0, 0,'L');
    $pdf->Ln( 5 );
}

if(!empty($ADD2)) {
    $pdf->Cell(0,12,"$ADD2 ", 0, 0,'L');
    $pdf->Ln( 5 );
}

if(!empty($ADD3)) {
    $pdf->Cell(0,12,"$ADD3 ", 0, 0,'L');
    $pdf->Ln( 5 );
}

if(!empty($TOWN)) {
    $pdf->Cell(0,12,"$TOWN ", 0, 0,'L');
    $pdf->Ln( 5 );
}

if(!empty($POSTCODE)) {
    $pdf->Cell(0,12,"$POSTCODE ", 0, 0,'L');
    $pdf->Ln( 15 );
}

$pdf->WriteHTML($html);

$pdf->Cell(0,12,"Many thanks", 0, 0,'L');
$pdf->Ln( 10 );
$pdf->Cell(0,12,"$hello_name", 0, 0,'L');

$pdf->Output();

        }
        
                                if($companynamere=='ADL_CUS') {

    $main = $pdo->prepare("SELECT CONCAT(title,' ',first_name,' ', last_name) AS NAME, CONCAT(title2,' ', first_name2,' ', last_name2) AS NAMET, address1, address2, address3, town, post_code FROM client_details WHERE client_id = :searchplaceholder");
    $main->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
    $main->execute();
    $data2=$main->fetch(PDO::FETCH_ASSOC);
    
    $NAMEONE=$data2['NAME'];
    $NAMETWO=$data2['NAMET'];
    $ADD1=$data2['address1'];
    $ADD2=$data2['address2'];
    $ADD3=$data2['address3'];
    $TOWN=$data2['town'];
    $POSTCODE=$data2['post_code'];
    
    $TODAY = date("Y-m-d");
    

 

class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

function WriteHTML($html)
    {
        //HTML parser
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                elseif($this->ALIGN=='right')
                    $this->Cell(0,5,$e,0,1,'R');
                else
                    $this->Write(5,$e);
                
            }
            
            
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract properties
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$prop);
                }
            }
        }
    }

    function OpenTag($tag,$prop)
    {
        //Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(5);
        if($tag=='P')
            $this->ALIGN=$prop['ALIGN'];
        if($tag=='HR')
        {
            if( !empty($prop['WIDTH']) )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
    }

    function SetStyle($tag,$enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }

    function PutLink($URL,$txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }

    function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'The Financial Assessment Centre LTD. Registered in England and Wales with registered number 10591406.',0,0,'C');
    $this->Ln( 5 );
    $this->Cell(0,10,'Registered office: Suite 1E, The Post House, Adelaide Street, SA1 1SB.',0,0,'C');
    
    
}
    
}


$html = '
<br /><br><p>As you may be aware there has been an issue with the direct debit for your Legal & General life insurance. I have enclosed two forms that need to be completed in order for your policy to continue.</p>
<br /><br><p>The first document is a Declaration of Reinstatement form; this must be completed to let Legal & General know if you have developed any health conditions or lifestyle changes that may affect the terms of your cover.</p>
<br /><br><p>I have also enclosed a direct debit mandate for you to complete so your direct debit can be reinstated. Once received Legal and General will reinstate the direct debit and usually attempt a payment for any arrears in about 10-14 working days.</p>
<br /><br><p>Please fill in these forms using block capitals and in blue or black ink and once fully completed please sign and return to the freepost address using the envelope enclosed.</p>
<br /><br><p>If you have any queries please do not hesitate to contact our customer care team on 02036 349 515.</p>

<br /><br>
<br /><br>';

$pdf = new PDF('P','mm','A4');


// First page
$pdf->AddPage();
$pdf->SetMargins(30, 20 ,30);
$pdf->SetFont('Times','',12);
$pdf->Image('../../uploads/LoginLogo.jpg',140,6,40);
$pdf->Ln( 5 );

$pdf->Cell(0,12,"The Financial Assessment Centre", 0, 0,'R');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"Suite 1E, The Post House", 0, 0,'R');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"Adelaide Street", 0, 0,'R');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"Swansea", 0, 0,'R');
$pdf->Ln( 5 );
$pdf->Cell(0,12,"SA1 1SB", 0, 0,'R');
$pdf->Ln( 10 );
$pdf->Cell(0,12,"$TODAY", 0, 0,'R');
$pdf->Ln( 5 );


if(isset($clientone)) {
    if($clientone=='1') {
       $pdf->Cell(0,12,"$NAMEONE ", 0, 0,'L');
       $pdf->Ln( 5 ); 
    }
}

if(isset($clienttwo)) {
    if($clienttwo=='1') {
       $pdf->Cell(0,12,"$NAMETWO ", 0, 0,'L');
       $pdf->Ln( 5 ); 
    }
}

if(isset($joint)) {
    if($joint=='1') {
        
        $pdf->Cell(0,12,"$NAMEONE & $NAMETWO ", 0, 0,'L'); 
        $pdf->Ln( 5 ); 
        
    }
    
    }

if(!empty($ADD1)) {
    $pdf->Cell(0,12,"$ADD1 ", 0, 0,'L');
    $pdf->Ln( 5 );
}

if(!empty($ADD2)) {
    $pdf->Cell(0,12,"$ADD2 ", 0, 0,'L');
    $pdf->Ln( 5 );
}

if(!empty($ADD3)) {
    $pdf->Cell(0,12,"$ADD3 ", 0, 0,'L');
    $pdf->Ln( 5 );
}

if(!empty($TOWN)) {
    $pdf->Cell(0,12,"$TOWN ", 0, 0,'L');
    $pdf->Ln( 5 );
}

if(!empty($POSTCODE)) {
    $pdf->Cell(0,12,"$POSTCODE ", 0, 0,'L');
    $pdf->Ln( 15 );
}

$pdf->WriteHTML($html);

if(isset($hello_name)) {
    
     switch ($hello_name) {
         case "Michael":
             $hello_name_full="Michael Owen";
             break;
         case "Dean":
             $hello_name_full="Dean Howell";
             break;
         case "Helen":
             $hello_name_full="Helen Hinder";
             break;
         case "Andrew":
             $hello_name_full="Andrew Collier";
             break;
         case "David":
             $hello_name_full="David Govier";
             break;
         default:
             $hello_name_full=$hello_name;
             
     }
     
     }





$pdf->Cell(0,12,"Many thanks", 0, 0,'L');
$pdf->Ln( 10 );
$pdf->Cell(0,12,"$hello_name_full", 0, 0,'L');

$pdf->Output();

        }
    }
    
?>
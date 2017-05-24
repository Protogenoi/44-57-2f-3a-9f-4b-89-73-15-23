<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php'); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../dompdf-master/autoload.inc.php');
require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}
                     
                            use Dompdf\Dompdf;

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
         case "Mike":
             $hello_name_full="Michael Lloyd";
             break;
                  case "Victoria":
             $hello_name_full="Victoria Hubbert";
             break;
         default:
             $hello_name_full=$hello_name;
             
     }
     
     }


                            
                            $dompdf = new Dompdf();
                            $dompdf->loadHtml('<style>
                                
header, .full-width {
  width: 100%;
  background: #6871b1;
}
.wrap {
  width: 90%;
  max-width: 40em;
  margin: 0 auto;
}
      body {
font-size: 95%;
}
.divSubject {
                clear: both;
                font-weight: bold;
                padding-top: 20px;
            }
</style>



     <div align="right">
     <img src="../../img/rblogonew.png" alt="COMPANY LOGO" width="150"><br/>
            The Review Bureau<br/>
            4th Floor The Post House<br/>
            Adelaide Street<br/>  
                Swansea<br/> 
                    SA1 1SB<br/> 
                    
<div>
  <div style="float:right">Main Tel: 08450 950 041<br/> 
Alt Tel: 01792 735 002<br/> 
Email: <a href="mailto:info@thereviewbureau.com" style="background-color: rgb(255, 255, 255);">info@thereviewbureau.com</a><br/> 
            <br/>
           <time datetime="'.$TODAY.'"> '.$TODAY.'</time></div>
  <div style="float:left" align="left">                 '.(!empty($clientone) ? $NAMEONE."" : '').'   
                '.(!empty($clienttwo) ? $NAMETWO."" : '').' 
                    '.(!empty($joint) ? "$NAMEONE & $NAMETWO"."" : '').'<br/>
            '.(!empty($ADD1) ? $ADD1."<br/>" : '').' 
            '.(!empty($ADD2) ? $ADD2."<br/>" : '').' 
            '.(!empty($ADD3) ? $ADD3."<br/>" : '').' 
              '.(!empty($TOWN) ? $TOWN."<br/>" : '').' 
                   '.(!empty($POSTCODE) ? $POSTCODE."<br/>" : '').'   </div>
</div>
<br/>

        </div>

    
        <div class="divSubject">
            '.(!empty($clientone) ? $NAMEONE.": Life Insurance Trust Guide" : '').'   
                '.(!empty($clienttwo) ? $NAMETWO.": Life Insurance Trust Guide" : '').' 
                    '.(!empty($joint) ? "$NAMEONE & $NAMETWO".": Life Insurance Trust Guide" : '').'
        </div>
        
<p>Thank for you choosing to put your policy/policies into trust. There are three main benefits of putting your life insurance policy into trust.</p>
<ol>
<li style="margin-bottom: 0.28cm; line-height: 108%;"><b>Avoiding Inheritance Tax</b> - When a life policy is not held in trust, it will normally be considered part of your estate, meaning that it can be subject to
	inheritance tax. Using a trust will mean your life policy will not be part of your estate - <b>Increasing the amount of money passed onto your loved ones.</b></li>
        <li style="margin-bottom: 0.28cm; line-height: 108%;"><b>Faster	payment of the money</b> - Using a trust should help ensure that the<b> money paid out from your life insurance can be paid to the people of your
	choice</b> quicker, without the money being held up in the estate waiting for lengthy legal processes, such as gaining a grant of probate.</li>
        <li style="margin-bottom: 0.28cm; line-height: 108%;"><b>Control- </b>You specify who your beneficiaries are, and who you trust to act on your wishes</li>
        </ol>
<p>Included in this pack are the trust forms for your policy (or policies), we have included a very simple guide on how to fill out the forms, the document may look daunting, but, it only takes a couple of minutes to fill out.</p>
<p>If you have any issues or questions regarding the Trust, then please do not hesisitate to contact us. We will be more than happy to guide you through the forms.</p>
<p>If you have more than one policy, each policy needs to be put into Trust individually, hence why you may have multiple trust forms included in the pack.</p>

<p>Thank you,<br>'.$hello_name_full.'</p>


<div style="page-break-after: always;"></div>



<h1 style="text-align: center; margin-bottom: 0.28cm; line-height: 108%;"><span style="font-size: 12pt; color: inherit; font-family: inherit;"><b>TRUST FORM GUIDE-PAGE BY PAGE</b></span></h1>
<p></p>
<p style="text-align: center; margin-bottom: 0.28cm; line-height: 108%;"><font size="3" style="font-size: 12pt" color="#ff0000"><b>Sections
which need be filled in, are in bold text.</b></font></p>


<h3 class="full-width">
  <div class="wrap">Page 1</div>
</h3>
<div class="wrap">
  <p>This page has been prefilled for your convenience - there is <b>a tick box check list to be filled in</b> on this page to ensure everything has been filled out correctly, before you send the form back.</p>
</div>

<h3 class="full-width">
  <div class="wrap">Page 2</div>
</h3>
<div class="wrap">
  <p>Important notes regarding a trust, nothing needs to be filled out here.</p>
</div>

<h3 class="full-width">
  <div class="wrap">Page 3</div>
</h3>
<div class="wrap">
  <p>Please <b>insert the date</b> into the top of the trust when you fill out the form. We have prefilled the details of the “Settlors” for your convenience. <b>Please fill out the trustees</b>, a trustee can be anyone over the age of 18 and of sound mind, it is a good idea to have at least two trustees - the trustee needs to be someone who you believe will act in the interest of your beneficiaries. Please note, with a joint policy, both policy holders (“settlors”) will automatically be trustees.</p>
</div>

<h3 class="full-width">
  <div class="wrap">Page 4</div>
</h3>
<div class="wrap">
  <p><b>Please fill out the “beneficiaries” of the policy</b>, you can also name the trust at the bottom if you wish (optional).</p>
</div>

<h3 class="full-width">
  <div class="wrap">Page 5 - 7</div>
</h3>
<div class="wrap">
  <p>You do not have to fill anything out on these pages. We have prefilled the schedule of the policy for your convenience.</p>
</div>

<h3 class="full-width">
  <div class="wrap">Page 8</div>
</h3>
<div class="wrap">
  <p><b>Please sign in the box below your name(or names for a joint policy)</b> , your signatures must be witnessed by an independent adult witness. Please note the witness cannot be someone named in the trust or your spouse. <b>The witness must then fill out the following sections</b>:
<ul>
<b><li>3 - Their full name.</li>
<li>4 - The witness signature.</li>
<li>5 - The address of the witness.</li>
<li>6 - The date they signed.</li></b>
</ul></p>
</div>
<p><br></p>
<div id="footer"><center><i><font size="1">The Review Bureau LTD. Registered in England and Wales with registered number 08519932.<br> Registered office: 4th Floor The Post House, Adelaide Street, SA1 1SB </font></i></center></div>

<style type="text/css">
		@page { margin: 2cm }
		p { margin-bottom: 0.25cm; direction: ltr; line-height: 120%; text-align: left; orphans: 2; widows: 2 }
		a:link { color: #0563c1 }
	</style>
		');

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


                            
                            $dompdf = new Dompdf();
                            $dompdf->loadHtml('<style>
                                
header, .full-width {
  width: 100%;
  background: #6871b1;
}
.wrap {
  width: 90%;
  max-width: 40em;
  margin: 0 auto;
}
      body {
font-size: 95%;
}
.divSubject {
                clear: both;
                font-weight: bold;
                padding-top: 20px;
            }
</style>



     <div align="right">
     <img src="../../uploads/LoginLogo.jpg" alt="COMPANY LOGO" width="150"><br/>
            The Financial Assessment Centre<br/>
            Suite 1E, The Post House<br/>
            Adelaide Street<br/>  
                Swansea<br/> 
  <div style="float:right">                  SA1 1SB
<br/>
Main Tel: 02036 349 515<br/> 
Alt Tel: 07554 844 444<br/> 
Email: <a href="mailto:info@thereviewdepartment.co.uk" style="background-color: rgb(255, 255, 255);">info@thereviewdepartment.co.uk</a><br/> 
           
           <time datetime="'.$TODAY.'"> '.$TODAY.'</time></div>
               
  <div style="float:left" align="left">                 '.(!empty($clientone) ? $NAMEONE."" : '').'   
                '.(!empty($clienttwo) ? $NAMETWO."" : '').' 
                    '.(!empty($joint) ? "$NAMEONE & $NAMETWO"."" : '').'<br/>
            '.(!empty($ADD1) ? $ADD1."<br/>" : '').' 
            '.(!empty($ADD2) ? $ADD2."<br/>" : '').' 
            '.(!empty($ADD3) ? $ADD3."<br/>" : '').' 
              '.(!empty($TOWN) ? $TOWN."<br/>" : '').' 
                   '.(!empty($POSTCODE) ? $POSTCODE."<br/>" : '').'   </div>
</div>
<br/>

        </div>
        
        <div class="divSubject">
            '.(!empty($clientone) ? $NAMEONE.": Life Insurance Trust Guide" : '').'   
                '.(!empty($clienttwo) ? $NAMETWO.": Life Insurance Trust Guide" : '').' 
                    '.(!empty($joint) ? "$NAMEONE & $NAMETWO".": Life Insurance Trust Guide" : '').'
        </div>

<p>Thank for you choosing to put your policy/policies into trust. There are three main benefits of putting your life insurance policy into trust.</p>
<ol>
<li style="margin-bottom: 0.28cm; line-height: 108%;"><b>Avoiding Inheritance Tax</b> - When a life policy is not held in trust, it will normally be considered part of your estate, meaning that it can be subject to
	inheritance tax. Using a trust will mean your life policy will not be part of your estate - <b>Increasing the amount of money passed onto your loved ones.</b></li>
        <li style="margin-bottom: 0.28cm; line-height: 108%;"><b>Faster	payment of the money</b> - Using a trust should help ensure that the<b> money paid out from your life insurance can be paid to the people of your
	choice</b> quicker, without the money being held up in the estate waiting for lengthy legal processes, such as gaining a grant of probate.</li>
        <li style="margin-bottom: 0.28cm; line-height: 108%;"><b>Control- </b>You specify who your beneficiaries are, and who you trust to act on your wishes</li>
        </ol>
<p>Included in this pack are the trust forms for your policy (or policies), we have included a very simple guide on how to fill out the forms, the document may look daunting, but, it only takes a couple of minutes to fill out.</p>
<p>If you have any issues or questions regarding the Trust, then please do not hesisitate to contact us. We will be more than happy to guide you through the forms.</p>
<p>If you have more than one policy, each policy needs to be put into Trust individually, hence why you may have multiple trust forms included in the pack.</p>

<p>Thank you,<br>'.$hello_name_full.'</p>

<div style="page-break-after: always;"></div>

<h1 style="text-align: center; margin-bottom: 0.28cm; line-height: 108%;"><span style="font-size: 12pt; color: inherit; font-family: inherit;"><b>TRUST FORM GUIDE-PAGE BY PAGE</b></span></h1>
<p></p>
<p style="text-align: center; margin-bottom: 0.28cm; line-height: 108%;"><font size="3" style="font-size: 12pt" color="#ff0000"><b>Sections
which need be filled in, are in bold text.</b></font></p>


<h3 class="full-width">
  <div class="wrap">Page 1</div>
</h3>
<div class="wrap">
  <p>This page has been prefilled for your convenience - there is <b>a tick box check list to be filled in</b> on this page to ensure everything has been filled out correctly, before you send the form back.</p>
</div>

<h3 class="full-width">
  <div class="wrap">Page 2</div>
</h3>
<div class="wrap">
  <p>Important notes regarding a trust, nothing needs to be filled out here.</p>
</div>

<h3 class="full-width">
  <div class="wrap">Page 3</div>
</h3>
<div class="wrap">
  <p>Please <b>insert the date</b> into the top of the trust when you fill out the form. We have prefilled the details of the “Settlors” for your convenience. <b>Please fill out the trustees</b>, a trustee can be anyone over the age of 18 and of sound mind, it is a good idea to have at least two trustees - the trustee needs to be someone who you believe will act in the interest of your beneficiaries. Please note, with a joint policy, both policy holders (“settlors”) will automatically be trustees.</p>
</div>

<h3 class="full-width">
  <div class="wrap">Page 4</div>
</h3>
<div class="wrap">
  <p><b>Please fill out the “beneficiaries” of the policy</b>, you can also name the trust at the bottom if you wish (optional).</p>
</div>

<h3 class="full-width">
  <div class="wrap">Page 5 - 7</div>
</h3>
<div class="wrap">
  <p>You do not have to fill anything out on these pages. We have prefilled the schedule of the policy for your convenience.</p>
</div>

<h3 class="full-width">
  <div class="wrap">Page 8</div>
</h3>
<div class="wrap">
  <p><b>Please sign in the box below your name (or names for a joint policy)</b>, your signatures must be witnessed by an independent adult witness. Please note the witness cannot be someone named in the trust or your spouse. <b>The witness must then fill out the following sections</b>:
<ul>
<b><li>3 - Their full name.</li>
<li>4 - The witness signature.</li>
<li>5 - The address of the witness.</li>
<li>6 - The date they signed.</li></b>
</ul></p>
</div>


<style type="text/css">
		@page { margin: 2cm }
		p { margin-bottom: 0.25cm; direction: ltr; line-height: 120%; text-align: left; orphans: 2; widows: 2 }
		a:link { color: #0563c1 }
	</style>

		');


}
$dompdf->setPaper('Letter');
$dompdf->render();
$dompdf->stream('Trust_Guide.pdf',array('Attachment'=>0));
                            }
                            
?>
<div id="footer"><center>T<i><font size="1">he Financial Assessment Centre LTD. Registered in England and Wales with registered number 10591406.<br> Registered office: Suite 1E, The Post House, Adelaide Street, SA1 1SB </font></i></center></div>

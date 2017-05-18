<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/PDOcon.php');

    $life= filter_input(INPUT_GET, 'life', FILTER_SANITIZE_SPECIAL_CHARS);
    $legacy= filter_input(INPUT_GET, 'legacy', FILTER_SANITIZE_SPECIAL_CHARS);
    $pba= filter_input(INPUT_GET, 'pba', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($pba)) {
            if($pba=='y') {
        include('../classes/database_class.php');
        $search= filter_input(INPUT_POST, 'keyfield', FILTER_SANITIZE_SPECIAL_CHARS);
        $title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $first= filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $last= filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
        $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $tel= filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
        $tel2= filter_input(INPUT_POST, 'tel2', FILTER_SANITIZE_SPECIAL_CHARS);
        $tel3= filter_input(INPUT_POST, 'tel3', FILTER_SANITIZE_SPECIAL_CHARS);
        $title2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_SPECIAL_CHARS);
        $first2= filter_input(INPUT_POST, 'firstname2', FILTER_SANITIZE_SPECIAL_CHARS);
        $last2= filter_input(INPUT_POST, 'lastname2', FILTER_SANITIZE_SPECIAL_CHARS);
        $dob2= filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_SPECIAL_CHARS);
        $email2= filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_SPECIAL_CHARS);
        $add1= filter_input(INPUT_POST, 'add1', FILTER_SANITIZE_SPECIAL_CHARS);
        $add2= filter_input(INPUT_POST, 'add2', FILTER_SANITIZE_SPECIAL_CHARS);
        $add3= filter_input(INPUT_POST, 'add3', FILTER_SANITIZE_SPECIAL_CHARS);
        $town= filter_input(INPUT_POST, 'town', FILTER_SANITIZE_SPECIAL_CHARS);
        $post= filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $correct_dob = date("Y-m-d" , strtotime($dob)); 
        $correct_dob2 = date("Y-m-d" , strtotime($dob2));
        
        $database = new Database(); 
            
            $database->query("UPDATE pba_client_details set title=:title, firstname=:first, lastname=:last, dob=:dob, email=:email, tel=:tel, tel2=:tel2, tel3=:tel3, title2=:title2, firstname2=:first2, lastname2=:last2, dob2=:dob2, email2=:email2, add1=:add1, add2=:add2, add3=:add3, town=:town, post_code=:post, recent_edit=:hello WHERE client_id=:id");
            $database->bind(':id', $search);
            $database->bind(':title', $title);
            $database->bind(':first',$first);
            $database->bind(':last',$last);
            $database->bind(':dob',$correct_dob);
            $database->bind(':email',$email);
            $database->bind(':tel',$tel);
            $database->bind(':tel2',$tel2);
            $database->bind(':tel3',$tel3);
            $database->bind(':title2', $title2);
            $database->bind(':first2',$first2);
            $database->bind(':last2',$last2);
            $database->bind(':dob2',$correct_dob2);
            $database->bind(':email2',$email2);
            $database->bind(':add1',$add1);
            $database->bind(':add2',$add2);
            $database->bind(':add3',$add3);
            $database->bind(':town',$town);
            $database->bind(':post',$post);
            $database->bind(':hello',$hello_name);
            $database->execute();  

            
            if ($database->rowCount()>=1) {
            
                header('Location: ../EditClient.php?Clientadded=1&search='.$search.'&pba'); die;
                
            }
            
            else {
             
                header('Location: ../EditClient.php?Clientadded=0&search='.$search.'&pba'); die;
                
            }
            
        }
    }
    
    if(isset($life)) {
        if($life=='y') {

$title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
$first_name= filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
$last_name= filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
$dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
$email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$phone_number= filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_SPECIAL_CHARS);
$alt_number= filter_input(INPUT_POST, 'alt_number', FILTER_SANITIZE_SPECIAL_CHARS);
$dob2= filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_SPECIAL_CHARS);
$email2= filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_SPECIAL_CHARS);
$address1= filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
$address2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
$address3= filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_SPECIAL_CHARS);
$town= filter_input(INPUT_POST, 'town', FILTER_SANITIZE_SPECIAL_CHARS);
$post_code= filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_SPECIAL_CHARS);
$leadid1= filter_input(INPUT_POST, 'leadid1', FILTER_SANITIZE_SPECIAL_CHARS);
$leadid2= filter_input(INPUT_POST, 'leadid2', FILTER_SANITIZE_SPECIAL_CHARS);
$leadid3= filter_input(INPUT_POST, 'leadid3', FILTER_SANITIZE_SPECIAL_CHARS);
$callauditid= filter_input(INPUT_POST, 'callauditid', FILTER_SANITIZE_SPECIAL_CHARS);
$leadauditid= filter_input(INPUT_POST, 'leadauditid', FILTER_SANITIZE_SPECIAL_CHARS);
$leadid12= filter_input(INPUT_POST, 'leadid12', FILTER_SANITIZE_SPECIAL_CHARS);
$leadid22= filter_input(INPUT_POST, 'leadid22', FILTER_SANITIZE_SPECIAL_CHARS);
$leadid32= filter_input(INPUT_POST, 'leadid32', FILTER_SANITIZE_SPECIAL_CHARS);
$title2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_SPECIAL_CHARS);
$first_name2= filter_input(INPUT_POST, 'first_name2', FILTER_SANITIZE_SPECIAL_CHARS);
$last_name2= filter_input(INPUT_POST, 'last_name2', FILTER_SANITIZE_SPECIAL_CHARS);
$callauditid2= filter_input(INPUT_POST, 'callauditid2', FILTER_SANITIZE_SPECIAL_CHARS);
$leadauditid2= filter_input(INPUT_POST, 'leadauditid2', FILTER_SANITIZE_SPECIAL_CHARS);
$company= filter_input(INPUT_POST, 'company', FILTER_SANITIZE_SPECIAL_CHARS);
$keyfield= filter_input(INPUT_POST, 'keyfield', FILTER_SANITIZE_SPECIAL_CHARS);
$lead= filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_SPECIAL_CHARS);
$closer= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_SPECIAL_CHARS);
$changereason= filter_input(INPUT_POST, 'changereason', FILTER_SANITIZE_SPECIAL_CHARS);
$dealsheet_id= filter_input(INPUT_POST, 'dealsheet_id', FILTER_SANITIZE_SPECIAL_CHARS);

$query = $pdo->prepare("SELECT CONCAT(title, ' ', first_name, ' ',last_name) AS orig_name, CONCAT(title2, ' ', first_name2, ' ',last_name2) AS orig_name2 FROM client_details WHERE client_id=:origidholder");
$query->bindParam(':origidholder',$keyfield, PDO::PARAM_INT);
$query->execute(); 
$origdetails=$query->fetch(PDO::FETCH_ASSOC);

$oname=$origdetails['orig_name'];
$oname2=$origdetails['orig_name2'];

$sql = "UPDATE client_details
SET
dealsheet_id='$dealsheet_id',
title='$title',
first_name='$first_name',
last_name='$last_name',
dob='$dob',
email='$email',
phone_number='$phone_number',
alt_number='$alt_number',
title2='$title2',
first_name2='$first_name2',
last_name2='$last_name2',
dob2='$dob2',
email2='$email2',
address1='$address1',
address2='$address2',
address3='$address3',
town='$town',
post_code='$post_code',
leadid1='$leadid1',
leadid2='$leadid2',
leadid3='$leadid3',
callauditid='$callauditid',
leadauditid='$leadauditid',
leadid12='$leadid12',
leadid22='$leadid22',
leadid32='$leadid32',
callauditid2='$callauditid2',
leadauditid2='$leadauditid2',
date_edited=CURRENT_TIMESTAMP,
recent_edit='$hello_name' ,
recent_edit='$closer' ,
company='$company',    
recent_edit='$lead' 
WHERE client_id='$keyfield' ";

if (mysqli_query($conn, $sql)) {

$clientnamedata= "CRM Alert";   
$notedata= "Client Details Updated";


$query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
$query->bindParam(':clientidholder',$keyfield, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$changereason, PDO::PARAM_STR, 2500);
$query->execute(); 

    $clientnamedatas=$title ." ". $first_name ." ". $last_name;
    $clientnamedatas2=$title2 ." ". $first_name2 ." ". $last_name2;
    
   $changereason= filter_input(INPUT_POST, 'changereason', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($changereason)){
    
      $changereason= filter_input(INPUT_POST, 'changereason', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($changereason =='Incorrect Client Name') {
        
        $query = $pdo->prepare("UPDATE client_note set client_name=:recipientholder WHERE client_name =:orignameholder");
        $query->bindParam(':recipientholder',$clientnamedatas, PDO::PARAM_STR, 500);
        $query->bindParam(':orignameholder',$oname, PDO::PARAM_STR, 500);
        $query->execute(); 

    }
    
        if ($changereason =='Incorrect Client Name 2') {

            $query = $pdo->prepare("UPDATE client_note set client_name=:recipientholders WHERE client_name =:orignameholders");
            $query->bindParam(':recipientholders',$clientnamedatas2, PDO::PARAM_STR, 500);
            $query->bindParam(':orignameholders',$oname2, PDO::PARAM_STR, 500);
            $query->execute(); 
            
    }
}
    if(isset($fferror)) {
    if($fferror=='0') {
   header('Location: ../Life/ViewClient.php?clientedited=y&search='.$keyfield); die;
    }
    }
    
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    
    if(isset($fferror)) {
    if($fferror=='0') {
    
    header('Location: ../Life/ViewClient.php?clientedited=n&search='.$keyfield); die;
    }
    }
}

        }
    }
    
        if(isset($legacy)) {
        if($legacy=='y') {
            
            $clientid= filter_input(INPUT_POST, 'clientid', FILTER_SANITIZE_NUMBER_INT);
            
                $title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
                $firstname= filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
                $middlename= filter_input(INPUT_POST, 'middlename', FILTER_SANITIZE_SPECIAL_CHARS);
                $surname= filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_SPECIAL_CHARS);
                $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
                $smoker= filter_input(INPUT_POST, 'smoker', FILTER_SANITIZE_SPECIAL_CHARS);
                $home_email= filter_input(INPUT_POST, 'home_email', FILTER_SANITIZE_SPECIAL_CHARS);
                $work_email= filter_input(INPUT_POST, 'office_email', FILTER_SANITIZE_SPECIAL_CHARS);
                $DaytimeTel= filter_input(INPUT_POST, 'DaytimeTel', FILTER_SANITIZE_SPECIAL_CHARS);
                $EveningTel= filter_input(INPUT_POST, 'EveningTel', FILTER_SANITIZE_SPECIAL_CHARS);
                $MobileTel= filter_input(INPUT_POST, 'MobileTel', FILTER_SANITIZE_SPECIAL_CHARS);
                $Client_telephone= filter_input(INPUT_POST, 'Client_telephone', FILTER_SANITIZE_SPECIAL_CHARS);
                $address1= filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
                $address2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
                $address3= filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_SPECIAL_CHARS);
                $address4= filter_input(INPUT_POST, 'address4', FILTER_SANITIZE_SPECIAL_CHARS);
                $postcode= filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_SPECIAL_CHARS);
                
                $changereason= filter_input(INPUT_POST, 'changereason', FILTER_SANITIZE_SPECIAL_CHARS);
                                
                $clientone = $pdo->prepare("UPDATE assura_client_details set title=:title, firstname=:firstname, middlename=:middlename, surname=:surname, DaytimeTel=:DaytimeTel, EveningTel=:EveningTel, MobileTel=:MobileTel, Client_telephone=:Client_telephone, home_email=:home_email, office_email=:office_email, address1=:address1, address2=:address2, address3=:address3, address4=:address4, postcode=:postcode, dob=:dob, smoker=:smoker WHERE client_id = :id");
                $clientone->bindParam(':id', $clientid, PDO::PARAM_STR, 12);

                $clientone->bindParam(':title', $title, PDO::PARAM_STR, 200);
                $clientone->bindParam(':firstname', $firstname, PDO::PARAM_STR, 200);
                $clientone->bindParam(':middlename', $middlename, PDO::PARAM_STR, 200);
                $clientone->bindParam(':surname', $surname, PDO::PARAM_STR, 200);
                $clientone->bindParam(':dob', $dob, PDO::PARAM_STR, 200);
                $clientone->bindParam(':smoker', $smoker, PDO::PARAM_STR, 200);
                $clientone->bindParam(':home_email', $home_email, PDO::PARAM_STR, 200);
                $clientone->bindParam(':office_email', $work_email, PDO::PARAM_STR, 200);
                $clientone->bindParam(':DaytimeTel', $DaytimeTel, PDO::PARAM_STR, 200);
                $clientone->bindParam(':EveningTel', $EveningTel, PDO::PARAM_STR, 200);
                $clientone->bindParam(':MobileTel', $MobileTel, PDO::PARAM_STR, 200);
                $clientone->bindParam(':Client_telephone', $Client_telephone, PDO::PARAM_STR, 200);
                $clientone->bindParam(':address1', $address1, PDO::PARAM_STR, 200);
                $clientone->bindParam(':address2', $address2, PDO::PARAM_STR, 200);
                $clientone->bindParam(':address3', $address3, PDO::PARAM_STR, 200);
                $clientone->bindParam(':address4', $address4, PDO::PARAM_STR, 200);
                $clientone->bindParam(':postcode', $postcode, PDO::PARAM_STR, 200);
                $clientone->execute();

                $clientnamedata= "CRM Alert";   
                $notedata= "Client Details Updated";
                
                $query = $pdo->prepare("INSERT INTO legacy_client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                $query->bindParam(':clientidholder',$clientid, PDO::PARAM_INT);
                $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
                $query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
                $query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
                $query->bindParam(':messageholder',$changereason, PDO::PARAM_STR, 2500);
                $query->execute(); 
            
                $clientid2= filter_input(INPUT_POST, 'clientid2', FILTER_SANITIZE_NUMBER_INT);
            
            if (isset($clientid2)) {
                
                $title2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_SPECIAL_CHARS);
                $firstname2= filter_input(INPUT_POST, 'firstname2', FILTER_SANITIZE_SPECIAL_CHARS);
                $middlename2= filter_input(INPUT_POST, 'middlename2', FILTER_SANITIZE_SPECIAL_CHARS);
                $surname2= filter_input(INPUT_POST, 'surname2', FILTER_SANITIZE_SPECIAL_CHARS);
                $dob2= filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_SPECIAL_CHARS);
                $smoker2= filter_input(INPUT_POST, 'smoker2', FILTER_SANITIZE_SPECIAL_CHARS);
                $home_email2= filter_input(INPUT_POST, 'home_email2', FILTER_SANITIZE_SPECIAL_CHARS);
                $work_email2= filter_input(INPUT_POST, 'office_email2', FILTER_SANITIZE_SPECIAL_CHARS);
                $DaytimeTel2= filter_input(INPUT_POST, 'DaytimeTel2', FILTER_SANITIZE_SPECIAL_CHARS);
                $EveningTel2= filter_input(INPUT_POST, 'EveningTel2', FILTER_SANITIZE_SPECIAL_CHARS);
                $MobileTel2= filter_input(INPUT_POST, 'MobileTel2', FILTER_SANITIZE_SPECIAL_CHARS);
                $Client_telephone2= filter_input(INPUT_POST, 'Client_telephone2', FILTER_SANITIZE_SPECIAL_CHARS);
                $address1= filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
                $address2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
                $address3= filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_SPECIAL_CHARS);
                $address4= filter_input(INPUT_POST, 'address4', FILTER_SANITIZE_SPECIAL_CHARS);
                $postcode= filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_SPECIAL_CHARS);
                
                $clienttwo = $pdo->prepare("UPDATE assura_client_details set title=:title, firstname=:firstname, middlename=:middlename, surname=:surname, DaytimeTel=:DaytimeTel, EveningTel=:EveningTel, MobileTel=:MobileTel, Client_telephone=:Client_telephone, home_email=:home_email, office_email=:office_email, address1=:address1, address2=:address2, address3=:address3, address4=:address4, postcode=:postcode, dob=:dob, smoker=:smoker WHERE client_id = :id");

                $clienttwo->bindParam(':id', $clientid2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':title', $title2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':firstname', $firstname2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':middlename', $middlename2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':surname', $surname2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':dob', $dob2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':smoker', $smoker2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':home_email', $home_email2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':office_email', $work_email2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':DaytimeTel', $DaytimeTel2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':EveningTel', $EveningTel2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':MobileTel', $MobileTel2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':Client_telephone', $Client_telephone2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':address1', $address1, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':address2', $address2, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':address3', $address3, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':address4', $address4, PDO::PARAM_STR, 200);
                $clienttwo->bindParam(':postcode', $postcode, PDO::PARAM_STR, 200);               
                $clienttwo->execute();
            
            }
            
            if(isset($fferror)) {
    if($fferror=='0') {
            
           header('Location: ../Legacy/ViewLegacyClient.php?clientedited=y&search='.$clientid); die; 
           
    }
            }
        }
        }
        
        if(isset($fferror)) {
    if($fferror=='0') {

header('Location: ../CRMmain.php?Clientadded=failed'); die;
    }
        }
?>


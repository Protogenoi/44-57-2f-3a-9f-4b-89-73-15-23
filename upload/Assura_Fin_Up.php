<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 7);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

    if ($_FILES[csv][size] > 0) {
        include('../includes/ADL_PDO_CON.php');

    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file,"r");
    
    do {
        if ($data[0]) {
            if ($data[0] != 'Transmission Date' && $data[0] != 'Transmission_Date' ) {
                
                $CSV_Transmission_Date=$data[0];
                $formatted_date= date("Y-m-d" , strtotime($CSV_Transmission_Date));
                $CSV_Transmission_Time=$data[1];
                $CSV_Payment_Date=$data[2];
                $CSV_Master_Agency_No=$data[3];
                $CSV_FRN_Number=$data[4];
                $CSV_Sub_Agency_No=$data[5];
                $CSV_Policy_Type=$data[6];
                $CSV_Policy=$data[7];
                $CSV_Broker_Ref=$data[8];
                $CSV_Reason_Code=$data[9];
                $CSV_Party=$data[10];
                $CSV_Policy_Name=$data[11];
                $CSV_Initial=$data[12];
                $CSV_Product_Description=$data[13];
                $CSV_Payment_Type=$data[14];
                $CSV_Payment_Amount=$data[15];
                $CSV_Payment_Currency=$data[16];
                $CSV_Payment_Basis=$data[17];
                $CSV_Payment_Code=$data[18];
                $CSV_Payment_Due_Date=$data[19];
                $CSV_Premium_Type=$data[20];
                $CSV_Premium_Amount=$data[21];
                $CSV_Premium_Currency=$data[22];
                $CSV_Premium_Frequency=$data[23];
                $CSV_Payment_Reason=$data[24];
                $CSV_Scheme_Number=$data[25];
                $CSV_Scheme_Name=$data[26];
                
                $regpol1= filter_var($data[7], FILTER_SANITIZE_NUMBER_INT);
                $regpol="$regpol1";
                $reggy = "%$regpol%";
                
                if ($CSV_Payment_Amount >= 0) {
                    
                    $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
                    $query->bindParam(':polhold', $reggy, PDO::PARAM_STR);
                    $query->execute();
                    $result=$query->fetch(PDO::FETCH_ASSOC);
                    
                    if ($query->rowCount() >= 1) {
                        
                        $clientid=$result['client_id'];
                        $polid=$result['id'];
                        $policynumber=$result['policy_number'];
                        $ref= "$policynumber ($polid)";
                        $polstat=$result['policystatus'];
                        
                        $note="Assura Financial Uploaded";
                        $message="COMM (Status changed from $polstat to Live)";
                        
                        $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                        $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
                        $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
                        $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                        $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                        $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                        $insert->execute();
                        
                        $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
                        $update->bindParam(':polid', $polid, PDO::PARAM_INT);
                        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                        $update->execute();
                        
                    }
                    
                    if ($query->rowCount() == 0) {
                        
                        $insert = $pdo->prepare("INSERT INTO assura_assura_financial_statistics_nomatch set payment_amount=:pay, policy_number=:pol, entry_by=:hello, payment_type=:type");
                        $insert->bindParam(':pay', $CSV_Premium_Amount, PDO::PARAM_STR, 250);
                        $insert->bindParam(':type', $CSV_Payment_Type, PDO::PARAM_STR, 250);
                        $insert->bindParam(':pol', $regpol1, PDO::PARAM_STR, 250);
                        $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
                        $insert->execute();
                        
                    }
                    
                    }
                    
                    if ($CSV_Payment_Amount < 0) {
                        $query = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
                        $query->bindParam(':polhold', $reggy, PDO::PARAM_STR);
                        $query->execute();
                        $result=$query->fetch(PDO::FETCH_ASSOC);
                        
                        if ($query->rowCount() >= 1) {
                            
                            $clientid=$result['client_id'];
                            $polid=$result['id'];
                            $policynumber=$result['policy_number'];
                            $ref= "$policynumber ($polid)";
                            $polstat=$result['policystatus'];
                            
                            $note="Assura Financial Uploaded";
                            $message="CLAWBACK (Status changed from $polstat to Clawback)"; 
                            
                            $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                            $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
                            $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
                            $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                            $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                            $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $insert->execute();
                            
                            $update = $pdo->prepare("UPDATE client_policy set policystatus='Clawback', edited=:sent WHERE id=:polid");
                            $update->bindParam(':polid', $polid, PDO::PARAM_INT);
                            $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $update->execute();
                            
                        }
                        
                        if ($query->rowCount() == 0) {
                            
                            $insert = $pdo->prepare("INSERT INTO assura_financial_statistics_nomatch set payment_amount=:pay, policy_number=:pol, entry_by=:hello, payment_type=:type");
                            $insert->bindParam(':pay', $CSV_Premium_Amount, PDO::PARAM_STR, 250);
                            $insert->bindParam(':type', $CSV_Payment_Type, PDO::PARAM_STR, 250);
                            $insert->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                            $insert->bindParam(':hello', $hello_name, PDO::PARAM_STR, 250);
                            $insert->execute();
                            
                        }
                        
                        }
                        
                        $query = $pdo->prepare("INSERT INTO assura_financial_statistics "
. "set Transmission_Date = :Transmission_Date ,"
. " Transmission_Time = :Transmission_Time ,"
. " Payment_Date = :Payment_Date ,"
. " Master_Agency_No = :Master_Agency_No ,"
. " FRN_Number = :FRN_Number ,"
. " Sub_Agency_No = :Sub_Agency_No ,"
. " Policy_Type = :Policy_Type ,"
. " Policy = :Policy ,"
. " Broker_Ref = :Broker_Ref ,"
. " Reason_Code = :Reason_Code ,"
. " Party = :Party ,"
. " Policy_Name = :Policy_Name ,"
. " Initial = :Initial ,"
. " Product_Description = :Product_Description ,"
. " Payment_Type = :Payment_Type ,"
. " Payment_Amount = :Payment_Amount ,"
. " Payment_Currency = :Payment_Currency ,"
. " Payment_Basis = :Payment_Basis ,"
. " Payment_Code = :Payment_Code ,"
. " Payment_Due_Date = :Payment_Due_Date ,"
. " Premium_Type = :Premium_Type ,"
. " Premium_Amount = :Premium_Amount ,"
. " Premium_Currency = :Premium_Currency ,"
. " Premium_Frequency = :Premium_Frequency ,"
. " Payment_Reason = :Payment_Reason ,"
. " Scheme_Number = :Scheme_Number ,"
. " Scheme_Name = :Scheme_Name ,"
. " uploader = :uploader");

    $query->bindParam(':Transmission_Date', $formatted_date , PDO::PARAM_STR, 200);
    $query->bindParam(':Transmission_Time', $CSV_Transmission_Time , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Date', $CSV_Payment_Date , PDO::PARAM_STR, 200);
    $query->bindParam(':Master_Agency_No', $CSV_Master_Agency_No , PDO::PARAM_STR, 200);
    $query->bindParam(':FRN_Number', $CSV_FRN_Number , PDO::PARAM_STR, 200);
    $query->bindParam(':Sub_Agency_No', $CSV_Sub_Agency_No , PDO::PARAM_STR, 200);
    $query->bindParam(':Policy_Type', $CSV_Policy_Type , PDO::PARAM_STR, 200);
    $query->bindParam(':Policy', $CSV_Policy , PDO::PARAM_STR, 200);
    $query->bindParam(':Broker_Ref', $CSV_Broker_Ref , PDO::PARAM_STR, 200);
    $query->bindParam(':Reason_Code', $CSV_Reason_Code , PDO::PARAM_STR, 200);
    $query->bindParam(':Party', $CSV_Party , PDO::PARAM_STR, 200);
    $query->bindParam(':Policy_Name', $CSV_Policy_Name , PDO::PARAM_STR, 200);
    $query->bindParam(':Initial', $CSV_Initial , PDO::PARAM_STR, 200);
    $query->bindParam(':Product_Description', $CSV_Product_Description , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Type', $CSV_Payment_Type , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Amount', $CSV_Payment_Amount , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Currency', $CSV_Payment_Currency , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Basis', $CSV_Payment_Basis , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Code', $CSV_Payment_Code , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Due_Date', $CSV_Payment_Due_Date , PDO::PARAM_STR, 200);
    $query->bindParam(':Premium_Type', $CSV_Premium_Type , PDO::PARAM_STR, 200);
    $query->bindParam(':Premium_Amount', $CSV_Premium_Amount , PDO::PARAM_STR, 200);
    $query->bindParam(':Premium_Currency', $CSV_Premium_Currency , PDO::PARAM_STR, 200);
    $query->bindParam(':Premium_Frequency', $CSV_Premium_Frequency , PDO::PARAM_STR, 200);
    $query->bindParam(':Payment_Reason', $CSV_Payment_Reason , PDO::PARAM_STR, 200);
    $query->bindParam(':Scheme_Number', $CSV_Scheme_Number , PDO::PARAM_STR, 200);
    $query->bindParam(':Scheme_Name', $CSV_Scheme_Name , PDO::PARAM_STR, 200);
    $query->bindParam(':uploader', $hello_name , PDO::PARAM_STR, 200);
    $query->execute();

}

        }
    } while ($data = fgetcsv($handle,1000,",","'"));
    header('Location: /Life/Assura/Financial_Reports.php?success=1'); die;
}
?>

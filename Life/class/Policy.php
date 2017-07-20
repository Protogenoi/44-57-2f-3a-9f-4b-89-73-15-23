<?php

if (isset($fferror)) {
    if ($fferror == '1') {

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$CID = filter_input(INPUT_POST, 'CID', FILTER_SANITIZE_NUMBER_INT);

$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
$first = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
$last = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
$dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$phone = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_SPECIAL_CHARS);
$alt = filter_input(INPUT_POST, 'alt_number', FILTER_SANITIZE_SPECIAL_CHARS);
$title2 = filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_SPECIAL_CHARS);
$first2 = filter_input(INPUT_POST, 'first_name2', FILTER_SANITIZE_SPECIAL_CHARS);
$last2 = filter_input(INPUT_POST, 'last_name2', FILTER_SANITIZE_SPECIAL_CHARS);
$dob2 = filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_SPECIAL_CHARS);
$email2 = filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_SPECIAL_CHARS);
$add1 = filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
$add2 = filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
$add3 = filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_SPECIAL_CHARS);
$town = filter_input(INPUT_POST, 'town', FILTER_SANITIZE_SPECIAL_CHARS);
$post = strtoupper(filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_SPECIAL_CHARS));

$INSURER = filter_input(INPUT_POST, 'custype', FILTER_SANITIZE_SPECIAL_CHARS);


class NewPolicy {

    public $isAlive = true;
    
    public $hello;

    public $CID;
    public $OWNER;
    
    public $APP;
    public $POLICY;
    public $TYPE;
    public $INSURER;
    public $PREMIUM;
    public $COMMISSION;
    public $COVER;
    public $TERM;
    public $COMM;
    public $CB_TERM;
    public $DRIP;
    public $CLOSER;
    public $AGENT;
    public $SALE;
    public $SUB;
    public $STATUS;


    function __construct($hello_name, $OWNER, $CID, $APP, $POLICY, $TYPE, $INSURER, $PREMIUM, $COMMISSION, $COVER, $TERM, $COMM, $CB_TERM, $DRIP, $CLOSER, $AGENT, $SALE, $SUB, $STATUS) {

        $this->HELLO = $hello_name;
        
        $this->CID = $CID;
        $this->OWNER = $OWNER;
        
        $this->APP = $APP;
        $this->POLICY = $POLICY;
        $this->TYPE= $TYPE;
        $this->INSURER = $INSURER;
        $this->PREMIUM = $PREMIUM;
        $this->COMMISSION = $COMMISSION;
        $this->COVER = $COVER;
        $this->TERM = $TERM;
        $this->COMM = $COMM;
        $this->CB_TERM = $CB_TERM;
        $this->DRIP = $DRIP;
        $this->CLOSER = $CLOSER;
        $this->AGENT = $AGENT;
        $this->SALE = $SALE;
        $this->SUB = $SUB;
        $this->STATUS = $STATUS;
        
        
        
    }
    
    function checkVARS() {
        
      echo "$this->OWNER | $this->HELLO | $this->CID<br>";  
      echo "$this->APP | $this->POLICY | $this->TYPE | $this->INSURER | $this->PREMIUM | $this->COMMISSION | $this->COVER | $this->TERM | $this->COMM | $this->CB_TERM | $this->DRIP | $this->CLOSER | $this->AGENT | $this->SALE | $this->SUB | $this->STATUS <br>";

    }
    
    function selectPolicy() {
        
        $database = new Database();
        $database->beginTransaction();

        $database->query("SELECT 
    company,
    client_id,
    CONCAT(title, ' ', first_name, ' ', last_name) AS Name,
    CONCAT(title2,
            ' ',
            first_name2,
            ' ',
            last_name2) AS Name2
FROM
    client_details
WHERE
    client_id =:CID
AND
    owner=:OWNER");
        $database->bind(':CID', $this->CID);
        $database->bind(':OWNER', $this->OWNER);
        $database->execute();
        $row = $database->single();

        if ($database->rowCount() >= 1) {
            
            $data['NAME']=$row['Name'];
            $data['NAME2']=$row['Name2'];
            $data['COMPANY']=$row['company'];
            
            return $data;
            
        }
        
        $database->endTransaction();        
        
    }
    
    function addPolicyValidation() {
        
        $VALIDATION_ARRAY=array();
        $TYPE_VALID_ARRAY=array("LTA","ARCHIVE","LTA SIC","LTA CIC","DTA","DTA CIC","CIC","FPIP","Income Protection","WOL");
        $INSURER_VALID_ARRAY=array("Legal and General","Vitality","Assura","Bright Grey","Royal London","One Family","Aviva");
        $COMM_VALID_ARRAY=array("Indemnity","Non Indemnity","NA");
        $CB_VALID_ARRAY=array("1 year","2 year","3 year","4 year","5 year");
        $STATUS_VALID_ARRAY=array("Live","Awaiting","Not Live","NTU","Declined","Redrawn");
        
    if(!empty($this->APP)) {
        $check['APP_STATUS']="success";
        $check['APP_ICON']="glyphicon-ok";
    }
    else {
        $check['APP_STATUS']="error";
        $check['APP_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");
        
    }
    
    if(!empty($this->POLICY)) {
        $check['POLICY_STATUS']="success";
        $check['POLICY_ICON']="glyphicon-ok";
    }
    else {
        $check['POLICY_STATUS']="error";
        $check['POLICY_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");
        
    }   
    
    if(in_array($this->TYPE,$TYPE_VALID_ARRAY,true)) {
        $check['TYPE_STATUS']="success";
        $check['TYPE_ICON']="glyphicon-ok";        
    } else {
        $check['TYPE_STATUS']="error";
        $check['TYPE_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");          
    }
    
    if(in_array($this->INSURER,$INSURER_VALID_ARRAY,true)) {
        $check['INSURER_STATUS']="success";
        $check['INSURER_ICON']="glyphicon-ok";        
    } else {
        $check['INSURER_STATUS']="error";
        $check['INSURER_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");          
    }
    
    if(is_numeric($this->PREMIUM)) {
         $check['PREMIUM_STATUS']="success";
        $check['PREMIUM_ICON']="glyphicon-ok";          
    } else {
         $check['PREMIUM_STATUS']="error";
        $check['PREMIUM_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");          
    }

    if(is_numeric($this->COMMISSION)) {
         $check['COMMISSION_STATUS']="success";
        $check['COMMISSION_ICON']="glyphicon-ok";          
    } else {
         $check['COMMISSION_STATUS']="error";
        $check['COMMISSION_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");          
    }  
    
    if(is_numeric($this->COVER)) {
         $check['COVER_STATUS']="success";
        $check['COVER_ICON']="glyphicon-ok";          
    } else {
         $check['COVER_STATUS']="error";
        $check['COVER_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");          
    }  
    
    if(is_numeric($this->TERM)) {
         $check['TERM_STATUS']="success";
        $check['TERM_ICON']="glyphicon-ok";          
    } else {
         $check['TERM_STATUS']="error";
        $check['TERM_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");          
    } 

    if(in_array($this->COMM,$COMM_VALID_ARRAY,true)) {
        $check['COMM_STATUS']="success";
        $check['COMM_ICON']="glyphicon-ok";        
    } else {
        $check['COMM_STATUS']="error";
        $check['COMM_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");          
    }  
    
    if(is_numeric($this->CB_TERM) || in_array($this->CB_TERM,$CB_VALID_ARRAY,true)) { 
         $check['CB_TERM_STATUS']="success";
        $check['CB_TERM_ICON']="glyphicon-ok";          

        } else {
         $check['CB_TERM_STATUS']="error";
        $check['CB_TERM_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");          
    }     
    
    if(is_numeric($this->DRIP)) {
         $check['DRIP_STATUS']="success";
        $check['DRIP_ICON']="glyphicon-ok";          
    } else {
         $check['DRIP_STATUS']="error";
        $check['DRIP_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");          
    } 

    if(!empty($this->CLOSER)) {
         $check['CLOSER_STATUS']="success";
        $check['CLOSER_ICON']="glyphicon-ok";          
    } else {
         $check['CLOSER_STATUS']="error";
        $check['CLOSER_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");          
    }
    
    if(!empty($this->AGENT)) {
         $check['AGENT_STATUS']="success";
        $check['AGENT_ICON']="glyphicon-ok";          
    } else {
         $check['AGENT_STATUS']="error";
        $check['AGENT_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");          
    }  
    
    if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$this->SUB)) {
        $check['SUB_STATUS']="success";
        $check['SUB_ICON']="glyphicon-ok";
        }
        else {
            $check['SUB_STATUS']="error";
            $check['SUB_ICON']="glyphicon-remove";
            array_push($VALIDATION_ARRAY,"error");
            }    
            
    if(!empty($this->SALE)) {
         $check['SALE_STATUS']="success";
        $check['SALE_ICON']="glyphicon-ok";          
    } else {
         $check['SALE_STATUS']="error";
        $check['SALE_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");          
    }
  
    if(in_array($this->STATUS,$STATUS_VALID_ARRAY,true)) {
        $check['STATUS_STATUS']="success";
        $check['STATUS_ICON']="glyphicon-ok";        
    } else {
        $check['STATUS_STATUS']="error";
        $check['STATUS_ICON']="glyphicon-eror";
        array_push($VALIDATION_ARRAY,"error");          
    }    
    
   
    if(in_array("error", $VALIDATION_ARRAY)) {
        
        $check['APP'] = $this->APP;
        $check['POLICY'] = $this->POLICY;
        $check['TYPE'] = $this->TYPE;
        $check['INSURER'] = $this->INSURER;
        $check['PREMIUM'] = $this->PREMIUM;
        $check['COMMISSION'] = $this->COMMISSION;
        $check['COVER'] = $this->COVER;
        $check['TERM'] = $this->TERM;
        $check['COMM'] = $this->COMM;
        $check['CB_TERM'] = $this->CB_TERM;
        $check['DRIP'] = $this->DRIP;
        $check['CLOSER'] = $this->CLOSER;
        $check['AGENT'] = $this->AGENT;
        $check['SALE'] = $this->SALE;
        $check['SUB'] = $this->SUB;
        $check['STATUS'] = $this->STATUS;
        
        $check['VALIDATION'] = "INVALID";
        
        return $check;
        
    } else {

        $check['APP'] = $this->APP;
        $check['POLICY'] = $this->POLICY;
        $check['TYPE'] = $this->TYPE;
        $check['INSURER'] = $this->INSURER;
        $check['PREMIUM'] = $this->PREMIUM;
        $check['COMMISSION'] = $this->COMMISSION;
        $check['COVER'] = $this->COVER;
        $check['TERM'] = $this->TERM;
        $check['COMM'] = $this->COMM;
        $check['CB_TERM'] = $this->CB_TERM;
        $check['DRIP'] = $this->DRIP;
        $check['CLOSER'] = $this->CLOSER;
        $check['AGENT'] = $this->AGENT;
        $check['SALE'] = $this->SALE;
        $check['SUB'] = $this->SUB;
        $check['STATUS'] = $this->STATUS;
        
        $check['VALIDATION'] = "VALID";
        
        return $check;        
        
    }
        
    }
       
}

//END CLASS

?>
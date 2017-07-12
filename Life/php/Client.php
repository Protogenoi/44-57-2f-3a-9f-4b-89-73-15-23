<?php
include(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS) . "/classes/access_user/access_user_class.php");
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');
include('../../includes/Access_Levels.php');
include('../../classes/database_class.php');
include('../../includes/adlfunctions.php');

if (isset($fferror)) {
    if ($fferror == '1') {

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

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
$post = filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_SPECIAL_CHARS);

$INSURER = filter_input(INPUT_POST, 'custype', FILTER_SANITIZE_SPECIAL_CHARS);

$correct_dob = date("Y-m-d", strtotime($dob));
if (!empty($dob2)) {
    $correct_dob2 = date("Y-m-d", strtotime($dob2));
} else {
    $correct_dob2 = "NA";
}

class NewClient {

    public $isAlive = true;
    public $title;
    public $first;
    public $last;
    public $correct_dob;
    public $email;
    public $phone;
    public $alt;
    public $title2;
    public $first2;
    public $last2;
    public $corrent_dob2;
    public $email2;
    public $add1;
    public $add2;
    public $add3;
    public $town;
    public $post;


    function __construct($hello_name, $INSURER, $COMPANY_ENTITY, $title, $first, $last, $correct_dob, $email, $phone, $alt, $title2, $first2, $last2, $correct_dob2, $email2, $add1, $add2, $add3, $town, $post) {

        $this->company = $COMPANY_ENTITY;
        $this->insurer = $INSURER;
        $this->hello = $hello_name;

        $this->title = $title;
        $this->first = $first;
        $this->last = $last;
        $this->dob = $correct_dob;
        $this->email = $email;
        $this->phone = $phone;
        $this->alt = $alt;

        $this->title2 = $title2;
        $this->first2 = $first2;
        $this->last2 = $last2;
        $this->dob2 = $correct_dob2;
        $this->email2 = $email2;

        $this->add = $add1;
        $this->add2 = $add2;
        $this->add3 = $add3;
        $this->town = $town;
        $this->post = $post;
    }
    
    function checkVARS() {
        
      echo "$this->company | $this->insurer | $this->hello<br>";  
      echo "$this->title | $this->first | $this->last | $this->dob | $this->email | $this->phone | $this->alt<br>";
      echo "$this->title2 | $this->first2 | $this->last2 | $this->dob2 | $this->email2<br>";
      echo "$this->add | $this->add2 | $this->add3 | $this->town | $this->post";
    }

    function dupeCheck() {

        $database = new Database();
        $database->beginTransaction();

        $database->query("SELECT client_id, first_name, last_name FROM client_details WHERE post_code=:post AND address1 =:add1 AND company=:company AND owner=:OWNER OR phone_number=:PHONE AND company=:COMPANY2 AND owner=:OWNER2");
        $database->bind(':OWNER', $this->company);
        $database->bind(':company', $this->insurer);
        $database->bind(':OWNER2', $this->company);
        $database->bind(':COMPANY2', $this->insurer);
        $database->bind(':post', $this->post);
        $database->bind(':add1', $this->add);
        $database->bind(':PHONE', $this->phone);
        $database->execute();
        $row = $database->single();

        $database->endTransaction();

        if ($database->rowCount() >= 1) {
        
            $this->DUPE_CLIENT_ID = $row['client_id'];
        } 

    }

    function addClient() {
        if (empty($this->DUPE_CLIENT_ID)) {

            $database = new Database();
            $database->beginTransaction();

            $database->query("INSERT into client_details set owner=:OWNER, company=:company, title=:title, first_name=:first, last_name=:last, dob=:dob, email=:email, phone_number=:phone, alt_number=:alt, title2=:title2, first_name2=:first2, last_name2=:last2, dob2=:dob2, email2=:email2, address1=:add1, address2=:add2, address3=:add3, town=:town, post_code=:post, submitted_by=:hello, recent_edit=:hello2");
            $database->bind(':OWNER', $this->company);
            $database->bind(':company', $this->insurer);
            $database->bind(':title', $this->title);
            $database->bind(':first', $this->first);
            $database->bind(':last', $this->last);
            $database->bind(':dob', $this->dob);
            $database->bind(':email', $this->email);
            $database->bind(':phone', $this->phone);
            $database->bind(':alt', $this->alt);
            $database->bind(':title2', $this->title2);
            $database->bind(':first2', $this->first2);
            $database->bind(':last2', $this->last2);
            $database->bind(':dob2', $this->dob2);
            $database->bind(':email2', $this->email2);
            $database->bind(':add1', $this->add);
            $database->bind(':add2', $this->add2);
            $database->bind(':add3', $this->add3);
            $database->bind(':town', $this->town);
            $database->bind(':post', $this->post);
            $database->bind(':hello', $this->hello);
            $database->bind(':hello2', $this->hello);
            $database->execute();
            
            if ($database->rowCount() >= 1) {

            $this->LAST_ID = $database->lastInsertId();

            $database->query("INSERT INTO client_note set client_id=:CID, client_name=:RECIPIENT, sent_by=:SENT, note_type='Client Added', message='Client Uploaded'");
            $database->bind(':CID', $this->LAST_ID);
            $database->bind(':SENT', $this->hello);
            $database->bind(':RECIPIENT', $this->title . " " . $this->first . " " . $this->last);
            $database->execute();
            
            }

            $database->endTransaction();
        }
    }

//END addClient

    function selectTasks() {

        $database = new Database();
        $database->beginTransaction();

        $weekarray = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri');

        $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='CYD'");
        $database->execute();
        $assignCYDd = $database->single();

        $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='24 48'");
        $database->execute();
        $assign24d = $database->single();

        $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='5 day'");
        $database->execute();
        $assign5d = $database->single();

        $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='18 day'");
        $database->execute();
        $assign18d = $database->single();

        $this->assignCYD = $assignCYDd['Assigned'];
        $this->assign24 = $assign24d['Assigned'];
        $this->assign5 = $assign5d['Assigned'];
        $this->assign18 = $assign18d['Assigned'];

        //CYD TASK
        $next = date("D", strtotime("+91 day"));

        if ($next == "Sat") {
            $DEADLINE_CYD = date("Y-m-d", strtotime("+93 day"));
        }

        if ($next == "Sun") {
            $DEADLINE_CYD = date("Y-m-d", strtotime("+92 day"));
        }

        if (in_array($next, $weekarray, true)) {
            $DEADLINE_CYD = date("Y-m-d", strtotime("+91 day"));
        }

        $this->dateAdded = date("Y-m-d H:i:s");

        // 24 48 TASK
        $next24 = date("D", strtotime("+2 day"));
        if ($next24 == "Sat") {
            $DEADLINE_24 = date("Y-m-d", strtotime("+4 day"));
        }

        if ($next24 == "Sun") {
            $DEADLINE_24 = date("Y-m-d", strtotime("+3 day"));
        }

        if (in_array($next24, $weekarray, true)) {
            $DEADLINE_24 = date("Y-m-d", strtotime("+2 day"));
        }

//TASK 5 day
        $next5 = date("D", strtotime("+5 day")); /* Add 2 to Day */
        if ($next5 == "Sat") { //Check if Weekend
            $DEADLINE_5 = date("Y-m-d", strtotime("+7 day")); //Add extra 2 Days if Sat Weekend
        }

        if ($next5 == "Sun") { //Check if Weekend
            $DEADLINE_5 = date("Y-m-d", strtotime("+6 day")); //Add extra 1 day if Sunday
        }

        if (in_array($next5, $weekarray, true)) {
            $DEADLINE_5 = date("Y-m-d", strtotime("+5 day"));
        }

//TASK 18 day
        $next18 = date("D", strtotime("+18 day")); // Add 2 to Day

        if ($next18 == "Sat") { //Check if Weekend
            $DEADLINE_18 = date("Y-m-d", strtotime("+20 day")); //Add extra 2 Days if Sat Weekend
        }

        if ($next18 == "Sun") { //Check if Weekend
            $DEADLINE_18 = date("Y-m-d", strtotime("+19 day")); //Add extra 1 day if Sunday
        }


        if (in_array($next18, $weekarray, true)) {
            $DEADLINE_18 = date("Y-m-d", strtotime("+18 day"));
        }

        $CYD_ARRAY = array("Life", "Bluestone Protect", "ADL Legal and General", "Legal and General");
        $TWO_FOUR_ARRAY = array("Bluestone Protect", "ADL Legal and General", "Legal and General");
        $FIVE_ARRAY = array("Life", "Bluestone Protect", "ADL Legal and General", "Legal and General", "TRB Royal London", "TRB Aviva", "Vitality", "WOL", "Royal London", "Aviva");

        if (in_array($this->insurer, $CYD_ARRAY, true)) {

            //CYD TASK
            $database->query("INSERT INTO Client_Tasks set client_id=:CID, Assigned=:assign, task='CYD', date_added=:added, deadline=:deadline");
            $database->bind(':assign', $this->assignCYD);
            $database->bind(':added', $this->dateAdded);
            $database->bind(':deadline', $DEADLINE_CYD);
            $database->bind(':CID', $this->LAST_ID);
            $database->execute();
        }

        if (in_array($this->insurer, $TWO_FOUR_ARRAY, true)) {

            $database->query("INSERT INTO Client_Tasks set client_id=:CID, Assigned=:assign, task='24 48', date_added=:added, deadline=:deadline");
            $database->bind(':assign', $this->assign24);
            $database->bind(':added', $this->dateAdded);
            $database->bind(':deadline', $DEADLINE_24);
            $database->bind(':CID', $this->LAST_ID);
            $database->execute();
        }

        if (in_array($this->insurer, $FIVE_ARRAY, true)) {


            $database->query("INSERT INTO Client_Tasks set client_id=:CID, Assigned=:assign, task='5 day', date_added=:added, deadline=:deadline");
            $database->bind(':assign', $this->assign5);
            $database->bind(':added', $this->dateAdded);
            $database->bind(':deadline', $DEADLINE_5);
            $database->bind(':CID', $this->LAST_ID);
            $database->execute();

            $database->query("INSERT INTO Client_Tasks set client_id=:CID, Assigned=:assign, task='18 day', date_added=:added, deadline=:deadline");
            $database->bind(':assign', $this->assign18);
            $database->bind(':added', $this->dateAdded);
            $database->bind(':deadline', $DEADLINE_5);
            $database->bind(':CID', $this->LAST_ID);
            $database->execute();  
            
        }

            $database->query("INSERT INTO client_note set client_id=:CID, client_name=:RECIPIENT, sent_by=:SENT, note_type='ADL Tasks', message='Tasks Added'");
            $database->bind(':CID', $this->LAST_ID);
            $database->bind(':SENT', $this->hello);
            $database->bind(':RECIPIENT', $this->title . " " . $this->first . " " . $this->last);
            $database->execute();
            
            $database->endTransaction();
    }

//END selectTasks     
}

//END CLASS

$NewClient = new NewClient("Michael","Legal and General","Bluestone Protect","Mr","Michael","Owen","1987-02-08","michael@thereviewbureau.com","07401434619","07401434619","Mrs","first2","last2","dob2","email2","add1","add2","add3","twon","post");


#$NewClient->checkVARS();

 $NewClient->dupeCheck();

$NewClient->addClient();

$NewClient->selectTasks();

?>
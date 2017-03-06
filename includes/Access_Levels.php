<?php

include ($_SERVER['DOCUMENT_ROOT']."/includes/ADL_PDO_CON.php");

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
                            $cnquery->execute()or die(print_r($query->errorInfo(), true));
                            $companydetailsq=$cnquery->fetch(PDO::FETCH_ASSOC);
                            
                            $companynamere=$companydetailsq['company_name'];
                            
                            if($companynamere=='The Review Bureau') {
                                $Level_10_Access = array("Michael", "Matt", "leighton");
                                $Level_8_Access = array("Michael", "Matt", "leighton", "Abbiek", "carys","Tina","Heidy","Nicola","Mike");
                                $Level_3_Access = array("Michael", "Matt", "leighton", "Abbiek", "carys","Jakob","Nicola","Tina",'Heidy','Amy',"Mike","Keith","Renee","Victoria","Christian","Audits","Tiaba");
                                $Level_1_Access = array("Michael", "Matt", "leighton", "Abbiek", "carys","Jakob","Nicola","Tina",'Heidy','Amy',"Mike","Keith","Renee","Victoria","Christian","Audits","Tiaba");
                                $Task_Access = array("Michael", "Abbiek", "Victoria","Keith");
                                $SECRET = array("Michael","Abbiek", "carys","Jakob","Nicola","Tina",'Amy',"Victoria","Christian");
                                $Agent_Access = array ("111111111");
                                $Closer_Access = array ("5000","1312","201","511","555","118","104","103");

                                
                            }
                            
if($companynamere=='ADL_CUS') {
    $Level_10_Access = array("Michael", "Dean", "Helen","Andrew","David");
    $Level_8_Access = array("Michael", "Dean", "Helen","Andrew","David");
    $Level_3_Access = array("Michael", "Dean", "Helen","Andrew","David");
    $Level_1_Access = array("Michael", "Dean", "Helen","Andrew","David");
    $SECRET = array("Michael");
    $Task_Access = array("Michael", "Dean", "Helen","Andrew","David");

}                            
                            
                            if($companynamere=='Assura') {
                                $Level_10_Access = array("Michael");
                                $Level_8_Access = array("Michael", "Tina","Nathan","Charles");
                                $Level_3_Access = array("Michael", "Tina","Nathan","Charles");
                                
                                $Level_1_Access = array("Michael", "Tina","Nathan","Charles");
                                
                            }
                            
                            if($companynamere=='HWIFS') {
                                $Level_10_Access = array("Michael");
                                $Level_8_Access = array("Michael");
                                $Level_3_Access = array("Michael");
                                
                                $Level_1_Access = array("Michael");
                                
                            }
 
                            ?>
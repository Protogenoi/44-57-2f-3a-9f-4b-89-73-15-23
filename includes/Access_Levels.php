<?php

include ($_SERVER['DOCUMENT_ROOT']."/includes/ADL_PDO_CON.php");

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
                            $cnquery->execute()or die(print_r($query->errorInfo(), true));
                            $companydetailsq=$cnquery->fetch(PDO::FETCH_ASSOC);
                            
                            $companynamere=$companydetailsq['company_name'];
                            
                            if($companynamere=='The Review Bureau') {
                                $Level_10_Access = array("Michael", "Matt", "leighton");
                                $Level_8_Access = array("Michael", "Matt", "leighton", "Abbiek", "carys","Tina","Heidy","Nicola",'Nathan','Mike','Matthew');
                                $Level_3_Access = array("Michael", "Matt", "leighton", "Abbiek", "carys","Roxy","Jakob","Nicola","Tina",'Heidy','Georgia','Amy','Nathan','Mike','Matthew','Keith');
                                
                                $Level_1_Access = array("Michael", "Matt", "leighton", "Abbiek", "carys","Roxy","Jakob","Nicola","Tina",'Heidy','Georgia','Amy','Nathan','Mike','Matthew','Keith');
                                
                                $Agent_Access = array ("724","1034","511","1185","1009","555","118","212","104","103","519");
                                $Closer_Access = array ("511","1185","1009","555","118","212","104","103","519","carys","Abbiek","Nicola","Michael");
                                
                                $Task_Access = array("Michael", "Jakob", "Nicola");
                                
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
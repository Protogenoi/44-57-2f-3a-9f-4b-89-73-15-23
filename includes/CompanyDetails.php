<?php

include ($_SERVER['DOCUMENT_ROOT']."/includes/ADL_PDO_CON.php");

$cnqueryf = $pdo->prepare("select company_name from company_details limit 1");
                            $cnqueryf->execute()or die(print_r($query->errorInfo(), true));
                            $companydetailsqf=$cnqueryf->fetch(PDO::FETCH_ASSOC);
                            
                            $companynameref=$companydetailsqf['company_name'];
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

if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /CRMmain.php');
    die;
}

if ($ffdealsheets == '0') {
    header('Location: ../CRMmain.php?Feature=NotEnabled');
    die;
}

$QUERY = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | DealSheet to ADL</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/styles/sweet-alert.min.css" />
    <link rel="stylesheet" href="/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

    <style>

        .form-row input {
            padding: 3px 1px;
            width: 100%;
        }
        input.currency {
            text-align: right;
            padding-right: 15px;
        }
        .input-group .form-control {
            float: none;
        }
        .input-group .input-buttons {
            position: relative;
            z-index: 3;
        }
    </style>
</head>
<body>

    <?php
    require_once(__DIR__ . '/../includes/navbar.php');


    if (isset($QUERY)) {
        if ($QUERY == 'SendToADL') {
            require_once(__DIR__ . '/../classes/database_class.php');
            $deal_id = filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_NUMBER_INT);

            $database = new Database();

            $database->query("SELECT date_added, agent, closer, title, forename, surname, dob, title2, forename2, surname2, dob2, postcode, mobile, home, email FROM dealsheet_prt1 WHERE deal_id=:deal_id");
            $database->bind(':deal_id', $deal_id);
            $database->execute();
            $data2 = $database->single();

            list($dob_year, $dob_month, $dob_day) = explode(" ", $data2['dob']);
            list($dob_year2, $dob_month2, $dob_day2) = explode(" ", $data2['dob2']);

            $database->query("SELECT exist_pol, pol_num_1, pol_num_1_pre, pol_num_1_com, pol_num_1_cov, pol_num_1_yr, pol_num_1_type, pol_num_1_soj, pol_num_2, pol_num_2_pre, pol_num_2_com, pol_num_2_cov, pol_num_2_yr, pol_num_2_type, pol_num_2_soj, pol_num_3, pol_num_3_pre, pol_num_3_com, pol_num_3_cov, pol_num_3_yr, pol_num_3_type, pol_num_3_soj, pol_num_4, pol_num_4_pre, pol_num_4_com, pol_num_4_cov, pol_num_4_yr, pol_num_4_type, pol_num_4_soj, chk_post, chk_dob, chk_mob, chk_home, chk_email, fee, total, years, month, comm_after, sac, date FROM dealsheet_prt3 WHERE deal_id=:deal_id");
            $database->bind(':deal_id', $deal_id);
            $database->execute();
            $data4 = $database->single();

            $title = $data2['title'];
            $forname = $data2['forename'];
            $surname = $data2['surname'];
            $title2 = $data2['title2'];
            $forname2 = $data2['forename2'];
            $surname2 = $data2['surname2'];
            $postcode = $data2['postcode'];
            ?>

            <div class="container">

                <?php
                $database->query("Select client_id, first_name, last_name FROM client_details WHERE post_code=:post AND first_name =:first AND last_name=:last");
                $database->bind(':first', $forname);
                $database->bind(':last', $surname);
                $database->bind(':post', $postcode);
                $database->execute();

                if ($database->rowCount() >= 1) {
                    $row = $database->single();

                    if (isset($row['client_id'])) {
                        $dupeclientid = $row['client_id'];
                    }

                    echo "<div class=\"notice notice-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>Error!</strong> Duplicate client details found<br><br>Existing client name: $forname $surname<br> Post Code: $postcode.<br><br><a href='ViewClient.php?search=$dupeclientid' class=\"btn btn-default\"><i class='fa fa-eye'> View Client</a></i></div>";
                }
                if ($ffpost_code == '1') {

                    $PostcodeQuery = $pdo->prepare("select api_key from api_keys WHERE type ='PostCode' limit 1");
                    $PostcodeQuery->execute()or die(print_r($query->errorInfo(), true));
                    $PDre = $PostcodeQuery->fetch(PDO::FETCH_ASSOC);
                    $PostCodeKey = $PDre['api_key'];
                }
                ?>

                <div class='notice notice-default' role='alert'><strong> <center>Check all details before uploading to ADL</center></strong> </div>

                <form class="AddClient" id="Send" action="php/DealSheetToADL.php?QRY=upload&REF=<?php echo $deal_id; ?>" method="POST" autocomplete="off">

                    <div class="panel-group">
                        <div class="panel panel-primary">
                            <div class="panel-heading"><i class="fa fa-user-plus"></i> Add Client</div>
                            <div class="panel-body">  

                                <div class="col-md-4">

                                    <p>
                                    <div class="form-group">
                                        <label for="custtype">Product:</label>
                                        <select class="form-control" name="custtype" id="custype" style="width: 170px" required>
                                            <option value="The Review Bureau">TRB Life Insurance</option>
                                            <option value="TRB Vitality">TRB Vitality</option>
                                            <option value="TRB Home Insurance">TRB Home Insurance</option>
                                            <option value="Assura">Assura Life Insurance</option>
                                        </select>
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-group">
                                        <label for="title">Title:</label>
                                        <select class="form-control" name="title" id="title" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="Mr" <?php
                                            if (isset($data2['title'])) {
                                                if ($data2['title'] == 'Mr') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Mr</option>       
                                            <option value="Dr" <?php
                                            if (isset($data2['title'])) {
                                                if ($data2['title'] == 'Dr') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Dr</option>
                                            <option value="Miss" <?php
                                    if (isset($data2['title'])) {
                                        if ($data2['title'] == 'Miss') {
                                            echo "selected";
                                        }
                                    }
                                            ?>>Miss</option>
                                            <option value="Mrs" <?php
                                            if (isset($data2['title'])) {
                                                if ($data2['title'] == 'Mrs') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Mrs</option>
                                            <option value="Ms" <?php
                                                    if (isset($data2['title'])) {
                                                        if ($data2['title'] == 'Ms') {
                                                            echo "selected";
                                                        }
                                                    }
                                                    ?>>Ms</option>
                                            <option value="Other" <?php
                                                    if (isset($data2['title'])) {
                                                        if ($data2['title'] == 'Other') {
                                                            echo "selected";
                                                        }
                                                    }
                                                    ?>>Other</option>
                                        </select>
                                    </div>
                                    </p>

                                    <p>
                                        <label for="first_name">First Name:</label>
                                        <input type="text" id="first_name" name="first_name" class="form-control" style="width: 170px" required value="<?php
                                                    if (isset($data2['forename'])) {
                                                        echo $data2['forename'];
                                                    }
                                                    ?>">
                                    </p>

                                    <p>
                                        <label for="last_name">Last Name:</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control" style="width: 170px" required value="<?php
                                               if (isset($data2['surname'])) {
                                                   echo $data2['surname'];
                                               }
                                               ?>">
                                    </p>

                                    <p>
                                        <label for="dob">Date of Birth:</label>
                                        <input type="text" id="dob" name="dob" class="form-control" style="width: 170px" required value="<?php
                                        if (isset($dob_day)) {
                                            echo "$dob_year-$dob_month-$dob_day";
                                        }
                                        ?>">
                                        <input type="hidden" name="dob_day" value="<?php
                                        if (isset($dob_day)) {
                                            echo $dob_day;
                                        }
                                        ?>">
                                        <input type="hidden" name="dob_month" value="<?php
                                        if (isset($dob_month)) {
                                            echo $dob_month;
                                        }
                                        ?>">
                                        <input type="hidden" name="dob_year" value="<?php
                                        if (isset($dob_year)) {
                                            echo $dob_year;
                                        }
                                        ?>">
                                    </p>

                                    <p>
                                        <label for="email">Email:</label>
                                        <input type="email" id="email" class="form-control" style="width: 170px" name="email" value="<?php
                                                    if (isset($data2['email'])) {
                                                        echo $data2['email'];
                                                    }
                                                    ?>">
                                    </p>

                                    <br>

                                </div>

                                <div class="col-md-4">

                                    <p>
                                    <div class="form-group">
                                        <label for="title2">Title:</label>
                                        <select class="form-control" name="title2" id="title2" style="width: 170px">
                                            <option value="">Select...</option>
                                            <option value="Mr" <?php
                                            if (isset($data2['title2'])) {
                                                if ($data2['title2'] == 'Mr') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Mr</option>                                        
                                            <option value="Dr" <?php
                                            if (isset($data2['title2'])) {
                                                if ($data2['title2'] == 'Dr') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Dr</option>
                                            <option value="Miss" <?php
                                       if (isset($data2['title2'])) {
                                           if ($data2['title2'] == 'Miss') {
                                               echo "selected";
                                           }
                                       }
                                            ?>>Miss</option>
                                            <option value="Mrs" <?php
                                       if (isset($data2['title2'])) {
                                           if ($data2['title2'] == 'Mrs') {
                                               echo "selected";
                                           }
                                       }
                                            ?>>Mrs</option>
                                            <option value="Ms" <?php
                                       if (isset($data2['title2'])) {
                                           if ($data2['title2'] == 'Ms') {
                                               echo "selected";
                                           }
                                       }
                                       ?>>Ms</option>
                                            <option value="Other" <?php
                                       if (isset($data2['title2'])) {
                                           if ($data2['title2'] == 'Other') {
                                               echo "selected";
                                           }
                                       }
                                       ?>>Other</option>
                                        </select>
                                    </div>
                                    </p>

                                    <p>
                                        <label for="first_name2">First Name:</label>
                                        <input type="text" id="first_name2" name="first_name2" class="form-control" style="width: 170px" value="<?php
                                        if (isset($data2['forename2'])) {
                                            echo $data2['forename2'];
                                        }
                                        ?>">
                                    </p>

                                    <p>
                                        <label for="last_name2">Last Name:</label>
                                        <input type="text" id="last_name2" name="last_name2" class="form-control" style="width: 170px" value="<?php
                                    if (isset($data2['surname2'])) {
                                        echo $data2['surname2'];
                                    }
                                    ?>">
                                    </p>

                                    <p>
                                        <label for="dob2">Date of Birth:</label>
                                        <input type="text" id="dob2" name="dob2" class="form-control" style="width: 170px" value="<?php
                            if (isset($dob_day2)) {
                                echo "$dob_year2-$dob_month2-$dob_day2";
                            }
                            ?>">
                                    </p>

                                    <p>
                                        <label for="email2">Email:</label>
                                        <input type="email" id="email2" name="email2" class="form-control" style="width: 170px">
                                    </p>
                                    <br> 

                                </div>

                                <div class="col-md-4">

                                    <p>
                                        <label for="phone_number">Contact Number:</label>
                                        <input type="tel" id="phone_number" name="phone_number" class="form-control" style="width: 170px" required pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" value="<?php
                                               if (isset($data2['mobile'])) {
                                                   echo $data2['mobile'];
                                               }
                                               ?>">
                                    </p>

                                    <p>
                                        <label for="alt_number">Alt Number:</label>
                                        <input type="tel" id="alt_number" name="alt_number" class="form-control" style="width: 170px" pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" value="<?php
                                               if (isset($data2['home'])) {
                                                   echo $data2['home'];
                                               }
                                               ?>">
                                    </p>
                                    <br>

        <?php if ($ffpost_code == '1') { ?>
                                        <div id="lookup_field"></div>
        <?php
        }
        if ($ffpost_code == '0') {
            ?>
                                        <div class="alert alert-info"><strong>Info!</strong> Post code lookup feature not enabled.</div>
                                            <?php } ?>

                                    <p>
                                        <label for="address1">Address Line 1:</label>
                                        <input type="text" id="address1" name="address1" class="form-control" style="width: 170px" required>
                                    </p>

                                    <p>
                                        <label for="address2">Address Line 2:</label>
                                        <input type="text" id="address2" name="address2" class="form-control" style="width: 170px">
                                    </p>

                                    <p>
                                        <label for="address3">Address Line 3:</label>
                                        <input type="text" id="address3" name="address3" class="form-control" style="width: 170px">
                                    </p>

                                    <p>
                                        <label for="town">Post Town:</label>
                                        <input type="text" id="town" name="town" class="form-control" style="width: 170px">
                                    </p>

                                    <p>
                                        <label for="post_code">Post Code:</label>
                                        <input type="text" id="post_code" name="post_code" class="form-control" style="width: 170px" required value="<?php
                                    if (isset($data2['postcode'])) {
                                        echo $data2['postcode'];
                                    }
                                    ?>">
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- END OF ADD CLIENT -->

                    <div class="panel-group">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Add Product</div>
                            <div class="panel-body">

                                <div class="col-md-4">

                                    <p>
                                        <label for='client_name'>Client Name</label>
                                        <select class='form-control' name='pol_1_client_name' id='client_name' style='width: 170px' required>
                                            <option value="<?php echo "$title $forname $surname"; ?>"><?php echo "$title $forname $surname"; ?></option>
                                            <option value="<?php echo "$title2 $forname2 $surname2"; ?>"><?php echo "$title $forname2 $surname2"; ?></option>
                                            <option value="<?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?>" <?php
                                            if (isset($data4['pol_1_soj'])) {
                                                if ($data4['pol_1_soj'] == 'J') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>><?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?></option>
                                        </select>
                                    </p> 

                                    <p>
                                    <div class="form-group">
                                        <label for="soj">Single or Joint:</label>
                                        <select class="form-control" name="pol_num_1_soj" id="soj" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="Single" <?php
                                            if (isset($data4['pol_num_1_soj'])) {
                                                if ($data4['pol_num_1_soj'] == 'S') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Single</option>
                                            <option value="Joint" <?php
                                            if (isset($data4['pol_num_1_soj'])) {
                                                if ($data4['pol_num_1_soj'] == 'J') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Joint</option>
                                        </select>
                                    </div>
                                    </p>

                                    <p>
                                        <label for="sale_date">Sale Date:</label>
                                        <input type="text" id="sale_date" name="sale_date" value="<?php echo $date = date('Y-m-d H:i:s'); ?>" placeholder="<?php echo $date = date('Y-m-d H:i:s'); ?>"class="form-control" style="width: 170px" required>
                                    </p>
                                    <br>

                                    <p>
                                        <label for="application_number">Application Number:</label>
                                        <input type="text" id="application_number" name="pol_1_an"  class="form-control" style="width: 170px" placeholder="For WOL use One Family" required> 
                                    </p>
                                    <br>

                                    <p>
                                        <label for="policy_number">Policy Number:</label>
                                        <input type='text' id='policy_number' name='pol_num_1' placeholder="For WOL use One Family" class="form-control" autocomplete="off" style="width: 170px" placeholder="TBC" value="<?php
                                    if (isset($data4['pol_num_1'])) {
                                        echo $data4['pol_num_1'];
                                    }
                                    ?>">
                                    </p>

                                    <p>
                                    <div class="form-group">
                                        <label for="type">Type:</label>
                                        <select class="form-control" name="pol_num_1_type" id="type" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="LTA" <?php
                                    if (isset($data4['pol_num_1_type'])) {
                                        if ($data4['pol_num_1_type'] == '1') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>LTA</option>
                                            <option value="LTA SIC" <?php
                                    if (isset($data4['pol_num_1_type'])) {
                                        if ($data4['pol_num_1_type'] == 'LTA SIC') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>LTA SIC (Vitality)</option>
                                            <option value="LTA CIC" <?php
                                    if (isset($data4['pol_num_1_type'])) {
                                        if ($data4['pol_num_1_type'] == '2') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>LTA + CIC</option>
                                            <option value="DTA" <?php
                                                   if (isset($data4['pol_num_1_type'])) {
                                                       if ($data4['pol_num_1_type'] == '3') {
                                                           echo "selected";
                                                       }
                                                   }
                                                   ?>>DTA</option>
                                            <option value="DTA CIC" <?php
                                                   if (isset($data4['pol_num_1_type'])) {
                                                       if ($data4['pol_num_1_type'] == '4') {
                                                           echo "selected";
                                                       }
                                                   }
                                                   ?>>DTA + CIC</option>
                                            <option value="CIC" <?php
                                    if (isset($data4['pol_num_1_type'])) {
                                        if ($data4['pol_num_1_type'] == '5') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>CIC</option>
                                            <option value="FPIP" <?php
                                    if (isset($data4['pol_num_1_type'])) {
                                        if ($data4['pol_num_1_type'] == 'FPIP') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>FPIP</option>
                                            <option value="WOL" <?php
                                    if (isset($data4['pol_num_1_type'])) {
                                        if ($data4['pol_num_1_type'] == 'WOL') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>WOL</option>
                                        </select>
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-group">
                                        <label for="insurer">Insurer:</label>
                                        <select class="form-control" name="insurer" id="insurer" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="Legal and General">Legal & General</option>
                                            <option value="Vitality">Vitality</option>
                                            <option value="Assura">Assura</option>
                                            <option value="Bright Grey">Bright Grey</option>
                                            <option value="One Family">One Family</option>
                                        </select>
                                    </div>
                                    </p>

                                </div>

                                <div class="col-md-4">

                                    <p>
                                    <div class="form-row">
                                        <label for="premium">Premium:</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="pol_num_1_pre" required value="<?php
                                    if (isset($data4['pol_num_1_pre'])) {
                                        echo $data4['pol_num_1_pre'];
                                    }
                                    ?>"/>
                                        </div> 
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-row">
                                        <label for="commission">Commission</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="pol_num_1_com" required value="<?php
                                    if (isset($data4['pol_num_1_com'])) {
                                        echo $data4['pol_num_1_com'];
                                    }
                                    ?>"/>
                                        </div> 
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-row">
                                        <label for="commission">Cover Amount</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="pol_num_1_cov" required value="<?php
                                    if (isset($data4['pol_num_1_cov'])) {
                                        echo $data4['pol_num_1_cov'];
                                    }
                                    ?>"/>
                                        </div> 
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-row">
                                        <label for="commission">Drip</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="pol_num_1_drip" required/>
                                        </div> 
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-row">
                                        <label for="commission">Policy Term</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">yrs</span>
                                            <input style="width: 140px" autocomplete="off" type="text" class="form-control" id="polterm" name="pol_num_1_yr" required value="<?php
                                    if (isset($data4['pol_num_1_yr'])) {
                                        echo $data4['pol_num_1_yr'];
                                    }
                                                   ?>"/>
                                        </div> 
                                    </div>
                                    </p>

                                </div>

                                <div class="col-md-4">

                                    <p>
                                    <div class="form-group">
                                        <label for="CommissionType">Comms:</label>
                                        <select class="form-control" name="pol_num_1_CommissionType" id="CommissionType" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="Indemnity">Indemnity</option>
                                            <option value="Non Idenmity">Non-Idemnity</option>
                                            <option value="NA">N/A</option>
                                        </select>
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-group">
                                        <label for="comm_term">Clawback Term:</label>
                                        <select class="form-control" name="pol_num_1_comm_term" id="comm_term" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="52">52</option>
                                            <option value="51">51</option>
                                            <option value="50">50</option>
                                            <option value="49">49</option>
                                            <option value="48">48</option>
                                            <option value="47">47</option>
                                            <option value="46">46</option>
                                            <option value="45">45</option>
                                            <option value="44">44</option>
                                            <option value="43">43</option>
                                            <option value="42">42</option>
                                            <option value="41">41</option>
                                            <option value="40">40</option>
                                            <option value="39">39</option>
                                            <option value="38">38</option>
                                            <option value="37">37</option>
                                            <option value="36">36</option>
                                            <option value="35">35</option>
                                            <option value="34">34</option>
                                            <option value="33">33</option>
                                            <option value="32">32</option>
                                            <option value="31">31</option>
                                            <option value="30">30</option>
                                            <option value="29">29</option>
                                            <option value="28">28</option>
                                            <option value="27">27</option>
                                            <option value="26">26</option>
                                            <option value="25">25</option>
                                            <option value="24">24</option>
                                            <option value="23">23</option>
                                            <option value="22">22</option>
                                            <option value="12">12</option>
                                            <option value="1 year">1 year</option>
                                            <option value="0">0</option>
                                        </select>
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-group">
                                        <label for="PolicyStatus">Policy Status:</label>
                                        <select class="form-control" name="pol_num_1_pol_status" id="PolicyStatus" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="Live">Live</option>
                                            <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
                                            <option value="Not Live">Not Live</option>
                                            <option value="NTU">NTU</option>
                                            <option value="Declined">Declined</option>  
                                            <option value="Redrawn">Redrawn</option>
                                        </select>
                                    </div>
                                    </p>

                                    <p>
                                        <label for="closer">Closer:</label>
                                        <input type='text' id='closer' name='closer' style="width: 170px" class="form-control" style="width: 170px" required value="<?php
                                if (isset($data2['closer'])) {
                                    echo $data2['closer'];
                                }
                                ?>">
                                    </p>
                                    <script>var options = {
                                            url: "/JSON/CloserNames.json",
                                            getValue: "full_name",
                                            list: {
                                                match: {
                                                    enabled: true
                                                }
                                            }
                                        };

                                        $("#closer").easyAutocomplete(options);
                                    </script>

                                    <p>
                                        <label for="lead">Lead Gen:</label>
                                        <input type='text' id='lead' name='agent' style="width: 170px" class="form-control" style="width: 170px" required value="<?php
                                            if (isset($data2['agent'])) {
                                                echo $data2['agent'];
                                            }
                                            ?>">
                                    </p>
                                    <script>var options = {
                                            url: "/JSON/LeadGenNames.json",
                                            getValue: "full_name",
                                            list: {
                                                match: {
                                                    enabled: true
                                                }
                                            }
                                        };

                                        $("#lead").easyAutocomplete(options);
                                    </script>

                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- END OF ADD POLICY 1 --->

                                            <?php if (isset($data4['pol_num_2'])) { ?>

                        <div class="panel-group">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Add Product 2</div>
                                <div class="panel-body">

                                    <div class="col-md-4">

                                        <p>
                                            <label for='pol_2_client_name'>Client Name</label>
                                            <select class='form-control' name='pol_2_client_name' id='client_name' style='width: 170px' required>
                                                <option value="<?php echo "$title $forname $surname"; ?>"><?php echo "$title $forname $surname"; ?></option>
                                                <option value="<?php echo "$title2 $forname2 $surname2"; ?>"><?php echo "$title $forname2 $surname2"; ?></option>
                                                <option value="<?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?>" <?php
                                    if (isset($data4['pol_num_2_soj'])) {
                                        if ($data4['pol_num_2_soj'] == 'J') {
                                            echo "selected";
                                        }
                                    }
                                    ?>><?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?></option>
                                            </select>
                                        </p>

                                        <p>
                                        <div class="form-group">
                                            <label for="soj">Single or Joint:</label>
                                            <select class="form-control" name="pol_num_2_soj" id="soj" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="Single" <?php
                                    if (isset($data4['pol_num_2_soj'])) {
                                        if ($data4['pol_num_2_soj'] == 'S') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>Single</option>
                                                <option value="Joint" <?php
                                    if (isset($data4['pol_num_2_soj'])) {
                                        if ($data4['pol_num_2_soj'] == 'J') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>Joint</option>
                                            </select>
                                        </div>
                                        </p>

                                        <p>
                                            <label for="application_number">Application Number:</label>
                                            <input type="text" id="application_number" name="pol_2_an"  class="form-control" style="width: 170px" placeholder="For WOL use One Family" required>
                                        </p>
                                        <br>

                                        <p>
                                            <label for="policy_number">Policy Number:</label>
                                            <input type='text' id='policy_number' name='pol_num_2' class="form-control" placeholder="For WOL use One Family" autocomplete="off" style="width: 170px" placeholder="TBC" value="<?php
                                    if (isset($data4['pol_num_2'])) {
                                        echo $data4['pol_num_2'];
                                    }
                                    ?>">
                                        </p>

                                        <p>
                                        <div class="form-group">
                                            <label for="type">Type:</label>
                                            <select class="form-control" name="pol_num_2_type" id="type" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="LTA" <?php
                                    if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == '1') {
                                            echo "selected";
                                        }
                                    }
                                                ?>>LTA</option>
                                                <option value="LTA SIC" <?php
                                    if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == 'LTA SIC') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>LTA SIC (Vitality)</option>
                                                <option value="LTA CIC" <?php
                                    if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == '2') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>LTA + CIC</option>
                                                <option value="DTA" <?php
                                    if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == '3') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>DTA</option>
                                                <option value="DTA CIC" <?php
                                    if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == '4') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>DTA + CIC</option>
                                                <option value="CIC" <?php
                                    if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == '5') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>CIC</option>
                                                <option value="FPIP" <?php
                                    if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == 'FPIP') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>FPIP</option>
                                                <option value="WOL" <?php
                                    if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == 'WOL') {
                                            echo "selected";
                                        }
                                    }
                                    ?>>WOL</option>
                                            </select>
                                        </div>
                                        </p>

                                    </div>

                                    <div class="col-md-4">

                                        <p>
                                        <div class="form-row">
                                            <label for="premium">Premium:</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="pol_num_2_pre" required value="<?php
                                    if (isset($data4['pol_num_2_pre'])) {
                                        echo $data4['pol_num_2_pre'];
                                    }
                                    ?>"/>
                                            </div> 
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Commission</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="pol_num_2_com" required value="<?php
                                    if (isset($data4['pol_num_2_com'])) {
                                        echo $data4['pol_num_2_com'];
                                    }
                                    ?>"/>
                                            </div>
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Cover Amount</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="pol_num_2_cov" required value="<?php
                                    if (isset($data4['pol_num_2_cov'])) {
                                        echo $data4['pol_num_2_cov'];
                                    }
                                    ?>"/>
                                            </div> 
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Drip</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="pol_num_2_drip" required/>
                                            </div> 
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Policy Term</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">yrs</span>
                                                <input style="width: 140px" autocomplete="off" type="text" class="form-control" id="polterm" name="pol_num_2_yr" required value="<?php
                                                if (isset($data4['pol_num_2_yr'])) {
                                                    echo $data4['pol_num_2_yr'];
                                                }
                                                ?>"/>
                                            </div> 
                                        </div>
                                        </p>
                                    </div>

                                    <div class="col-md-4">

                                        <p>
                                        <div class="form-group">
                                            <label for="CommissionType">Comms:</label>
                                            <select class="form-control" name="pol_num_2_CommissionType" id="CommissionType" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="Indemnity">Indemnity</option>
                                                <option value="Non Idenmity">Non-Idemnity</option>
                                                <option value="NA">N/A</option>
                                            </select>
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-group">
                                            <label for="comm_term">Clawback Term:</label>
                                            <select class="form-control" name="pol_num_2_comm_term" id="comm_term" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="52">52</option>
                                                <option value="51">51</option>
                                                <option value="50">50</option>
                                                <option value="49">49</option>
                                                <option value="48">48</option>
                                                <option value="47">47</option>
                                                <option value="46">46</option>
                                                <option value="45">45</option>
                                                <option value="44">44</option>
                                                <option value="43">43</option>
                                                <option value="42">42</option>
                                                <option value="41">41</option>
                                                <option value="40">40</option>
                                                <option value="39">39</option>
                                                <option value="38">38</option>
                                                <option value="37">37</option>
                                                <option value="36">36</option>
                                                <option value="35">35</option>
                                                <option value="34">34</option>
                                                <option value="33">33</option>
                                                <option value="32">32</option>
                                                <option value="31">31</option>
                                                <option value="30">30</option>
                                                <option value="29">29</option>
                                                <option value="28">28</option>
                                                <option value="27">27</option>
                                                <option value="26">26</option>
                                                <option value="25">25</option>
                                                <option value="24">24</option>
                                                <option value="23">23</option>
                                                <option value="22">22</option>
                                                <option value="12">12</option>
                                                <option value="1 year">1 year</option>
                                                <option value="0">0</option>
                                            </select>
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-group">
                                            <label for="PolicyStatus">Policy Status:</label>
                                            <select class="form-control" name="pol_num_2_pol_status" id="PolicyStatus" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="Live">Live</option>
                                                <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
                                                <option value="Not Live">Not Live</option>
                                                <option value="NTU">NTU</option>
                                                <option value="Declined">Declined</option>
                                                <option value="Redrawn">Redrawn</option>
                                            </select>
                                        </div>
                                        </p>

                                    </div>

                                </div>
                            </div>
                        </div>  

        <?php } ?> 
                    <!-- END OF ADD POLICY 2 --->

        <?php if (isset($data4['pol_num_3'])) { ?>

                        <div class="panel-group">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Add Product 3</div>
                                <div class="panel-body">

                                    <div class="col-md-4">

                                        <p>
                                            <label for='client_name'>Client Name</label>
                                            <select class='form-control' name='pol_3_client_name' id='client_name' style='width: 170px' required>
                                                <option value="<?php echo "$title $forname $surname"; ?>"><?php echo "$title $forname $surname"; ?></option>
                                                <option value="<?php echo "$title2 $forname2 $surname2"; ?>"><?php echo "$title $forname2 $surname2"; ?></option>
                                                <option value="<?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?>" <?php
            if (isset($data4['pol_num_3_soj'])) {
                if ($data4['pol_num_3_soj'] == 'J') {
                    echo "selected";
                }
            }
            ?>><?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?></option>
                                            </select>
                                        </p>

                                        <p>
                                        <div class="form-group">
                                            <label for="soj">Single or Joint:</label>
                                            <select class="form-control" name="pol_num_3_soj" id="soj" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="Single" <?php
                                           if (isset($data4['pol_num_3_soj'])) {
                                               if ($data4['pol_num_3_soj'] == 'S') {
                                                   echo "selected";
                                               }
                                           }
                                           ?>>Single</option>
                                                <option value="Joint" <?php
                                           if (isset($data4['pol_num_3_soj'])) {
                                               if ($data4['pol_num_3_soj'] == 'J') {
                                                   echo "selected";
                                               }
                                           }
            ?>>Joint</option>
                                            </select>
                                        </div>
                                        </p>

                                        <p>
                                            <label for="application_number">Application Number:</label>
                                            <input type="text" id="application_number" name="pol_3_an"  class="form-control" style="width: 170px" placeholder="For WOL use One Family" required>
                                        </p>
                                        <br>

                                        <p>
                                            <label for="policy_number">Policy Number:</label>
                                            <input type='text' id='policy_number' name='pol_num_3' placeholder="For WOL use One Family" class="form-control" autocomplete="off" style="width: 170px" placeholder="TBC" value="<?php
                                           if (isset($data4['pol_num_3'])) {
                                               echo $data4['pol_num_3'];
                                           }
                                           ?>">
                                        </p>

                                        <p>
                                        <div class="form-group">
                                            <label for="type">Type:</label>
                                            <select class="form-control" name="pol_num_3_type" id="type" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="LTA" <?php
                                           if (isset($data4['pol_num_3_type'])) {
                                               if ($data4['pol_num_3_type'] == '1') {
                                                   echo "selected";
                                               }
                                           }
                                           ?>>LTA</option>
                                                <option value="LTA SIC" <?php
                                           if (isset($data4['pol_num_3_type'])) {
                                               if ($data4['pol_num_3_type'] == 'LTA SIC') {
                                                   echo "selected";
                                               }
                                           }
                                           ?>>LTA SIC (Vitality)</option>
                                                <option value="LTA CIC" <?php
                                           if (isset($data4['pol_num_3_type'])) {
                                               if ($data4['pol_num_3_type'] == '2') {
                                                   echo "selected";
                                               }
                                           }
                                           ?>>LTA + CIC</option>
                                                <option value="DTA" <?php
                                           if (isset($data4['pol_num_3_type'])) {
                                               if ($data4['pol_num_3_type'] == '3') {
                                                   echo "selected";
                                               }
                                           }
                                           ?>>DTA</option>
                                                <option value="DTA CIC" <?php
                                           if (isset($data4['pol_num_3_type'])) {
                                               if ($data4['pol_num_3_type'] == '4') {
                                                   echo "selected";
                                               }
                                           }
                                           ?>>DTA + CIC</option>
                                                <option value="CIC" <?php
                                           if (isset($data4['pol_num_3_type'])) {
                                               if ($data4['pol_num_3_type'] == '5') {
                                                   echo "selected";
                                               }
                                           }
                                           ?>>CIC</option>
                                                <option value="FPIP" <?php
                                           if (isset($data4['pol_num_3_type'])) {
                                               if ($data4['pol_num_3_type'] == 'FPIP') {
                                                   echo "selected";
                                               }
                                           }
                                           ?>>FPIP</option>
                                                <option value="WOL" <?php
                                           if (isset($data4['pol_num_3_type'])) {
                                               if ($data4['pol_num_3_type'] == 'WOL') {
                                                   echo "selected";
                                               }
                                           }
                                           ?>>WOL</option>
                                            </select>
                                        </div>
                                        </p>

                                    </div>

                                    <div class="col-md-4">

                                        <p>
                                        <div class="form-row">
                                            <label for="premium">Premium:</label>    
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="pol_num_3_pre" required value="<?php
                                           if (isset($data4['pol_num_3_pre'])) {
                                               echo $data4['pol_num_3_pre'];
                                           }
                                           ?>"/>
                                            </div> 
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Commission</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="pol_num_3_com" required value="<?php
                                           if (isset($data4['pol_num_3_com'])) {
                                               echo $data4['pol_num_3_com'];
                                           }
                                           ?>"/>
                                            </div> 
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Cover Amount</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="pol_num_3_cov" required value="<?php
                                                        if (isset($data4['pol_num_3_cov'])) {
                                                            echo $data4['pol_num_3_cov'];
                                                        }
                                                        ?>"/>
                                            </div> 
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Drip</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="pol_num_3_drip" required/>
                                            </div> 
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Policy Term</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">yrs</span>
                                                <input style="width: 140px" autocomplete="off" type="text" class="form-control" id="polterm" name="pol_num_3_yr" required value="<?php
                                                if (isset($data4['pol_num_3_yr'])) {
                                                    echo $data4['pol_num_3_yr'];
                                                }
                                                ?>"/>
                                            </div> 
                                        </div>
                                        </p>

                                    </div>

                                    <div class="col-md-4">

                                        <p>
                                        <div class="form-group">
                                            <label for="CommissionType">Comms:</label>
                                            <select class="form-control" name="pol_num_3_CommissionType" id="CommissionType" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="Indemnity">Indemnity</option>
                                                <option value="Non Idenmity">Non-Idemnity</option>
                                                <option value="NA">N/A</option>
                                            </select>
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-group">
                                            <label for="comm_term">Clawback Term:</label>
                                            <select class="form-control" name="pol_num_3_comm_term" id="comm_term" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="52">52</option>
                                                <option value="51">51</option>
                                                <option value="50">50</option>
                                                <option value="49">49</option>
                                                <option value="48">48</option>
                                                <option value="47">47</option>
                                                <option value="46">46</option>
                                                <option value="45">45</option>
                                                <option value="44">44</option>
                                                <option value="43">43</option>
                                                <option value="42">42</option>
                                                <option value="41">41</option>
                                                <option value="40">40</option>
                                                <option value="39">39</option>
                                                <option value="38">38</option>
                                                <option value="37">37</option>
                                                <option value="36">36</option>
                                                <option value="35">35</option>
                                                <option value="34">34</option>
                                                <option value="33">33</option>
                                                <option value="32">32</option>
                                                <option value="31">31</option>
                                                <option value="30">30</option>
                                                <option value="29">29</option>
                                                <option value="28">28</option>
                                                <option value="27">27</option>
                                                <option value="26">26</option>
                                                <option value="25">25</option>
                                                <option value="24">24</option>
                                                <option value="23">23</option>
                                                <option value="22">22</option>
                                                <option value="12">12</option>
                                                <option value="1 year">1 year</option>
                                                <option value="0">0</option>
                                            </select>
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-group">
                                            <label for="PolicyStatus">Policy Status:</label>
                                            <select class="form-control" name="pol_num_3_pol_status" id="PolicyStatus" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="Live">Live</option>
                                                <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
                                                <option value="Not Live">Not Live</option>
                                                <option value="NTU">NTU</option>
                                                <option value="Declined">Declined</option>
                                                <option value="Redrawn">Redrawn</option>
                                            </select>
                                        </div>
                                        </p>

                                    </div>

                                </div>
                            </div>
                        </div>  
        <?php } ?>      

                    <!-- END OF ADD POLICY 3 --->

        <?php if (isset($data4['pol_num_4'])) { ?>

                        <div class="panel-group">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Add Product 4</div>
                                <div class="panel-body">

                                    <div class="col-md-4">

                                        <p>
                                            <label for='client_name'>Client Name</label>
                                            <select class='form-control' name='pol_4_client_name' id='client_name' style='width: 170px' required>
                                                <option value="<?php echo "$title $forname $surname"; ?>"><?php echo "$title $forname $surname"; ?></option>
                                                <option value="<?php echo "$title2 $forname2 $surname2"; ?>"><?php echo "$title $forname2 $surname2"; ?></option>
                                                <option value="<?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?>" <?php
            if (isset($data4['pol_num_4_soj'])) {
                if ($data4['pol_num_4_soj'] == 'J') {
                    echo "selected";
                }
            }
            ?>><?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?></option>
                                            </select>
                                        </p>

                                        <p>
                                        <div class="form-group">
                                            <label for="soj">Single or Joint:</label>
                                            <select class="form-control" name="pol_num_4_soj" id="soj" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="Single" <?php
            if (isset($data4['pol_num_4_soj'])) {
                if ($data4['pol_num_4_soj'] == 'S') {
                    echo "selected";
                }
            }
            ?>>Single</option>
                                                <option value="Joint" <?php
            if (isset($data4['pol_num_4_soj'])) {
                if ($data4['pol_num_4_soj'] == 'J') {
                    echo "selected";
                }
            }
            ?>>Joint</option>
                                            </select>
                                        </div>
                                        </p>

                                        <p>
                                            <label for="application_number">Application Number:</label>
                                            <input type="text" id="application_number" name="pol_4_an"  class="form-control" style="width: 170px" placeholder="For WOL use One Family" required>
                                        </p>
                                        <br>

                                        <p>
                                            <label for="policy_number">Policy Number:</label>
                                            <input type='text' id='policy_number' name='pol_num_4' placeholder="For WOL use One Family" class="form-control" autocomplete="off" style="width: 170px" placeholder="TBC" value="<?php
            if (isset($data4['pol_num_4'])) {
                echo $data4['pol_num_4'];
            }
            ?>">
                                        </p>

                                        <p>
                                        <div class="form-group">
                                            <label for="type">Type:</label>
                                            <select class="form-control" name="pol_num_4_type" id="type" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="LTA" <?php
            if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '1') {
                    echo "selected";
                }
            }
            ?>>LTA</option>
                                                <option value="LTA SIC" <?php
            if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == 'LTA SIC') {
                    echo "selected";
                }
            }
            ?>>LTA SIC (Vitality)</option>
                                                <option value="LTA CIC" <?php
            if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '2') {
                    echo "selected";
                }
            }
            ?>>LTA + CIC</option>
                                                <option value="DTA" <?php
            if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '3') {
                    echo "selected";
                }
            }
            ?>>DTA</option>  
                                                <option value="DTA CIC" <?php
            if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '4') {
                    echo "selected";
                }
            }
            ?>>DTA + CIC</option>
                                                <option value="CIC" <?php
            if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '5') {
                    echo "selected";
                }
            }
            ?>>CIC</option>
                                                <option value="FPIP" <?php
            if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == 'FPIP') {
                    echo "selected";
                }
            }
            ?>>FPIP</option>
                                                <option value="WOL" <?php
            if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == 'WOL') {
                    echo "selected";
                }
            }
            ?>>WOL</option>
                                            </select>
                                        </div>
                                        </p>

                                    </div>

                                    <div class="col-md-4">
                                        <p>
                                        <div class="form-row">
                                            <label for="premium">Premium:</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="pol_num_4_pre" required value="<?php
            if (isset($data4['pol_num_4_pre'])) {
                echo $data4['pol_num_4_pre'];
            }
            ?>"/>
                                            </div> 
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Commission</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="pol_num_4_com" required value="<?php
            if (isset($data4['pol_num_4_com'])) {
                echo $data4['pol_num_4_com'];
            }
            ?>"/>
                                            </div> 
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Cover Amount</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="pol_num_4_cov" required value="<?php
            if (isset($data4['pol_num_4_cov'])) {
                echo $data4['pol_num_4_cov'];
            }
            ?>"/>
                                            </div> 
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Drip</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="pol_num_4_drip" required/>
                                            </div> 
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Policy Term</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">yrs</span>
                                                <input style="width: 140px" autocomplete="off" type="text" class="form-control" id="polterm" name="pol_num_4_yr" required value="<?php
            if (isset($data4['pol_num_4_yr'])) {
                echo $data4['pol_num_4_yr'];
            }
            ?>"/>
                                            </div> 
                                        </div>
                                        </p>

                                    </div>

                                    <div class="col-md-4">

                                        <p>
                                        <div class="form-group">
                                            <label for="CommissionType">Comms:</label>
                                            <select class="form-control" name="pol_num_4_CommissionType" id="CommissionType" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="Indemnity">Indemnity</option>  
                                                <option value="Non Idenmity">Non-Idemnity</option>
                                                <option value="NA">N/A</option>
                                            </select>
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-group">
                                            <label for="comm_term">Clawback Term:</label>
                                            <select class="form-control" name="pol_num_4_comm_term" id="comm_term" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="52">52</option>
                                                <option value="51">51</option>
                                                <option value="50">50</option>
                                                <option value="49">49</option>
                                                <option value="48">48</option>
                                                <option value="47">47</option>
                                                <option value="46">46</option>
                                                <option value="45">45</option>
                                                <option value="44">44</option>
                                                <option value="43">43</option>
                                                <option value="42">42</option>
                                                <option value="41">41</option>
                                                <option value="40">40</option>
                                                <option value="39">39</option>
                                                <option value="38">38</option>
                                                <option value="37">37</option>
                                                <option value="36">36</option>
                                                <option value="35">35</option>
                                                <option value="34">34</option>
                                                <option value="33">33</option>
                                                <option value="32">32</option>
                                                <option value="31">31</option>
                                                <option value="30">30</option>
                                                <option value="29">29</option>
                                                <option value="28">28</option>
                                                <option value="27">27</option>
                                                <option value="26">26</option>
                                                <option value="25">25</option>
                                                <option value="24">24</option>
                                                <option value="23">23</option>
                                                <option value="22">22</option>
                                                <option value="12">12</option>
                                                <option value="1 year">1 year</option>
                                                <option value="0">0</option>
                                            </select>
                                        </div>
                                        </p>

                                        <p>
                                        <div class="form-group">
                                            <label for="PolicyStatus">Policy Status:</label>
                                            <select class="form-control" name="pol_num_4_pol_status" id="PolicyStatus" style="width: 170px" required>
                                                <option value="">Select...</option>
                                                <option value="Live">Live</option>
                                                <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
                                                <option value="Not Live">Not Live</option>
                                                <option value="NTU">NTU</option>
                                                <option value="Declined">Declined</option>
                                                <option value="Redrawn">Redrawn</option>
                                            </select>
                                        </div>
                                        </p>

                                    </div>

                                </div>
                            </div>
                        </div>  
        <?php } ?>           

                    <!-- END OF ADD POLICY 4 --->

                    <div class="col-md-12"><br></div>

                    <center>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>  
                        <div class="col-md-12"><br></div> 
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> SEND TO ADL</button>
                        </div>
                    </center>
                </form>

            </div>


    <?php }
}
?>
    <script>
        document.querySelector('#Send').addEventListener('submit', function (e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Send Dealsheet?",
                text: "Has the dealsheet been checked by a manger?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, send it!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            swal({
                                title: 'Sent!',
                                text: 'Dealsheet sent!',
                                type: 'success'
                            }, function () {
                                form.submit();
                            });

                        } else {
                            swal("Cancelled", "Dealsheet not sent", "error");
                        }
                    });
        });
    </script>
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
    <script src="/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 

    <script>var options = {
            url: "../JSON/LeadGenNames.json",
            getValue: "full_name",
            list: {
                match: {
                    enabled: true
                }
            }
        };

        $("#provider-json").easyAutocomplete(options);</script>
    <script>var options = {
            url: "/JSON/CloserNames.json",
            getValue: "full_name",
            list: {
                match: {
                    enabled: true
                }
            }
        };

        $("#closer").easyAutocomplete(options);
    </script>
    <script>var options = {
            url: "/JSON/AllNames.json",
            getValue: "full_name",
            list: {
                match: {
                    enabled: true
                }
            }
        };

        $("#lead").easyAutocomplete(options);</script>
    <script src="/js/sweet-alert.min.js"></script>


    <script src="/js/jquery.postcodes.min.js"></script>
    <script>
        $(function () {
            $("#dob").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
    </script>
    <script>
        $(function () {
            $("#dob2").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
    </script>
<?php if ($ffpost_code == '1') { ?>
        <script>
            $('#lookup_field').setupPostcodeLookup({
                api_key: '<?php echo $PostCodeKey; ?>',
                output_fields: {
                    line_1: '#address1',
                    line_2: '#address2',
                    line_3: '#address3',
                    post_town: '#town',
                    postcode: '#post_code'
                }
            });
        </script>
<?php } ?>
    <script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
    <script>
            $(function () {
                $("#sale_date").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "-100:+1"
                });
            });
    </script>
    <script>
        webshims.setOptions('forms-ext', {
            replaceUI: 'auto',
            types: 'number'
        });
        webshims.polyfill('forms forms-ext');
    </script>
</body>
</html>

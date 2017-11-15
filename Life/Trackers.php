<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

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

if ($ffpost_code == '1') {

    $PostcodeQuery = $pdo->prepare("select api_key from api_keys WHERE type ='PostCode' limit 1");
    $PostcodeQuery->execute()or die(print_r($query->errorInfo(), true));
    $PDre = $PostcodeQuery->fetch(PDO::FETCH_ASSOC);
    $PostCodeKey = $PDre['api_key'];
}

if ($ffdealsheets == '0') {
    header('Location: ../CRMmain.php?Feature=NotEnabled');
    die;
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

$Today_DATE = date("d-M-Y");
$Today_DATES = date("l jS \of F Y");
$Today_TIME = date("h:i:s");
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Trackers</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="/styles/Notices.css">
    <link rel="stylesheet" type="text/css" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/styles/sweet-alert.min.css" />
    <link rel="stylesheet" type="text/css" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />
    <link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css">
<link rel="stylesheet" href="/summernote-master/dist/summernote.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <body>

        <?php require_once(__DIR__ . '/../includes/navbar.php'); ?>

        <?php
        if (isset($EXECUTE)) {
            if ($EXECUTE == 'DEFAULT') {
                
                $SETDATES = filter_input(INPUT_POST, 'SETDATES', FILTER_SANITIZE_SPECIAL_CHARS);
  
                ?>

                <div class="container">

                    <div class="col-md-12">

                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>

                        <div class="col-md-4">

                            <?php echo "<h3>$Today_DATES</h3>"; ?>
                            <?php echo "<h4>$Today_TIME</h4>"; ?>

                        </div>

                    </div>

                    <div class="list-group">
                        <span class="label label-primary">All Upsell Trackers</span>
                        <br><br>
                        <form action="?EXECUTE=DEFAULT&CloserSelected" method="post" name="CloserSelectForm" id="CloserSelectForm">

                            <div class="col-md-12">
                                <div class="col-md-4">
                                  
                                </div>

                                <div class="col-md-12"></div>
                                <div class="col-md-2"></div>

                                <div class="col-md-2"><button type="submit" class="btn btn-success btn-sm" name="SETDATES"><i class="fa fa-calendar-check-o"></i> Set Dates</button></div>

                            </div>

                        </form>


        <?php
        $TRACKER_EDIT = $pdo->prepare("SELECT DATE(date_updated) AS updated_date, upsell_notes, upsell_status, upsell_agent, lead_up, mtg, closer, tracker_id, agent, client, phone, current_premium, our_premium, comments, sale FROM closer_trackers WHERE mtg='Yes' OR lead_up='Yes' AND DATE(date_added) >=CURDATE()");
        $TRACKER_EDIT->execute();
        $i=0;
        if ($TRACKER_EDIT->rowCount() > 0) {
            ?>

                                <table id="tracker" class="table table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Updated Date</th>
                                            <th>Closer</th>
                                            <th>Agent</th>
                                            <th>Client</th>
                                            <th>Phone</th>
                                            <th>Current Premium</th>
                                            <th>Our Premium</th>
                                            <th>Comments</th>
                                            <th>DISPO</th>
                                            <th>DEC READ?</th>
                                            <th>MTG</th>
                                            <th>Upsell Status</th>
                                        </tr>
                                    </thead>

                                    <?php
                                    while ($TRACKER_EDIT_result = $TRACKER_EDIT->fetch(PDO::FETCH_ASSOC)) {
$i++;
                                        $TRK_EDIT_tracker_id = $TRACKER_EDIT_result['tracker_id'];
                                        $TRK_EDIT_agent = $TRACKER_EDIT_result['agent'];
                                        $TRK_EDIT_closer = $TRACKER_EDIT_result['closer'];
                                        $TRK_EDIT_client = $TRACKER_EDIT_result['client'];
                                        $TRK_EDIT_phone = $TRACKER_EDIT_result['phone'];
                                        $TRK_EDIT_current_premium = $TRACKER_EDIT_result['current_premium'];

                                        $TRK_EDIT_our_premium = $TRACKER_EDIT_result['our_premium'];
                                        $TRK_EDIT_comments = $TRACKER_EDIT_result['comments'];
                                        $TRK_EDIT_sale = $TRACKER_EDIT_result['sale'];

                                        $TRK_EDIT_MTG = $TRACKER_EDIT_result['mtg'];
                                        $TRK_EDIT_LEAD_UP = $TRACKER_EDIT_result['lead_up'];
                                        
                                        $TRK_EDIT_UPSELLS_AGENT = $TRACKER_EDIT_result['upsell_agent'];
                                        $TRK_EDIT_UPSELLS_STATUS = $TRACKER_EDIT_result['upsell_status'];
                                        $TRK_EDIT_UPSELLS_NOTES = $TRACKER_EDIT_result['upsell_notes'];
                                        $TRK_EDIT_DATE = $TRACKER_EDIT_result['updated_date'];
                                       
                                        ?>

                                        <input type="hidden" value="<?php echo $TRK_EDIT_tracker_id; ?>" name="tracker_id">
                                        <tr>          
                                            <td><?php
                                                if (isset($TRK_EDIT_DATE)) {
                                                    echo $TRK_EDIT_DATE;
                                                }
                                                ?></td>  
                                            <td><?php
                                                if (isset($TRK_EDIT_agent)) {
                                                    echo $TRK_EDIT_closer;
                                                }
                                                ?></td>     
                                            <td><?php
                                                if (isset($TRK_EDIT_agent)) {
                                                    echo $TRK_EDIT_agent;
                                                }
                                                ?></td>                      
                                            <td><?php
                                                    if (isset($TRK_EDIT_client)) {
                                                        echo $TRK_EDIT_client;
                                                    }
                                                    ?></td>
                                            <td><?php
                                                    if (isset($TRK_EDIT_phone)) {
                                                        echo $TRK_EDIT_phone;
                                                    }
                                                    ?></td>
                                            <td><?php
                                                    if (isset($TRK_EDIT_current_premium)) {
                                                        echo $TRK_EDIT_current_premium;
                                                    }
                                                    ?></td>
                                            <td><?php
                                                    if (isset($TRK_EDIT_our_premium)) {
                                                        echo $TRK_EDIT_our_premium;
                                                    }
                                                    ?></td>
                                            <td><?php
                                                    if (isset($TRK_EDIT_comments)) {
                                                        echo $TRK_EDIT_comments;
                                                    }
                                                    ?></td>
                                            <td>
                                                <select name="sale" class="form-control" required>
                                                    <option value="">DISPO</option>
                                                    <option <?php
                                        if (isset($TRK_EDIT_sale)) {
                                            if ($TRK_EDIT_sale == 'SALE') {
                                                echo "selected";
                                            }
                                        }
                                                    ?> value="SALE">Sale</option>
                                                    <option <?php
                                                    if (isset($TRK_EDIT_sale)) {
                                                        if ($TRK_EDIT_sale == 'QUN') {
                                                            echo "selected";
                                                        }
                                                    }
                                                    ?> value="QUN">Underwritten</option>
                                                    <option <?php
                                                        if (isset($TRK_EDIT_sale)) {
                                                            if ($TRK_EDIT_sale == 'QQQ') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="QQQ">Quoted</option>
                                                    <option <?php
                                                    if (isset($TRK_EDIT_sale)) {
                                                        if ($TRK_EDIT_sale == 'QNQ') {
                                                            echo "selected";
                                                        }
                                                    }
                                                    ?> value="QNQ">No Quote</option>
                                                    <option <?php
                                                    if (isset($TRK_EDIT_sale)) {
                                                        if ($TRK_EDIT_sale == 'QML') {
                                                            echo "selected";
                                                        }
                                                    }
                                                    ?> value="QML">Quote Mortgage Lead</option>
                                                    <option <?php
                                            if (isset($TRK_EDIT_sale)) {
                                                if ($TRK_EDIT_sale == 'QDE') {
                                                    echo "selected";
                                                }
                                            }
                                            ?> value="QDE">Decline</option>
                                                    <option <?php
                                        if (isset($TRK_EDIT_sale)) {
                                            if ($TRK_EDIT_sale == 'QCBK') {
                                                echo "selected";
                                            }
                                        }
                                        ?> value="QCBK">Quoted Callback</option>
                                                    <option <?php
                                        if (isset($TRK_EDIT_sale)) {
                                            if ($TRK_EDIT_sale == 'NoCard') {
                                                echo "selected";
                                            }
                                        }
                                        ?> value="NoCard">No Card</option>
                                                    <option <?php
                if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'DIDNO') {
                        echo "selected";
                    }
                }
                ?> value="DIDNO">Quote Not Beaten</option>
                                                    <option <?php
                if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'DETRA') {
                        echo "selected";
                    }
                }
                ?> value="DETRA">Declined but passed to upsale</option>
                                                    <option <?php
                if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'Other') {
                        echo "selected";
                    }
                }
                ?> value="Other">Other</option>
                                                </select>
                                            </td>

                                            <td>

                                       <?php if (isset($TRK_EDIT_LEAD_UP)) { echo $TRK_EDIT_LEAD_UP;
                } ?> 

                                            </td>
                                        <td>

                <?php if (isset($TRK_EDIT_MTG)) {
                    echo $TRK_EDIT_MTG;
                } ?> 
                                        </td>
                                        <td><?php if(isset($TRK_EDIT_UPSELLS_STATUS)) { echo $TRK_EDIT_UPSELLS_STATUS; } ?> </td>
                                        <td><button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#<?php echo $TRK_EDIT_tracker_id; ?>Upsells"><i class="fa fa-save"></i> UPDATE</button></td> 
                                        </tr>
                                       

<div id="<?php echo $TRK_EDIT_tracker_id; ?>Upsells" class="modal fade" role="dialog">
 <div class='modal-dialog modal-lg'>
echo date_format($TRK_EDIT_DATE, 'l jS \of F Y');
    <div class="modal-content">
      <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php if(isset($TRK_EDIT_UPSELLS_AGENT)) { echo "Updated by $TRK_EDIT_UPSELLS_AGENT on $TRK_EDIT_DATE"; } ?> </h4>
      </div>
      <div class="modal-body">
          <div class="container">
              <form method="POST" action="php/Tracker.php?TID=<?php echo $TRK_EDIT_tracker_id; ?>&EXECUTE=1">
             
                                          <div class="row">
                                <div class='col-md-4'>
                                    <div class="form-group">
                                        <div class='input-group' id='status'>
                                            <input type='text' class="form-control" id="UPSELLS_STATUS" name="UPSELLS_STATUS" placeholder="Status" value="<?php if(isset($TRK_EDIT_UPSELLS_STATUS)) { echo $TRK_EDIT_UPSELLS_STATUS; } ?>" required />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>     
              
                                          <div class="row">
                                <div class='col-md-8'>
                                    <div class="form-group"> 
                                        <textarea class="form-control summernote" id="textarea" name="UPSELLS_NOTES" placeholder="Notes"><?php if(isset($TRK_EDIT_UPSELLS_NOTES)) { echo $TRK_EDIT_UPSELLS_NOTES; } ?></textarea>
                                    </div>
                                </div>
                            </div>
             
      </div>
      <div class="modal-footer">
          <div class="btn-group">
         <button type="submit" class="btn btn-success">SAVE</button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 </form> 
</div>
      </div>
    </div>

  </div>
</div>                                        
                                        
                <?php
            }
        }
        ?>

                            </table>
                  

                    </div>
                </div>

        <?php }
        
        if($EXECUTE=='1') { ?>
                    
  <div class="container">

                    <div class="col-md-12">

                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>

                        <div class="col-md-4">

                            <?php echo "<h3>$Today_DATES</h3>"; ?>
                            <?php echo "<h4>$Today_TIME</h4>"; ?>

                        </div>

                    </div>

                    <div class="list-group">
                        <span class="label label-primary">All Trackers</span>
                        <br><br>
                        <form action="?EXEXUTE=2" method="post">

                            <div class="col-md-12">
                                <div class="col-md-4">
                                  <select class="form-control" name="USER" id="USER">
                                <option value="Agent">Agent</option>
                                <option value="Mike">Mike</option>
                                <option value="David">David</option>
                                <option value="Sarah">Sarah</option>
                                <option value="Hayley">Hayley</option>
                                <option value="Richard">Richard</option>
                                <option value="Gavin">Gavin</option>
                                <option value="Kyle">Kyle</option>
                                <option value="James">Jamess<option>
                            </select>
                                </div>

                                <div class="col-md-12"></div>
                                <div class="col-md-2"></div>

                                <div class="col-md-2"><button type="submit" class="btn btn-success btn-sm" name="SETDATES"><i class="fa fa-calendar-check-o"></i> Set Dates</button></div>

                            </div>

                        </form>


        <?php
        $TRACKER_EDIT = $pdo->prepare("SELECT DATE(date_updated) AS updated_date, lead_up, mtg, closer, tracker_id, agent, client, phone, current_premium, our_premium, comments, sale FROM closer_trackers WHERE date_updated >= CURDATE() ORDER BY date_added");
        $TRACKER_EDIT->execute();
        $i=0;
        if ($TRACKER_EDIT->rowCount() > 0) {
            ?>

                                <table id="tracker" class="table table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Updated Date</th>
                                            <th>Closer</th>
                                            <th>Agent</th>
                                            <th>Client</th>
                                            <th>Phone</th>
                                            <th>Current Premium</th>
                                            <th>Our Premium</th>
                                            <th>Comments</th>
                                            <th>DISPO</th>
                                            <th>DEC READ?</th>
                                            <th>MTG</th>
                                        </tr>
                                    </thead>

                                    <?php
                                    while ($TRACKER_EDIT_result = $TRACKER_EDIT->fetch(PDO::FETCH_ASSOC)) {
$i++;
                                        $TRK_EDIT_tracker_id = $TRACKER_EDIT_result['tracker_id'];
                                        $TRK_EDIT_agent = $TRACKER_EDIT_result['agent'];
                                        $TRK_EDIT_closer = $TRACKER_EDIT_result['closer'];
                                        $TRK_EDIT_client = $TRACKER_EDIT_result['client'];
                                        $TRK_EDIT_phone = $TRACKER_EDIT_result['phone'];
                                        $TRK_EDIT_current_premium = $TRACKER_EDIT_result['current_premium'];

                                        $TRK_EDIT_our_premium = $TRACKER_EDIT_result['our_premium'];
                                        $TRK_EDIT_comments = $TRACKER_EDIT_result['comments'];
                                        $TRK_EDIT_sale = $TRACKER_EDIT_result['sale'];

                                        $TRK_EDIT_MTG = $TRACKER_EDIT_result['mtg'];
                                        $TRK_EDIT_LEAD_UP = $TRACKER_EDIT_result['lead_up'];

                                        $TRK_EDIT_DATE = $TRACKER_EDIT_result['updated_date'];
                                       
                                        ?>

                                    <input type="hidden" value="<?php echo $TRK_EDIT_tracker_id; ?>" name="tracker_id">
                                    <tr>
                                                                <td><input size="12" class="form-control" type="text" name="closer" id="provider-json" value="<?php if (isset($TRK_EDIT_agent)) {
                    echo $TRK_EDIT_closer;
                } ?>"></td>     
                                <td><input size="12" class="form-control" type="text" name="agent_name" id="provider-json" value="<?php if (isset($TRK_EDIT_agent)) {
                    echo $TRK_EDIT_agent;
                } ?>"></td>                      
                                <td><input size="12" class="form-control" type="text" name="client" value="<?php if (isset($TRK_EDIT_client)) {
                    echo $TRK_EDIT_client;
                } ?>"></td>
                                <td><input size="12" class="form-control" type="text" name="phone" value="<?php if (isset($TRK_EDIT_phone)) {
                    echo $TRK_EDIT_phone;
                } ?>"></td>
                                <td><input size="8" class="form-control" type="text" name="current_premium" value="<?php if (isset($TRK_EDIT_current_premium)) {
                    echo $TRK_EDIT_current_premium;
                } ?>"></td>
                                <td><input size="8" class="form-control" type="text" name="our_premium" value="<?php if (isset($TRK_EDIT_our_premium)) {
                    echo $TRK_EDIT_our_premium;
                } ?>"></td>
                                <td><input type="text" class="form-control" name="comments" value="<?php if (isset($TRK_EDIT_comments)) {
                    echo $TRK_EDIT_comments;
                } ?>"></td>
                                <td>
                                    <select name="sale" class="form-control" required>
                                        <option value="">DISPO</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'SALE') {
                        echo "selected";
                    }
                } ?> value="SALE">Sale</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QUN') {
                        echo "selected";
                    }
                } ?> value="QUN">Underwritten</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QQQ') {
                        echo "selected";
                    }
                } ?> value="QQQ">Quoted</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QNQ') {
                        echo "selected";
                    }
                } ?> value="QNQ">No Quote</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QML') {
                        echo "selected";
                    }
                } ?> value="QML">Quote Mortgage Lead</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QDE') {
                        echo "selected";
                    }
                } ?> value="QDE">Decline</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QCBK') {
                        echo "selected";
                    }
                } ?> value="QCBK">Quoted Callback</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'NoCard') {
                        echo "selected";
                    }
                } ?> value="NoCard">No Card</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'DIDNO') {
                        echo "selected";
                    }
                } ?> value="DIDNO">Quote Not Beaten</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'DETRA') {
                        echo "selected";
                    }
                } ?> value="DETRA">Declined but passed to upsale</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'Other') {
                        echo "selected";
                    }
                } ?> value="Other">Other</option>
                                    </select>
                                </td>
                                
                                <td>
                                    <select name="LEAD_UP">
                                        <option <?php if(isset($TRK_EDIT_LEAD_UP) && $TRK_EDIT_LEAD_UP=='No') { echo "selected"; } ?> value="No">No</option>
                                        <option <?php if(isset($TRK_EDIT_LEAD_UP) && $TRK_EDIT_LEAD_UP=='Yes') { echo "selected"; } ?> value="Yes">Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="MTG">
                                        <option <?php if(isset($TRK_EDIT_MTG) && $TRK_EDIT_MTG=='No') { echo "selected"; } ?> value="No">No</option>
                                        <option <?php if(isset($TRK_EDIT_MTG) && $TRK_EDIT_MTG=='Yes') { echo "selected"; } ?> value="Yes">Yes</option>
                                    </select>
                                </td>
                                
                                <td><button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-save"></i> UPDATE</button></td> 
                                <td><a href="?query=AllCloserTrackers" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> CANCEL</a></td>
                                    </tr>
                                 
                <?php
            }
        }
        ?>

                            </table>
                  

                    </div>
                </div>                    
            
     <?php   }
}
?>

    </div>

    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
    <script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
    <script type="text/javascript" src="/summernote-master/dist/summernote.js"></script>

  <script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200
      });


    });
  </script>
    <script>
        $(function () {
            $("#date_search").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
    </script>
</body>
</html>

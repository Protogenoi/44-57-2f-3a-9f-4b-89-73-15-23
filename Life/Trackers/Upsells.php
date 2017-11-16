<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}


if ($ffdealsheets == '0') {
    header('Location: /../../../CRMmain.php?Feature=NotEnabled');
    die;
}
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

$Today_DATE = date("d-M-Y");
$Today_DATES = date("l jS \of F Y");
$Today_TIME = date("h:i:s");
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Upsell Trackers</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="/resources/templates/ADL/Notices.css">
    <link rel="stylesheet" type="text/css" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
    <link rel="stylesheet" type="text/css" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css" />
    <link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css">
<link rel="stylesheet" href="/resources/lib/summernote-master/dist/summernote.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <body>

         <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>

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
                        <span class="label label-primary"><?php if(isset($SETDATES)) { echo "Results for $SETDATES"; } else { echo date("d-m-y"); } ?> Upsell Trackers</span>
                        <br><br>
                        <form action="Upsells.php?EXECUTE=DEFAULT" method="POST">

                            <div class="col-md-12">
                                <div class="col-md-4">
                                  
                                </div>

                                <div class="col-md-12"></div>
                                <div class="col-md-2"><input type="dob" name="SETDATES" value="<?php if(isset($SETDATES)) { echo "$SETDATES"; } ?>" id="SETDATES"></div>

                                <div class="col-md-2"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-calendar-check-o"></i> Search</button></div>

                            </div>

                        </form>


        <?php
        
        if(isset($SETDATES)) { 
                   $TRACKER_EDIT = $pdo->prepare("SELECT DATE(date_updated) AS updated_date, upsell_notes, upsell_status, upsell_agent, lead_up, mtg, closer, tracker_id, agent, client, phone, current_premium, our_premium, comments, sale FROM closer_trackers WHERE mtg='Yes' AND DATE(date_added) =:DATES OR lead_up='Yes' AND DATE(date_added)=:DATES2");
                   $TRACKER_EDIT->bindParam(':DATES', $SETDATES, PDO::PARAM_STR); 
                   $TRACKER_EDIT->bindParam(':DATES2', $SETDATES, PDO::PARAM_STR); 
                   $TRACKER_EDIT->execute();
        }
        
        else {
        $TRACKER_EDIT = $pdo->prepare("SELECT DATE(date_updated) AS updated_date, upsell_notes, upsell_status, upsell_agent, lead_up, mtg, closer, tracker_id, agent, client, phone, current_premium, our_premium, comments, sale FROM closer_trackers WHERE mtg='Yes' AND DATE(date_added) >=CURDATE() OR lead_up='Yes' AND DATE(date_added) >=CURDATE()");
        $TRACKER_EDIT->execute();
        }
        
        
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
    <div class="modal-content">
      <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php if(isset($TRK_EDIT_UPSELLS_AGENT)) { echo "Updated by $TRK_EDIT_UPSELLS_AGENT on $TRK_EDIT_DATE"; } ?> </h4>
      </div>
      <div class="modal-body">
          <div class="container">
              <form method="POST" action="php/Trackers.php?TID=<?php echo $TRK_EDIT_tracker_id; ?>&EXECUTE=3">
             
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
}
?>

    </div>

    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
    <script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
    <script type="text/javascript" src="/resources/lib/summernote-master/dist/summernote.js"></script>

  <script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200
      });


    });
  </script>
    <script>
        $(function () {
            $("#SETDATES").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
    </script>
</body>
</html>

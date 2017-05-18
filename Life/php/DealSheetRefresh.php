<?php

include ($_SERVER['DOCUMENT_ROOT']."/includes/ADL_PDO_CON.php");

$query= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($query)) {
    $real_name= filter_input(INPUT_GET, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $Today_DATE = date("d-M-Y");
    $Today_DATES = date("l jS \of F Y");
    $Today_TIME =date("h:i:s");
    
    if($query=='AllCloserDealSheets') {

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
                        <span class="label label-primary">All Closer Dealsheets</span>
                        
                        <?php
                        
                $CLOSERDEALS = $pdo->prepare("SELECT date_updated, deal_id, agent, closer, CONCAT(title, ' ', forename, ' ', surname) AS NAME, CONCAT(title2, ' ', forename2, ' ', surname2) AS NAME2 FROM dealsheet_prt1 WHERE status='CLOSER' ORDER BY date_updated DESC");
                $CLOSERDEALS->execute();
                            if ($CLOSERDEALS->rowCount()>0) {
                                while ($CLOSERDEALSresult=$CLOSERDEALS->fetch(PDO::FETCH_ASSOC)){    
                                    
                                    $CLO_NAME=$CLOSERDEALSresult['NAME'];
                                    $CLO_NAME2=$CLOSERDEALSresult['NAME2'];
                                    $CLO_ID=$CLOSERDEALSresult['deal_id'];
                                    $CLO_AGENT=$CLOSERDEALSresult['agent'];
                                    $CLO_DATE=$CLOSERDEALSresult['date_updated'];
                                    
                                    ?>
                        
                            <a class="list-group-item" href="LifeDealSheet.php?query=ViewCloserDealSheet&REF=<?php echo $CLO_ID; ?>"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "Date: $CLO_DATE | Lead Gen: $CLO_AGENT | $CLO_NAME - $CLO_NAME2"; ?></a>

                        
                        <?php
                                    
                                }               
                     
                            }                        
                        
                        ?>
                        
                        </div>
  </div>

<?php }    
    
    if($query=='CloserDealSheets') {

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
                        <span class="label label-primary">Dealsheets for <?php echo $real_name; ?></span>
                        
                        <?php
                        
                $CLOSERDEALS = $pdo->prepare("SELECT date_updated, deal_id, agent, closer, CONCAT(title, ' ', forename, ' ', surname) AS NAME, CONCAT(title2, ' ', forename2, ' ', surname2) AS NAME2 FROM dealsheet_prt1 WHERE status='CLOSER' AND closer=:closer ORDER BY date_added DESC");
                $CLOSERDEALS->bindParam(':closer',$real_name, PDO::PARAM_STR);
                $CLOSERDEALS->execute();
                            if ($CLOSERDEALS->rowCount()>0) {
                                while ($CLOSERDEALSresult=$CLOSERDEALS->fetch(PDO::FETCH_ASSOC)){    
                                    
                                    $CLO_NAME=$CLOSERDEALSresult['NAME'];
                                    $CLO_NAME2=$CLOSERDEALSresult['NAME2'];
                                    $CLO_ID=$CLOSERDEALSresult['deal_id'];
                                    $CLO_AGENT=$CLOSERDEALSresult['agent'];
                                    $CLO_DATE=$CLOSERDEALSresult['date_updated'];
                                    
                                    ?>
                        
                            <a class="list-group-item" href="LifeDealSheet.php?query=ViewCloserDealSheet&REF=<?php echo $CLO_ID; ?>"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "Date: $CLO_DATE | Lead Gen: $CLO_AGENT | $CLO_NAME - $CLO_NAME2"; ?></a>

                        
                        <?php
                                    
                                }               
                     
                            }                        
                        
                        ?>
                        
                        </div>
  </div>

<?php }
if($query=='QADealSheets') { ?>

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
                        <span class="label label-primary">Dealsheets Awaiting QA</span>
                        
                        
                                                <?php
                        
                $CLOSERDEALS = $pdo->prepare("SELECT date_added, deal_id, agent, closer, CONCAT(title, ' ', forename, ' ', surname) AS NAME, CONCAT(title2, ' ', forename2, ' ', surname2) AS NAME2 FROM dealsheet_prt1 WHERE status='QA' ORDER BY date_updated DESC");
                             $CLOSERDEALS->execute();
                            if ($CLOSERDEALS->rowCount()>0) {
                                while ($CLOSERDEALSresult=$CLOSERDEALS->fetch(PDO::FETCH_ASSOC)){    
                                    
                                    $CLO_NAME=$CLOSERDEALSresult['NAME'];
                                    $CLO_NAME2=$CLOSERDEALSresult['NAME2'];
                                    $CLO_ID=$CLOSERDEALSresult['deal_id'];
                                    $CLO_AGENT=$CLOSERDEALSresult['agent'];
                                    $CLO_CLO=$CLOSERDEALSresult['closer'];
                                    $DL_DATE=$CLOSERDEALSresult['date_added'];
                                    
                                    ?>
                        
                            <a class="list-group-item" href="LifeDealSheet.php?query=ViewQADealSheet&REF=<?php echo $CLO_ID; ?>"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "Date: $DL_DATE | Closer: $CLO_CLO | Lead Gen: $CLO_AGENT <br><i class='fa fa-user fa-fw' aria-hidden='true'></i> $CLO_NAME - $CLO_NAME2"; ?></a>

                        
                        <?php
                                    
                                }               
                     
                            }                        
                        
                        ?>
                        
                    </div>
  </div>     
    
<?php }



                                } ?>
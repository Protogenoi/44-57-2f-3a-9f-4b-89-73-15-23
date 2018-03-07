<?php foreach ($LAST_SALEList as $LAST_SALEList_RESULTS): ?>

        <?php
                $LAST_SALE_TOTAL = $LAST_SALEList_RESULTS['LAST_SALE_TIME'];
                
                $MINUS_TIME = date('h:i:s');
                
                $SHOW_TMIE=$LAST_SALE_TOTAL-$MINUS_TIME;

                
  ?>

                <div class="col-sm-12">
                    <center><h2 style="color:white;"><i class="fa fa-exclamation"></i> Last sale was at <?php echo $LAST_SALE_TOTAL; ?> <i class="fa fa-exclamation"></i></h2></center>
                </div>

    <?php endforeach ?>

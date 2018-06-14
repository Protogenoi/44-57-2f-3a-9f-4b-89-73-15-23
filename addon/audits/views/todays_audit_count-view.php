<table id="AUDITS_COMPLETED" class="table table-condensed">
            <thead>
                <tr class="info">
                    <th colspan="5">Todays submitted audits</th>
                </tr>
            <tr>
                
                

<?php foreach ($AUDIT_COUNT_VARS_LIST as $AUDIT_COUNT_VARS): ?>
                
                <th><?php echo $AUDIT_COUNT_VARS['adl_audits_auditor']; ?></th>

<?php endforeach ?>
                
    
            </tr>
            </thead>
            <tbody>
            <tr>            
                
                
<?php foreach ($AUDIT_COUNT_VARS_LIST as $AUDIT_COUNT_VARS): ?>
                
                <?php 
                
                if($AUDIT_COUNT_VARS['adl_audits_count'] >= 8 ) {
                    $FONT_AWESOME_AUDIT_ICON = "fa fa-crown";
                } 
                
                elseif($AUDIT_COUNT_VARS['adl_audits_count'] >= 6 ) {
                    $FONT_AWESOME_AUDIT_ICON = "far fa-star";
                }
                
                elseif($AUDIT_COUNT_VARS['adl_audits_count'] >= 5 ) {
                    $FONT_AWESOME_AUDIT_ICON = "far fa-star-half";
                }
                
                else {
                    
                    $FONT_AWESOME_AUDIT_ICON = "fa fa-poo";

                }
                
                ?>                
                
                <th><i class="<?php echo $FONT_AWESOME_AUDIT_ICON; ?> fa-4x"></i> <?php echo $AUDIT_COUNT_VARS['adl_audits_count']; ?></th>

<?php endforeach ?>                

            </tr>
            </tbody>
        </table>
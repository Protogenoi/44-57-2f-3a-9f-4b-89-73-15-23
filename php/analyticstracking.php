<?php
include ($_SERVER['DOCUMENT_ROOT']."/includes/ADL_PDO_CON.php");


$query = $pdo->prepare("SELECT tracking_id FROM google_dev LIMIT 1");
$query->execute()or die(print_r($query->errorInfo(), true));
$devtracking=$query->fetch(PDO::FETCH_ASSOC);
            
            $devtrackingid=$devtracking['tracking_id'];


?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $devtrackingid?>', 'auto');
  ga('send', 'pageview');

</script>

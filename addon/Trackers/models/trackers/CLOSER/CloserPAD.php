<?php

    class CLOSERPadModal {

        protected $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function getCLOSERPad($datefrom, $CLOSER) {

            $stmt = $this->pdo->prepare("SELECT 
    date_updated AS updated_date,
    lead_up,
    mtg,
    closer,
    tracker_id,
    agent,
    client,
    phone,
    current_premium,
    our_premium,
    comments,
    insurer,
    sale
FROM
    closer_trackers
WHERE
    DATE(date_added) = :datefrom
        AND closer =:closer
ORDER BY date_added DESC");
            $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
            $stmt->bindParam(':closer', $CLOSER, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


}
?>
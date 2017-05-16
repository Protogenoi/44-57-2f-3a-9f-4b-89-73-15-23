<?php

    class AllCLOSERPadModal {

        protected $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function AllgetCLOSERPad($datefrom) {
if (isset($datefrom)) {
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
    sale
FROM
    closer_trackers
WHERE
    DATE(date_added) = :datefrom
ORDER BY date_added DESC");
            $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


}
    }

?>
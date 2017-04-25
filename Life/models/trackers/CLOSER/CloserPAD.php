<?php

    class CLOSERPadModal {

        protected $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function getCLOSERPad($datefrom, $CLOSER) {
if (isset($datefrom)) {
            $stmt = $this->pdo->prepare("SELECT 
    DATE(date_updated) AS updated_date,
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
    DATE(date_updated) >= :datefrom
        AND closer =:closer
ORDER BY date_added");
            $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
            $stmt->bindParam(':closer', $CLOSER, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
if (!isset($datefrom)) {

        $stmt = $this->pdo->prepare("SELECT 
    DATE(date_updated) AS updated_date,
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
    date_updated >= CURDATE()
ORDER BY date_added");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
    }

?>
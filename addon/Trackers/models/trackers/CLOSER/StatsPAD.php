<?php

    class STATSPadModal {

        protected $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function getSTATSPad($datefrom, $CLOSER) {
            $stmt = $this->pdo->prepare("SELECT 
    count(mtg) AS mtg
FROM
    closer_trackers
WHERE
    DATE(date_added) = :datefrom
        AND closer =:closer
        AND mtg='Yes'");
            $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
            $stmt->bindParam(':closer', $CLOSER, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

}

?>
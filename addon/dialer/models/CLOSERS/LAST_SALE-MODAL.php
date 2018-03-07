<?php

class LAST_SALEModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getLAST_SALE() {

        $stmt = $this->pdo->prepare("SELECT 
    TIME(date_updated) AS LAST_SALE_TIME
FROM
    closer_trackers
WHERE
    date_updated >= CURDATE()
        AND sale = 'SALE'
ORDER BY date_added DESC
LIMIT 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
<?php

class MissingKFEmailModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getMissingKFEmail($hello_name) {

        $stmt = $this->pdo->prepare("SELECT 
    client_details.email,
    client_details.submitted_date,
    client_policy.closer,
    CONCAT(title, ' ', first_name, ' ', last_name) AS NAME
FROM
    client_details
    LEFT JOIN client_policy ON client_details.client_id=client_policy.client_id
WHERE
    DATE(client_details.submitted_date) >= '2017-08-31'
        AND client_details.email NOT IN (SELECT 
            keyfactsemail_email
        FROM
            keyfactsemail)
            AND client_policy.closer=:CLOSER
    GROUP BY client_details.email ORDER BY client_details.submitted_date DESC");
        $stmt->bindParam(':CLOSER', $hello_name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
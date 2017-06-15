<?php

class ClientModel {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getSingleClient($search,$COMPANY_ENTITY) {

        $stmt = $this->pdo->prepare("SELECT dealsheet_id, company, leadauditid, leadauditid2, client_id, title, first_name, last_name, dob, email, phone_number, alt_number, title2, first_name2, last_name2, dob2, email2, address1, address2, address3, town, post_code, date_added, submitted_by, leadid1, leadid2, leadid3,  leadid12, leadid22, leadid32, callauditid, callauditid2 FROM client_details WHERE client_id=:CID AND owner=:OWNER");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->bindParam(':OWNER', $COMPANY_ENTITY, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
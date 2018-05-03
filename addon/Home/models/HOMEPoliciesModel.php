<?php

class HOMEPoliciesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getHOMEPolicies($search) {

        $stmt = $this->pdo->prepare("SELECT 
    ageas_home_insurance.ageas_home_insurance_id,
    adl_policy.adl_policy_client_id_fk,
    ageas_home_insurance.ageas_home_insurance_type,
    ageas_home_insurance.ageas_home_insurance_commission,
    ageas_home_insurance.ageas_home_insurance_cover,
    ageas_home_insurance.ageas_home_insurance_premium,
    adl_policy.adl_policy_policy_holder,
    adl_policy.adl_policy_status,
    adl_policy.adl_policy_ref,
    adl_policy.adl_policy_id
FROM
    adl_policy
		JOIN
    ageas_home_insurance ON adl_policy.adl_policy_id = ageas_home_insurance.ageas_home_insurance_id_fk
WHERE
    adl_policy_client_id_fk = :CID");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
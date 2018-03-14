<?php

class LifeWorkflowsModel {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getLifeWorkflows($search) {

        $stmt = $this->pdo->prepare("SELECT 
    adl_workflows_name, adl_tasks_title, adl_tasks_outcome
FROM
    adl_workflows
        JOIN
    adl_tasks ON adl_workflows.adl_workflows_id = adl_tasks.adl_tasks_id_fk
WHERE
    adl_workflows_client_id_fk = :CID
        AND adl_workflows_name = '7 day'
ORDER BY adl_workflows_updated_date DESC");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
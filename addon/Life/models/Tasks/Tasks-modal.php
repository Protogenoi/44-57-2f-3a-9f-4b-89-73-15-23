<?php

class LifeTasksModel {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getLifeTasks($search) {

        $stmt = $this->pdo->prepare("SELECT 
    life_tasks_happy,
    life_tasks_email,
    life_tasks_dd,
    life_tasks_first_dd,
    life_tasks_trust,
    life_tasks_tps
FROM
    life_tasks
WHERE
    life_tasks_client_id = :CID");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
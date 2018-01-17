<?php

class LV_KFModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getLV_KF($likesearch) {

        $stmt = $this->pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :CID and uploadtype ='LVkeyfacts'");
        $stmt->bindParam(':CID', $likesearch, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
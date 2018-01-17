<?php

class LVT_POL_Modal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getLVT_POL($likesearch) {

        $stmt = $this->pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :CID and uploadtype ='LVpolicy'");
        $stmt->bindParam(':CID', $likesearch, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
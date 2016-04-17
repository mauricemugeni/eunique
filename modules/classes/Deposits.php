<?php
require_once WPATH . "modules/classes/Settings.php";

class Deposits extends Database {

    public function execute() {
        if ($_POST['action'] == "add_deposit") {
            return $this->addDeposit();
        } 
    }
    
    private function getNextTransactionId() {
        $transaction_id = $this->executeQuery("SELECT max(id) as transaction_id_max FROM deposits");
        $transaction_id = $transaction_id[0]['transaction_id_max'] + 1;
        return $transaction_id;
    }
    
    public function getTransactionRefTypeId ($transaction_type){
        $settings = new Settings();
        return $settings ->getTransactionRefTypeId($transaction_type);
    }
    
    private function addDeposit() {
        $transaction_id = $this->getNextTransactionId();
        $account_number = $_POST['account_number'];
        $amount = $_POST['amount'];
        $depositedby = $_POST['depositedby'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];
        
        $transaction_type = $_POST['transaction_type'];
        $ref_type = $this->getTransactionRefTypeId($transaction_type);
        $ref_id = $transaction_id;

        $sql = "INSERT INTO deposits (id, account_number, amount, depositedby, createdat, createdby)"
                . " VALUES (:id, :account_number, :amount, :depositedby, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("id", $transaction_id);
        $stmt->bindValue("account_number", $account_number);
        $stmt->bindValue("amount", $amount);
        $stmt->bindValue("depositedby", $depositedby);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }


}

<?php
require_once WPATH . "modules/classes/Settings.php";

class Withdrawals extends Database {
    
    public function execute() {
        if ($_POST['action'] == "add_withdrawal") {
            return $this->addWithdrawal();
        } 
    }
    
    private function getNextTransactionId() {
        $transaction_id = $this->executeQuery("SELECT max(id) as transaction_id_max FROM withdrawals");
        $transaction_id = $transaction_id[0]['transaction_id_max'] + 1;
        return $transaction_id;
    }
    
    public function getTransactionRefTypeId ($transaction_type){
        $settings = new Settings();
        return $settings ->getTransactionRefTypeId($transaction_type);
    }
    
    private function addWithdrawal() {
        $transaction_type = $_POST['transaction_type'];
        $transaction_id = $this->getNextTransactionId();
        $account_number = $_POST['account_number'];
        $amount = $_POST['amount'];
        $withdrawnby = $_POST['withdrawnby'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];
        
        $transaction_type = $_POST['transaction_type'];
        $ref_type = $this->getTransactionRefTypeId($transaction_type);
        $ref_id = $transaction_id;

        $sql = "INSERT INTO withdrawals (id, account_number, amount, withdrawnby, createdat, createdby)"
                . " VALUES (:id, :account_number, :amount, :withdrawnby, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("id", $transaction_id);
        $stmt->bindValue("account_number", $account_number);
        $stmt->bindValue("amount", $amount);
        $stmt->bindValue("withdrawnby", $withdrawnby);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }
}

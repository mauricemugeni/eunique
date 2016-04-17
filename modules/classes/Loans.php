<?php

require_once WPATH . "modules/classes/Settings.php";

class Loans extends Database {

    public function execute() {
        if ($_POST['action'] == "add_instalment_frequency") {
            return $this->addInstalmentFrequency();
        } else if ($_POST['action'] == "add_loan_type") {
            return $this->addLoanType();
        } else if ($_POST['action'] == "add_loan") {
            return $this->addLoan();
        }
    }
    
    private function getNextTransactionId() {
        $transaction_id = $this->executeQuery("SELECT max(id) as transaction_id_max FROM loans");
        $transaction_id = $transaction_id[0]['transaction_id_max'] + 1;
        return $transaction_id;
    }

    public function getLoanTypes() {
        $stmt = $this->prepareQuery("SELECT * FROM loan_types WHERE status=1 ORDER BY name ASC");
        $stmt->execute();
        $currentGroup = null;
        $html = "";
        while ($row = $stmt->fetch()) {
            if (is_null($currentGroup)) {
                $currentGroup = $row['name'];
                $html .= "<option value=\"{$row['id']}\" selected>{$row['name']}</option>";
            } else {
                $html .= "<option value=\"{$row['id']}\">{$row['name']}</option>";
            }
        }
        if ($html == "")
            $html = "<option value=\"\">No loan type entered into the database!</option>";
        echo $html;
        return $currentGroup;
    }

    public function getTransactionRefTypeId($transaction_type) {
        $settings = new Settings();
        return $settings->getTransactionRefTypeId($transaction_type);
    }

    private function addLoan() {
        $loan_type = $_POST['loan_type'];
        $transaction_id = $this->getNextTransactionId();
        $account_number = $_POST['account_number'];
        $principal_amount = $_POST['principal_amount'];
        $duration = $_POST['duration'];
        $instalment_amount = 100; //To be calculated depending on loan type, amount and duration
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];
        
        // Loanee Contacts
        $phone_number1 = $_POST['phone_number1'];
        $email = $_POST['email'];
        $phone_number2 = $_POST['phone_number2'];
        $postal_number = $_POST['postal_number'];
        $postal_code = $_POST['postal_code'];
        $town = $_POST['town'];
        $residential_area = $_POST['residential_area'];
        $estate = $_POST['estate'];
        $street = $_POST['street'];
        $division = $_POST['division'];
        $location = $_POST['location'];
        $sub_location = $_POST['sub_location'];

        $transaction_type = $_POST['transaction_type'];
        $ref_type = $this->getTransactionRefTypeId($transaction_type);
        $ref_id = $transaction_id;

        $sql = "INSERT INTO loans (id, loan_type, account_number, principal_amount, duration, instalment_amount, createdat, createdby)"
                . " VALUES (:id, :loan_type, :account_number, :principal_amount, :duration, :instalment_amount, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("id", $transaction_id);
        $stmt->bindValue("loan_type", $loan_type);
        $stmt->bindValue("account_number", $account_number);
        $stmt->bindValue("principal_amount", $principal_amount);
        $stmt->bindValue("duration", $duration);
        $stmt->bindValue("instalment_amount", $instalment_amount);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();

        $sql_contacts = "INSERT INTO contacts (id, ref_type, ref_id, phone_number1, phone_number2, email, postal_number, postal_code, town, residential_area, estate, street, division, location, sub_location)"
                . " VALUES ('', '{$ref_type}', '{$ref_id}', '{$phone_number1}', '{$phone_number2}', '{$email}', '{$postal_number}', '{$postal_code}', '{$town}', '{$residential_area}', '{$estate}', '{$street}', '{$division}', '{$location}', '{$sub_location}')";
        $this->executeQuery($sql_contacts);

        return true;
    }

    private function addInstalmentFrequency() {
        $name = $_POST['name'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO instalment_frequencies (name, createdat, createdby)"
                . " VALUES (:name, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    public function getInstalmentFrequencies() {
        $stmt = $this->prepareQuery("SELECT id, name, status FROM instalment_frequencies WHERE status=1 ORDER BY id ASC");
        $stmt->execute();
        $currentGroup = null;
        $html = "";
        while ($row = $stmt->fetch()) {
            if (is_null($currentGroup)) {
                $currentGroup = $row['name'];
                $html .= "<option value=\"{$row['id']}\" selected>{$row['name']}</option>";
            } else {
                $html .= "<option value=\"{$row['id']}\">{$row['name']}</option>";
            }
        }
        if ($html == "")
            $html = "<option value=\"\">No instalment frequency entered into the database!</option>";
        echo $html;
        return $currentGroup;
    }

    private function addLoanType() {
        $name = $_POST['name'];
        $qualification_time = $_POST['qualification_time'];
        $qualification_amount = $_POST['qualification_amount'];
        $interest_rate = $_POST['interest_rate'];
        $maximum_duration = $_POST['maximum_duration'];
        $instalment_frequency = $_POST['instalment_frequency'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO loan_types (name, qualification_time, qualification_amount, interest_rate, maximum_duration, instalment_frequency, createdat, createdby)"
                . " VALUES (:name, :qualification_time, :qualification_amount, :interest_rate, :maximum_duration, :instalment_frequency, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("qualification_time", $qualification_time);
        $stmt->bindValue("qualification_amount", $qualification_amount);
        $stmt->bindValue("interest_rate", $interest_rate);
        $stmt->bindValue("maximum_duration", $maximum_duration);
        $stmt->bindValue("instalment_frequency", $instalment_frequency);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

}

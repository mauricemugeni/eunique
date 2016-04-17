<?php

class Settings extends Database {

    public function execute() {
        if ($_POST['action'] == "add_account_category") {
            return $this->addAccountCategory();
        } else if ($_POST['action'] == "add_account_type") {
            return $this->addAccountType();
        } else if ($_POST['action'] == "add_branch") {
            return $this->addBranch();
        } else if ($_POST['action'] == "add_business_type") {
            return $this->addBusinessType();
        } else if ($_POST['action'] == "add_business_form") {
            return $this->addBusinessForm();
        } else if ($_POST['action'] == "add_default_charge_rate") {
            return $this->addDefaultChargeRate();
        } else if ($_POST['action'] == "add_status_element") {
            return $this->addStatusElement();
        } else if ($_POST['action'] == "add_status") {
            return $this->addStatus();
        } else if ($_POST['action'] == "add_marital_status") {
            return $this->addMaritalStatus();
        } else if ($_POST['action'] == "add_nationality") {
            return $this->addNationality();
        } else if ($_POST['action'] == "add_response") {
            return $this->addResponse();
        } else if ($_POST['action'] == "add_transaction_type") {
            return $this->addTransactionType();
        }
    }
    
    public function getMaritalStatuses() {
        $stmt = $this->prepareQuery("SELECT * FROM marital_status WHERE status=1 ORDER BY name ASC");
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
            $html = "<option value=\"\">No marital status entered into the database!</option>";
        echo $html;
        return $currentGroup;
    }
    
        public function getBusinessForms() {
        $stmt = $this->prepareQuery("SELECT * FROM business_forms WHERE status=1 ORDER BY name ASC");
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
            $html = "<option value=\"\">No business form entered into the database!</option>";
        echo $html;
        return $currentGroup;
    }
    
        public function getBusinessTypes() {
        $stmt = $this->prepareQuery("SELECT * FROM business_types WHERE status=1 ORDER BY name ASC");
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
            $html = "<option value=\"\">No business type entered into the database!</option>";
        echo $html;
        return $currentGroup;
    }

    public function getNationalities() {
        $stmt = $this->prepareQuery("SELECT * FROM nationalities WHERE status=1 ORDER BY name ASC");
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
            $html = "<option value=\"\">No nationality entered into the database!</option>";
        echo $html;
        return $currentGroup;
    }

    public function getAccountCategories() {
        $stmt = $this->prepareQuery("SELECT * FROM account_categories WHERE status=1 ORDER BY name ASC");
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
            $html = "<option value=\"\">No account category entered into the database!</option>";
        echo $html;
        return $currentGroup;
    }

    public function getAccountTypes() {
        $stmt = $this->prepareQuery("SELECT * FROM account_types WHERE status=1 ORDER BY name ASC");
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
            $html = "<option value=\"\">No account type entered into the database!</option>";
        echo $html;
        return $currentGroup;
    }

    public function getBranches() {
        $stmt = $this->prepareQuery("SELECT id, name, email, phone_number, location, status FROM branches WHERE status=1 ORDER BY name ASC");
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
            $html = "<option value=\"\">No branch entered into the database!</option>";
        echo $html;
        return $currentGroup;
    }

    public function getTransactionRefTypeId($transaction_type) {
        $sql = "SELECT id, name, status, charge FROM transaction_types WHERE name=:transaction_type";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("transaction_type", $transaction_type);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data = $data[0];
        return $data['id'];
    }

    private function addTransactionType() {
        $name = $_POST['name'];
        $charge = $_POST['charge'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO transaction_types (name, charge, createdat, createdby)"
                . " VALUES (:name, :charge, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("charge", $charge);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    private function addResponse() {
        $message = $_POST['message'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO responses (message, createdat, createdby)"
                . " VALUES (:message, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("message", $message);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    private function addNationality() {
        $name = $_POST['name'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO nationalities (name, createdat, createdby)"
                . " VALUES (:name, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    private function addMaritalStatus() {
        $name = $_POST['name'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO marital_status (name, createdat, createdby)"
                . " VALUES (:name, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    private function addStatus() {
        $status_code = $_POST['status_code'];
        $status_element = $_POST['status_element'];
        $description = $_POST['description'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO status (id, ref_type, description, createdat, createdby)"
                . " VALUES (:id, :ref_type, :description, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("id", $status_code);
        $stmt->bindValue("ref_type", $status_element);
        $stmt->bindValue("description", $description);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    public function getStatusElements() {
        $stmt = $this->prepareQuery("SELECT id, name, status FROM status_elements WHERE status=1 ORDER BY name ASC");
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
            $html = "<option value=\"\">No status element entered into the database!</option>";
        echo $html;
        return $currentGroup;
    }

    private function addStatusElement() {
        $name = $_POST['name'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO status_elements (name, createdat, createdby)"
                . " VALUES (:name, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    private function addDefaultChargeRate() {
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO default_charge_rates (description, amount, createdat, createdby)"
                . " VALUES (:description, :amount, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("description", $description);
        $stmt->bindValue("amount", $amount);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    private function addBusinessType() {
        $name = $_POST['name'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO business_types (name, createdat, createdby)"
                . " VALUES (:name, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    private function addBusinessForm() {
        $name = $_POST['name'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO business_forms (name, createdat, createdby)"
                . " VALUES (:name, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    private function addBranch() {
        $branch_code = $_POST['branch_code'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $location = $_POST['location'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO branches (id, name, email, phone_number, location, createdat, createdby)"
                . " VALUES (:id, :name, :email, :phone_number, :location, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("id", $branch_code);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("email", $email);
        $stmt->bindValue("phone_number", $phone_number);
        $stmt->bindValue("location", $location);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    private function addAccountCategory() {
        $name = $_POST['name'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO account_categories (name, createdat, createdby)"
                . " VALUES (:name, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    private function addAccountType() {
        $name = $_POST['name'];
        $opening_balance = $_POST['opening_balance'];
        $minimum_balance = $_POST['minimum_balance'];
        $minimum_deposit = $_POST['minimum_deposit'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO account_types (name, opening_balance, minimum_balance, minimum_deposit, createdat, createdby)"
                . " VALUES (:name, :opening_balance, :minimum_balance, :minimum_deposit, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("opening_balance", $opening_balance);
        $stmt->bindValue("minimum_balance", $minimum_balance);
        $stmt->bindValue("minimum_deposit", $minimum_deposit);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

}

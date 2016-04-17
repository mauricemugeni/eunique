<?php

class Users extends Database {

    public function execute() {
        if ($_POST['action'] == "add_role") {
            return $this->addRole();
        } else if ($_POST['action'] == "add_user_type") {
            return $this->addUserType();
        } else if ($_POST['action'] == "add_position") {
            return $this->addPosition();
        } else if ($_POST['action'] == "add_staff") {
            return $this->addStaff();
        } else if ($_POST['action'] == "add_customer") {
            return $this->addCustomer();
        } else if ($_POST['action'] == "add_next_of_kin") {
            return $this->addNextOfKin();
        } else if ($_POST['action'] == "add_customer") {
            return $this->addCustomerJoint();
        }
    }

    private function getNextCustomerJointId() {
        $id = $this->executeQuery("SELECT max(id) as id_max FROM joint_accounts");
        $id = $id[0]['id_max'] + 1;
        return $id;
    }

    private function addCustomerJoint() {
        $account_number = $_POST['account_number'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $idnumber = $_POST['idnumber'];
        $birthdate = $_POST['birthdate'];
        $nationality = $_POST['nationality'];
        $profpicture = $_SESSION['profpicture'];
        $signature = $_SESSION['signature'];
        $signatory = $_SESSION['signatory'];
        $user_type = $_POST['user_type'];
        $ref_type = $this->getUserRefTypeId($user_type);
        $_SESSION['ref_type'] = $ref_type;
        $ref_id = $this->getNextCustomerJointId();
        $_SESSION['ref_id'] = $ref_id;

        // Contacts
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

        $sql = "INSERT INTO joint_accounts (account_number, firstname, middlename, lastname, gender, idnumber, birthdate, nationality, profpicture, signature, signatory)"
                . " VALUES (:account_number, :firstname, :middlename, :lastname, :gender, :idnumber, :birthdate, :nationality, :profpicture, :signature, :signatory)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("account_number", $account_number);
        $stmt->bindValue("firstname", $firstname);
        $stmt->bindValue("middlename", $middlename);
        $stmt->bindValue("lastname", $lastname);
        $stmt->bindValue("gender", $gender);
        $stmt->bindValue("idnumber", $idnumber);
        $stmt->bindValue("birthdate", $birthdate);
        $stmt->bindValue("nationality", $nationality);
        $stmt->bindValue("profpicture", $profpicture);
        $stmt->bindValue("signature", $signature);
        $stmt->bindValue("signatory", $signatory);
        $stmt->execute();

        $sql_contacts = "INSERT INTO contacts (id, ref_type, ref_id, phone_number1, phone_number2, email, postal_number, postal_code, town, residential_area, estate, street, division, location, sub_location)"
                . " VALUES ('', '{$ref_type}', '{$ref_id}', '{$phone_number1}', '{$phone_number2}', '{$email}', '{$postal_number}', '{$postal_code}', '{$town}', '{$residential_area}', '{$estate}', '{$street}', '{$division}', '{$location}', '{$sub_location}')";
        $this->executeQuery($sql_contacts);

        return true;
    }

    private function addNextOfKin() {
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $relationship = $_POST['relationship'];
        $ref_type = $_POST['ref_type'];
        $ref_id = $_POST['ref_id'];

        // Contacts
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

        $sql = "INSERT INTO next_of_kins (ref_type, ref_id, firstname, middlename, lastname, relationship)"
                . " VALUES (:ref_type, :ref_id, :firstname, :middlename, :lastname, :relationship)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("ref_type", $ref_type);
        $stmt->bindValue("ref_id", $ref_id);
        $stmt->bindValue("firstname", $firstname);
        $stmt->bindValue("middlename", $middlename);
        $stmt->bindValue("lastname", $lastname);
        $stmt->bindValue("relationship", $relationship);
        $stmt->execute();

        $sql_contacts = "INSERT INTO contacts (id, ref_type, ref_id, phone_number1, phone_number2, email, postal_number, postal_code, town, residential_area, estate, street, division, location, sub_location)"
                . " VALUES ('', '{$ref_type}', '{$ref_id}', '{$phone_number1}', '{$phone_number2}', '{$email}', '{$postal_number}', '{$postal_code}', '{$town}', '{$residential_area}', '{$estate}', '{$street}', '{$division}', '{$location}', '{$sub_location}')";
        $this->executeQuery($sql_contacts);

        return true;
    }

    private function getNextAccountNumber() {
        $account_number = $this->executeQuery("SELECT max(account_number) as account_number_max FROM customers");
        $account_number = $account_number[0]['account_number_max'] + 1;
        return $account_number;
    }

    private function getNextTransactionId() {
        $transaction_id = $this->executeQuery("SELECT max(id) as transaction_id_max FROM customers");
        $transaction_id = $transaction_id[0]['transaction_id_max'] + 1;
        return $transaction_id;
    }

    private function addCustomer() {
        $transaction_id = $this->getNextTransactionId();
        $account_number = $this->getNextAccountNumber();
        $account_name = $_POST['account_name'];
        $account_type = $_POST['account_type'];
        $account_category = $_POST['account_category'];
        $_SESSION['account_category'] = $account_category;
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $idnumber = $_POST['idnumber'];
        $birthdate = $_POST['birthdate'];
        $branch = $_POST['branch'];
        $nationality = $_POST['nationality'];
        $profpicture = $_SESSION['profpicture'];
        $signature = $_SESSION['signature'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];
        $user_type = $_POST['user_type'];
        $ref_type = $this->getUserRefTypeId($user_type);
        $_SESSION['ref_type'] = $ref_type;
        $ref_id = $account_number;
        $_SESSION['account_number'] = $ref_id;

        $transaction_type = $_POST['transaction_type'];
        $ref_type = $settings->getTransactionRefTypeId($transaction_type);
        $ref_id = $transaction_id;

        // Contacts
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

        $sql = "INSERT INTO customers (id, account_number, account_name, account_type, account_category, firstname, middlename, lastname, gender, idnumber, birthdate, branch, nationality, profpicture, signature, createdat, createdby)"
                . " VALUES (:id, :account_number, :account_name, :account_type, :account_category, :firstname, :middlename, :lastname, :gender, :idnumber, :birthdate, :branch, :nationality, :profpicture, :signature, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("id", $transaction_id);
        $stmt->bindValue("account_number", $account_number);
        $stmt->bindValue("account_name", $account_name);
        $stmt->bindValue("account_type", $account_type);
        $stmt->bindValue("account_category", $account_category);
        $stmt->bindValue("firstname", $firstname);
        $stmt->bindValue("middlename", $middlename);
        $stmt->bindValue("lastname", $lastname);
        $stmt->bindValue("gender", $gender);
        $stmt->bindValue("idnumber", $idnumber);
        $stmt->bindValue("birthdate", $birthdate);
        $stmt->bindValue("branch", $branch);
        $stmt->bindValue("nationality", $nationality);
        $stmt->bindValue("profpicture", $profpicture);
        $stmt->bindValue("signature", $signature);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();

        $sql_contacts = "INSERT INTO contacts (id, ref_type, ref_id, phone_number1, phone_number2, email, postal_number, postal_code, town, residential_area, estate, street, division, location, sub_location)"
                . " VALUES ('', '{$ref_type}', '{$ref_id}', '{$phone_number1}', '{$phone_number2}', '{$email}', '{$postal_number}', '{$postal_code}', '{$town}', '{$residential_area}', '{$estate}', '{$street}', '{$division}', '{$location}', '{$sub_location}')";
        $this->executeQuery($sql_contacts);

        return true;
    }

    private function getNextStaffId() {
        $staff_id = $this->executeQuery("SELECT max(id) as staff_id_max FROM staff");
        $staff_id = $staff_id[0]['staff_id_max'] + 1;
        return $staff_id;
    }

    private function addStaff() {
        $staff_id = $this->getNextStaffId();
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $idnumber = $_POST['idnumber'];
        $branch = $_POST['branch'];
        $position = $_POST['position'];
        $profpicture = $_SESSION['filename'];
        $roles = $_POST['roles'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];
        $user_type = $_POST['user_type'];
        $ref_type = $this->getUserRefTypeId($user_type);
        $ref_id = $staff_id;

        // Contacts
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

        $sql = "INSERT INTO staff (id, firstname, middlename, lastname, gender, idnumber, branch, profpicture, position, roles, createdat, createdby)"
                . " VALUES (:id, :firstname, :middlename, :lastname, :gender, :idnumber, :branch, :profpicture, :position, :roles, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("id", $staff_id);
        $stmt->bindValue("firstname", $firstname);
        $stmt->bindValue("middlename", $middlename);
        $stmt->bindValue("lastname", $lastname);
        $stmt->bindValue("gender", $gender);
        $stmt->bindValue("idnumber", $idnumber);
        $stmt->bindValue("branch", $branch);
        $stmt->bindValue("profpicture", $profpicture);
        $stmt->bindValue("position", $position);
        $stmt->bindValue("roles", $roles);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();

        $sql_contacts = "INSERT INTO contacts (id, ref_type, ref_id, phone_number1, phone_number2, email, postal_number, postal_code, town, residential_area, estate, street, division, location, sub_location)"
                . " VALUES ('', '{$ref_type}', '{$ref_id}', '{$phone_number1}', '{$phone_number2}', '{$email}', '{$postal_number}', '{$postal_code}', '{$town}', '{$residential_area}', '{$estate}', '{$street}', '{$division}', '{$location}', '{$sub_location}')";
        $this->executeQuery($sql_contacts);

        return true;
    }

    private function getUserRefTypeId($user_type) {
        $sql = "SELECT id, name, roles, status FROM user_types WHERE name=:user_type";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("user_type", $user_type);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data = $data[0];
        return $data['id'];
    }

    public function getPositions() {
        $stmt = $this->prepareQuery("SELECT id, name, roles, status FROM positions WHERE status=1 ORDER BY name ASC");
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
            $html = "<option value=\"\">No position entered into the database!</option>";
        echo $html;
        return $currentGroup;
    }

    private function addPosition() {
        $roles = $_POST['roles'];
        $name = $_POST['name'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO positions (name, roles, createdat, createdby)"
                . " VALUES (:name, :roles, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("roles", $roles);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    private function addUserType() {
        $roles = $_POST['roles'];
        $name = $_POST['name'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO user_types (name, roles, createdat, createdby)"
                . " VALUES (:name, :roles, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("roles", $roles);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

    public function getRoles() {
        $stmt = $this->prepareQuery("SELECT id, description, status FROM roles WHERE status=1 ORDER BY description ASC");
        $stmt->execute();
        $currentGroup = null;
        $html = "";
        while ($row = $stmt->fetch()) {
            if (is_null($currentGroup)) {
                $currentGroup = $row['description'];
                $html .= "<option value=\"{$row['id']}\" selected>{$row['description']}</option>";
            } else {
                $html .= "<option value=\"{$row['id']}\">{$row['description']}</option>";
            }
        }
        if ($html == "")
            $html = "<option value=\"\">No role entered into the database!</option>";
        echo $html;
        return $currentGroup;
    }

    private function addRole() {
        $description = $_POST['description'];
        $createdat = date("Y-m-d H:m:s.u");
        $createdby = $_POST['createdby'];

        $sql = "INSERT INTO roles (description, createdat, createdby)"
                . " VALUES (:description, :createdat, :createdby)";

        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("description", $description);
        $stmt->bindValue("createdat", $createdat);
        $stmt->bindValue("createdby", $createdby);
        $stmt->execute();
        return true;
    }

}

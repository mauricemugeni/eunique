<?php

require WPATH . "core/include.php";
$currentPage = "";

if (is_menu_set('modules/home.php') != "" ) App::logOut();

else if (is_menu_set('home') != "") {
    $currentPage = WPATH . "modules/home.php";
    set_title("Eunique");
}
else if (is_menu_set('add_status_element') != "") {
    $currentPage = WPATH . "modules/add/add_status_element.php";
    set_title("Eunique");
}
else if (is_menu_set('add_status') != "") {
    $currentPage = WPATH . "modules/add/add_status.php";
    set_title("Eunique");
}
else if (is_menu_set('add_branch') != "") {
    $currentPage = WPATH . "modules/add/add_branch.php";
    set_title("Eunique");
}
else if (is_menu_set('add_account_type') != "") {
    $currentPage = WPATH . "modules/add/add_account_type.php";
    set_title("Eunique");
}
else if (is_menu_set('add_account_category') != "") {
    $currentPage = WPATH . "modules/add/add_account_category.php";
    set_title("Eunique");
}
else if (is_menu_set('add_business_form') != "") {
    $currentPage = WPATH . "modules/add/add_business_form.php";
    set_title("Eunique");
}
else if (is_menu_set('add_business_type') != "") {
    $currentPage = WPATH . "modules/add/add_business_type.php";
    set_title("Eunique");
}
else if (is_menu_set('add_default_charge_rate') != "") {
    $currentPage = WPATH . "modules/add/add_default_charge_rate.php";
    set_title("Eunique");
}
else if (is_menu_set('add_instalment_frequency') != "") {
    $currentPage = WPATH . "modules/add/add_instalment_frequency.php";
    set_title("Eunique");
}
else if (is_menu_set('add_loan_type') != "") {
    $currentPage = WPATH . "modules/add/add_loan_type.php";
    set_title("Eunique");
}

else if (is_menu_set('add_loan_guarantor') != "") {
    $currentPage = WPATH . "modules/add/add_loan_guarantor.php";
    set_title("Eunique");
}
else if (is_menu_set('add_loan_external_data') != "") {
    $currentPage = WPATH . "modules/add/add_loan_external_data.php";
    set_title("Eunique");
}
else if (is_menu_set('add_loan_data') != "") {
    $currentPage = WPATH . "modules/add/add_loan_data.php";
    set_title("Eunique");
}
else if (is_menu_set('add_loan_contact_persons') != "") {
    $currentPage = WPATH . "modules/add/add_loan_contact_persons.php";
    set_title("Eunique");
}
else if (is_menu_set('add_loan_business_data') != "") {
    $currentPage = WPATH . "modules/add/add_loan_business_data.php";
    set_title("Eunique");
}
else if (is_menu_set('add_contacts') != "") {
    $currentPage = WPATH . "modules/add/add_contacts.php";
    set_title("Eunique");
}

else if (is_menu_set('add_marital_status') != "") {
    $currentPage = WPATH . "modules/add/add_marital_status.php";
    set_title("Eunique");
}
else if (is_menu_set('add_nationality') != "") {
    $currentPage = WPATH . "modules/add/add_nationality.php";
    set_title("Eunique");
}
else if (is_menu_set('add_response') != "") {
    $currentPage = WPATH . "modules/add/add_response.php";
    set_title("Eunique");
}
else if (is_menu_set('add_role') != "") {
    $currentPage = WPATH . "modules/add/add_role.php";
    set_title("Eunique");
}
else if (is_menu_set('add_user_type') != "") {
    $currentPage = WPATH . "modules/add/add_user_type.php";
    set_title("Eunique");
}
else if (is_menu_set('add_position') != "") {
    $currentPage = WPATH . "modules/add/add_position.php";
    set_title("Eunique");
}
else if (is_menu_set('add_staff') != "") {
    $currentPage = WPATH . "modules/add/add_staff.php";
    set_title("Eunique");
}
else if (is_menu_set('add_transaction_type') != "") {
    $currentPage = WPATH . "modules/add/add_transaction_type.php";
    set_title("Eunique");
}
else if (is_menu_set('add_customer') != "") {
    $currentPage = WPATH . "modules/add/add_customer.php";
    set_title("Eunique");
}
else if (is_menu_set('add_customer_joint') != "") {
    $currentPage = WPATH . "modules/add/add_customer_joint.php";
    set_title("Eunique");
}
else if (is_menu_set('add_next_of_kin') != "") {
    $currentPage = WPATH . "modules/add/add_next_of_kin.php";
    set_title("Eunique");
}
else if (is_menu_set('add_deposit') != "") {
    $currentPage = WPATH . "modules/add/add_deposit.php";
    set_title("Eunique");
}
else if (is_menu_set('add_withdrawal') != "") {
    $currentPage = WPATH . "modules/add/add_withdrawal.php";
    set_title("Eunique");
}
else if (is_menu_set('add_loan') != "") {
    $currentPage = WPATH . "modules/add/add_loan.php";
    set_title("Eunique");
}
else if (is_menu_set('add_loan_balance') != "") {
    $currentPage = WPATH . "modules/add/add_loan_balance.php";
    set_title("Eunique");
}

else if (!empty($_GET)) {
    App::redirectTo("?");
}

else{
    $currentPage = WPATH . "modules/home.php";
    if ( App::isLoggedIn() ) {
		set_title("Eunique");                
	}
    }

if (App::isAjaxRequest())
    include $currentPage;
else {
    require WPATH . "core/template/layout.php";
}


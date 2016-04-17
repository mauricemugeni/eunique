<?php
require_once WPATH . "modules/classes/Loans.php";
require_once WPATH . "modules/classes/Settings.php";
$settings = new Settings();
$loans = new Loans();
if (!empty($_POST)) {
    $success = $loans->execute();
    if (is_bool($success) && $success == true) {
        $_SESSION['add_success'] = true;
    }
}
?>

<h2>Add Loan Data</h2>

<?php
if (isset($_SESSION['add_success'])) {
    ?>
    <h4>Success</h4>
    <?php
    unset($_SESSION['add_success']);
} else if (!empty($_POST)) {
    ?>
    <h4>Error</h4>
<?php } ?>

<form method="post">
    <input type="hidden" name="action" value="add_loan_data">

    <select name="marital_status"> <?php echo $settings->getMaritalStatuses(); ?> </select><p>
    <input type="text" placeholder="Enter Firstname" name="spouse_firstname" required/><p>
    <input type="text" placeholder="Enter Middlename" name="spouse_middlename" required/><p>
    <input type="text" placeholder="Enter Lastname" name="spouse_lastname" required/><p>
    <input type="text" placeholder="Enter Number of Dependants" name="dependants" required/><p>
    <input type="text" placeholder="Enter Landmark" name="landmark" required/><p>
    <input type="text" placeholder="Enter Purpose" name="purpose" required/><p>
    
    <button type="submit">Add</button>
</form>

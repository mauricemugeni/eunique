<?php
require_once WPATH . "modules/classes/Loans.php";
require_once WPATH . "modules/classes/Settings.php";
$loans = new Loans();
$settings = new Settings();
if (!empty($_POST)) {
    $success = $loans->execute();
    if (is_bool($success) && $success == true) {
        $_SESSION['add_success'] = true;
    }
}
?>

<h2>Loan Application</h2>

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
    <input type="hidden" name="action" value="add_loan">
    <input type="hidden" name="createdby" value="11">
    <input type="hidden" name="transaction_type" value="Loan">
    
    <select name="loan_type"> <?php echo $loans->getLoanTypes(); ?> </select><p>
    <input type="text" placeholder="Enter Account Number" name="account_number" required/><p>
    <input type="text" placeholder="Enter Amount" name="principal_amount" required/><p>
    <input type="text" placeholder="Enter Repayment Period" name="duration" required/><p>
        
    <button type="submit">Add</button>
</form>
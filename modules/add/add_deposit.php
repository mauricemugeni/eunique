
<?php
require_once WPATH . "modules/classes/Deposits.php";
$deposits = new Deposits();
if (!empty($_POST)) {
    $success = $deposits->execute();
    if (is_bool($success) && $success == true) {
        $_SESSION['add_success'] = true;
    }
}
?>

<h2>Add Deposit</h2>

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
    <input type="hidden" name="action" value="add_deposit">
    <input type="hidden" name="createdby" value="11">
    <input type="hidden" name="transaction_type" value="Deposit">
    
    <input type="text" placeholder="Enter Account Number" name="account_number" required/><p>
    <input type="text" placeholder="Enter Amount" name="amount" required/><p>
    <input type="text" placeholder="Enter Deposited By" name="depositedby" required/><p>
        
    <button type="submit">Add</button>
</form>
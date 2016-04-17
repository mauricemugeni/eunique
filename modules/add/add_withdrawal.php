<?php
require_once WPATH . "modules/classes/Withdrawals.php";
$withdrawals = new Withdrawals();
if (!empty($_POST)) {
    $success = $withdrawals->execute();
    if (is_bool($success) && $success == true) {
        $_SESSION['add_success'] = true;
    }
}
?>

<h2>Withdraw</h2>

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
    <input type="hidden" name="action" value="add_withdrawal">
    <input type="hidden" name="createdby" value="11">
    <input type="hidden" name="transaction_type" value="Withdrawal">
    
    <input type="text" placeholder="Enter Account Number" name="account_number" required/><p>
    <input type="text" placeholder="Enter Amount" name="amount" required/><p>
    <input type="text" placeholder="Enter Withdrawn By" name="withdrawnby" required/><p>
        
    <button type="submit">Add</button>
</form>
<?php
require_once WPATH . "modules/classes/Settings.php";
$settings = new Settings();
if (!empty($_POST)) {
    $success = $settings->execute();
    if (is_bool($success) && $success == true) {
        $_SESSION['add_success'] = true;
    }
}
?>

<h2>Add Account Type</h2>

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
    <input type="hidden" name="action" value="add_account_type">
    <input type="hidden" name="createdby" value="11">
    
    <input type="text" placeholder="Enter Account Type Name" name="name" required/><p>
    <input type="text" placeholder="Enter Opening Balance" name="opening_balance" required/><p>
    <input type="text" placeholder="Enter Minimum Balance" name="minimum_balance" required/><p>
    <input type="text" placeholder="Enter Minimum Deposit" name="minimum_deposit" required/><p>
    
    <button type="submit">Add</button>
</div>
</form>
</form>
</div>

</div>

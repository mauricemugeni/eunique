<?php
require_once WPATH . "modules/classes/Loans.php";
$loans = new Loans();
if (!empty($_POST)) {
    $success = $loans->execute();
    if (is_bool($success) && $success == true) {
        $_SESSION['add_success'] = true;
    }
}
?>

<h2>Add Loan External Data</h2>

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
    <input type="hidden" name="action" value="add_loan_external_data">
    
    <input type="text" placeholder="Enter bank name" name="bank" required/><p>
    <input type="text" placeholder="Enter branch name" name="branch" required/><p>
    <input type="text" placeholder="Enter organization" name="organization" required/><p>
    <input type="text" placeholder="Enter external loan amount" name="loan_amount" required/><p>
    <input type="text" placeholder="Enter date issued" name="date_issued" required/><p>
    <select name="external_source">
        <option value="1">I have an external source of funding</option> 
        <option value="0">I don't have an external source of funding</option>
    </select><p>
    <input type="text" placeholder="Enter description" name="description" required/><p>
    <input type="text" placeholder="Enter amount from source" name="source_amount" required/><p>
    
        
    <button type="submit">Add</button>
</form>

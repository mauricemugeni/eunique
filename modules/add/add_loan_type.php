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

<h2>Add Loan Type</h2>

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
    <input type="hidden" name="action" value="add_loan_type">
    <input type="hidden" name="createdby" value="11">
    
    <input type="text" placeholder="Enter Type Name" name="name" required/><p>
    <input type="text" placeholder="Enter Qualification Time (Months)" name="qualification_time" required/><p>
    <input type="text" placeholder="Enter Qualification Amount" name="qualification_amount" required/><p>
    <input type="text" placeholder="Enter Interest Rate" name="interest_rate" required/><p>    
    <input type="text" placeholder="Enter Maximum Duration" name="maximum_duration" required/><p>    
    <select name="instalment_frequency"> <?php echo $loans->getInstalmentFrequencies(); ?> </select><p>
        
    <button type="submit">Add</button>
</form>

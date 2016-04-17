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

<h2>Add Loan Guarantor</h2>

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
    <input type="hidden" name="action" value="add_loan_guarantor">
    
    <input type="text" placeholder="Enter Firstname" name="firstname" required/><p>
    <input type="text" placeholder="Enter Middlename" name="middlename" required/><p>
    <input type="text" placeholder="Enter Lastname" name="lastname" required/><p>
        <select name="gender">
            <option value="M">Male</option> 
            <option value="F">Female</option>
        </select><p>
    <input type="text" placeholder="Enter ID Number" name="idnumber" required/><p>
    <input type="text" placeholder="Enter Relationship" name="relationship" required/><p>
                
    <button type="submit">Add</button>
</form>

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

<h2>Add Loan Business Data</h2>

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
    <input type="hidden" name="action" value="add_loan_business_data">
    
    <input type="text" placeholder="Enter eunique credit" name="eunique_credit" required/><p>
    <input type="text" placeholder="Enter Alternative credits" name="other_credit" /><p>
    <select name="business_type"> <?php echo $settings->getBusinessTypes(); ?> </select><p>
    <select name="business_form"> <?php echo $settings->getBusinessForms(); ?> </select><p>
    <input type="text" placeholder="Enter length of time in business" name="business_time" /><p>
    <input type="text" placeholder="Enter stock_value" name="stock_value" /><p>
    <input type="text" placeholder="Enter daily_sales" name="daily_sales" /><p>
    <input type="text" placeholder="Enter monthly_income" name="monthly_income" /><p>
    <input type="text" placeholder="Enter monthly_expenses" name="monthly_expenses" /><p>
    <input type="text" placeholder="Enter number of employees" name="employees" /><p>
    <select name="licensed">
        <option value="1">Business is licensed</option> 
        <option value="0">Business is not licensed</option>
    </select><p>  
    <input type="text" placeholder="Enter road" name="road" /><p>
    <input type="text" placeholder="Enter Street" name="street" /><p>
    <input type="text" placeholder="Enter Location" name="location" /><p>
    <input type="text" placeholder="Enter building" name="building" /><p>
    <input type="text" placeholder="Enter house_number" name="house_number" /><p>
        
    <button type="submit">Add</button>
</form>

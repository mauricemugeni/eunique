<?php
require_once WPATH . "modules/classes/Users.php";
require_once WPATH . "modules/classes/Settings.php";
$settings = new Settings();
$users = new Users();
$ref_type = $_GET['ref_type'];  //If Customer or Joint-Customer or Loan
$account_number = $_GET['account_number'];  //The account_number for Customer or transaction_id for Loan

if (!empty($_POST)) {
        $success = $users->execute();
        if (is_bool($success) && $success == true) {
            $_SESSION['add_success'] = true;
            unset($_SESSION['ref_type']);
            unset($_SESSION['ref_id']);
            unset($_SESSION['profpicture']);
            unset($_SESSION['signature']);
            unset($_SESSION['account_number']);
            unset($_SESSION['createdby']);
        }
}
?>

<h2>Add Next of kin</h2>

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

<form method="post"  enctype="multipart/form-data" >
    <input type="hidden" name="action" value="add_next_of_kin">
    <input type="hidden" name="createdby" value="11">
    <input type="hidden" name="user_type" value="Next-of-kin">
    <input type="hidden" name="ref_type" value="<?php echo $ref_type; ?>">
    <input type="hidden" name="ref_id" value="<?php echo $account_number; ?>">
    
    <input type="text" placeholder="Enter Firstname" name="firstname" required/><p>
    <input type="text" placeholder="Enter Middlename" name="middlename" required/><p>
    <input type="text" placeholder="Enter Lastname" name="lastname" required/><p>
    <input type="text" placeholder="Enter Relationship" name="relationship" /><p>    
        
    <!--  Contacts -->  
    <input type="text" placeholder="Enter Phone Number" name="phone_number1" required/><p>
    <input type="text" placeholder="Enter Alternative Phone Number" name="phone_number2" /><p>
    <input type="text" placeholder="Enter Email Address" name="email" /><p>
    <input type="text" placeholder="Enter Postal Number" name="postal_number" /><p>
    <input type="text" placeholder="Enter Postal Code" name="postal_code" /><p>
    <input type="text" placeholder="Enter Postal Town" name="town" /><p>
    <input type="text" placeholder="Enter Residential Area" name="residential_area" /><p>
    <input type="text" placeholder="Enter Estate" name="estate" /><p>
    <input type="text" placeholder="Enter Street" name="street" /><p>
    <input type="text" placeholder="Enter Division" name="division" /><p>
    <input type="text" placeholder="Enter Location" name="location" /><p>
    <input type="text" placeholder="Enter Sub-Location" name="sub_location" /><p>
        
    <button type="submit">Add</button>
</form>
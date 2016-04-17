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

<h2>Add Contacts</h2>

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
    <input type="hidden" name="action" value="add_contacts">
    
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


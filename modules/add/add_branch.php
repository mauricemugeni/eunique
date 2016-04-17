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

<h2>Add Branch</h2>

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
    <input type="hidden" name="action" value="add_branch">
    <input type="hidden" name="createdby" value="11">
    
    <input type="text" placeholder="Enter Branch Code" name="branch_code" required/><p>
    <input type="text" placeholder="Enter Branch Name" name="name" required/><p>
    <input type="text" placeholder="Enter Branch Email" name="email" required/><p>
    <input type="text" placeholder="Enter Branch Phone number" name="phone_number" required/><p>
    <input type="text" placeholder="Enter Branch Location" name="location" required/><p>
    
    <button type="submit">Add</button>
</form>

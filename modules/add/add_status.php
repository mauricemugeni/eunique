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

<h2>Add Status</h2>

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
    <input type="hidden" name="action" value="add_status">
    <input type="hidden" name="createdby" value="11">
    
    <input type="text" placeholder="Enter Status Code" name="status_code" required/><p>
    <select name="status_element"> <?php echo $settings->getStatusElements(); ?> </select><p>
    <input type="text" placeholder="Enter Status Description" name="description" required/><p>
    
    <button type="submit">Add</button>
</form>

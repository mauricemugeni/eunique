<?php
require_once WPATH . "modules/classes/Users.php";
$users = new Users();
if (!empty($_POST)) {
    $success = $users->execute();
    if (is_bool($success) && $success == true) {
        $_SESSION['add_success'] = true;
    }
}
?>

<h2>Add Role</h2>

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
    <input type="hidden" name="action" value="add_role">
    <input type="hidden" name="createdby" value="11">
    
    <input type="text" placeholder="Enter Role" name="description" required/><p>
    
    <button type="submit">Add</button>
</form>


<?php
require_once WPATH . "modules/classes/RVS_Institutions.php";
$rvs_institutions = new RVS_Institutions();
if (!empty($_POST)) {
    $success = $rvs_institutions->execute();
    if (is_bool($success) && $success == true) {
        $_SESSION['add_success'] = true;
    }
}
?>

<h2>Academic Division Registration</h2>

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
    <input type="hidden" name="action" value="add_academic_area">            
    <input type="text" class="form-control" placeholder="Enter Name" name="name" required/>

    <button type="submit">Add</button>
</div>
</form>
</div>

</div>

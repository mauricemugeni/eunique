<?php
require_once WPATH . "modules/classes/Users.php";
require_once WPATH . "modules/classes/Settings.php";
$settings = new Settings();
$users = new Users();


if (!empty($_POST)) {
    $createdby = $_POST['createdby'];
    $filename = md5($createdby.date("Y-m-d H:m:s.u"));
    $profpicture_name = $_FILES['profpicture']['name'];
    $tmp_name = $_FILES['profpicture']['tmp_name'];
    $extension = substr($profpicture_name, strpos($profpicture_name, '.') + 1);
    $profpicture = $filename . '.' . $extension;
    $_SESSION['filename'] = $profpicture;    
    $location = 'modules/images/staff/';
     
    $upload_image = $location.basename($profpicture_name);

    if (move_uploaded_file($tmp_name, $location . $profpicture)) {
        $success = $users->execute();
        if (is_bool($success) && $success == true) {
            $_SESSION['add_success'] = true;
        }
    }
}

?>

<h2>Add Staff</h2>

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
    <input type="hidden" name="action" value="add_staff">
    <input type="hidden" name="createdby" value="11">
    <input type="hidden" name="user_type" value="Staff">
    
    <input type="text" placeholder="Enter Firstname" name="firstname" required/><p>
    <input type="text" placeholder="Enter Middlename" name="middlename" required/><p>
    <input type="text" placeholder="Enter Lastname" name="lastname" required/><p>
    <select name="gender">
        <option value="M">Male</option> 
        <option value="F">Female</option>
    </select><p>    
    <input type="text" placeholder="Enter ID Number" name="idnumber" required/><p>
    <select name="branch"> <?php echo $settings->getBranches(); ?> </select><p>
    <input type="file" name="profpicture" required/><p>
    <select name="position"> <?php echo $users->getPositions(); ?> </select><p>
    <select name="roles"> <?php echo $users->getRoles(); ?> </select><p>
        
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
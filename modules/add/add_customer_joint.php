<?php
require_once WPATH . "modules/classes/Users.php";
require_once WPATH . "modules/classes/Settings.php";
$settings = new Settings();
$users = new Users();
$account_number = $_GET['account_number'];  //The account_number for the parent account
$createdby = $_GET['createdby'];
    

if (!empty($_POST)) {
    $photo = md5("photo" . $createdby . date("Y-m-d H:m:s.u"));
    $profpicture_name = $_FILES['profpicture']['name'];
    $tmp_name_photo = $_FILES['profpicture']['tmp_name'];
    $extension_photo = substr($profpicture_name, strpos($profpicture_name, '.') + 1);
    $profpicture = $photo . '.' . $extension_photo;
    $_SESSION['profpicture'] = $profpicture;
    $location1 = 'modules/images/customers/photos/';

    $sign = md5("signature" . $createdby . date("Y-m-d H:m:s.u"));
    $signature_name = $_FILES['signature']['name'];
    $tmp_name_sign = $_FILES['signature']['tmp_name'];
    $extension_sign = substr($signature_name, strpos($signature_name, '.') + 1);
    $signature = $sign . '.' . $extension_sign;
    $_SESSION['signature'] = $signature;
    $location2 = 'modules/images/customers/signatures/';

    if (move_uploaded_file($tmp_name_photo, $location1 . $profpicture)) {
        move_uploaded_file($tmp_name_sign, $location2 . $signature);
        $success = $users->execute();
        if (is_bool($success) && $success == true) {
            $_SESSION['add_success'] = true;
//            if(!empty($_POST)) {
                App::redirectTo("?add_next_of_kin&ref_type=" . $_SESSION['ref_type'] . "&account_number=" . $_SESSION['account_number']);
//            } else if ($_POST[''] == $addAnotherJointAccountHolder) {
//                App::redirectTo("?add_customer_joint&account_number=" . $_SESSION['account_number']);
//            }
        }
    }
}
?>

<h2>Add Joint Account Holder</h2>

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
    <input type="hidden" name="action" value="add_customer_joint">
    <input type="hidden" name="user_type" value="Joint-Customer">
    <input type="hidden" name="account_number" value="<?php echo $account_number; ?>">
    
    <input type="text" placeholder="Enter Firstname" name="firstname" required/><p>
    <input type="text" placeholder="Enter Middlename" name="middlename" required/><p>
    <input type="text" placeholder="Enter Lastname" name="lastname" required/><p>
    <select name="gender">
        <option value="M">Male</option> 
        <option value="F">Female</option>
    </select><p>    
    <input type="text" placeholder="Enter ID Number" name="idnumber" required/><p>
    <input type="text" placeholder="Enter Date of Birth" name="birthdate" required/><p>
    <select name="nationality"> <?php echo $settings->getNationalities(); ?> </select><p>
    <input type="file" name="profpicture" required/><p>
    <input type="file" name="signature" required/><p>
    <select name="signatory">
        <option value="1">Signatory</option> 
        <option value="0">Not a signatory</option>
    </select><p>    
    
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
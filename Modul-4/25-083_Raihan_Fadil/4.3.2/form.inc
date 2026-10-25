<?php
$surname = htmlspecialchars($_POST['surname'] ?? '', ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
$address = htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8');

$state = $_POST['state'] ?? '-1';
$sex = $_POST['sex'] ?? '';
$vegetarian = isset($_POST['vegetarian']);
?>

<form action="processData_form.php" method="POST">
    <fieldset>
        <legend>Person Details</legend>

        Surname:
        <input type="text" name="surname"
               value="<?= $surname ?>">
        <br><br>

        Email address:
        <input type="text" name="email"
               value="<?= $email ?>">
        <br><br>

        Password:
        <input type="password" name="passwd">
        <br><br>

        Street Address:
        <textarea name="address"><?= $address ?></textarea>
        <br><br>

        State:
        <select name="state">
            <option value="-1" <?= $state === '-1' ? 'selected' : '' ?>>Choose your state</option>
            <option value="1" <?= $state === '1' ? 'selected' : '' ?>>Australian Capital Territory</option>
            <option value="2" <?= $state === '2' ? 'selected' : '' ?>>Queensland</option>
            <option value="3" <?= $state === '3' ? 'selected' : '' ?>>New South Wales</option>
            <option value="4" <?= $state === '4' ? 'selected' : '' ?>>Victoria</option>
            <option value="5" <?= $state === '5' ? 'selected' : '' ?>>South Australia</option>
            <option value="6" <?= $state === '6' ? 'selected' : '' ?>>Western Australia</option>
            <option value="7" <?= $state === '7' ? 'selected' : '' ?>>Northern Territory</option>
            <option value="8" <?= $state === '8' ? 'selected' : '' ?>>Tasmania</option>
            <option value="9" <?= $state === '9' ? 'selected' : '' ?>>Indonesia</option>
        </select>
        <br><br>

        <input type="hidden" name="country" value="Australia">

        Gender:
        <input type="radio" name="sex" value="male"
               <?= $sex === 'male' ? 'checked' : '' ?>> Male

        <input type="radio" name="sex" value="female"
               <?= $sex === 'female' ? 'checked' : '' ?>> Female
        <br><br>

        Vegetarian?
        <input type="checkbox" name="vegetarian" value="Yes"
               <?= $vegetarian ? 'checked' : '' ?>>
        <br><br>

        <input type="submit" name="submit" value="Submit">
        <input type="reset" value="Reset">
    </fieldset>
</form>
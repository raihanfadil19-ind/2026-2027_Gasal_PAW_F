<?php

require 'validate.inc';

$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validateRequired($errors, $_POST, 'passwd');
    validateRequired($errors, $_POST, 'address');

    validateOption(
        $errors,
        $_POST,
        'state',
        ['1', '2', '3', '4', '5', '6', '7', '8', '9']
    );

    validateOption(
        $errors,
        $_POST,
        'sex',
        ['male', 'female']
    );

    if ($errors) {
        echo '<h1>Invalid, correct the following errors:</h1>';

        foreach ($errors as $field => $error) {
            echo htmlspecialchars($field) . ' '
                 . htmlspecialchars($error) . '<br>';
        }

        include 'form.inc';
    } else {
        echo 'Form submitted successfully with no errors';
    }

} else {
    include 'form.inc';
}

?>
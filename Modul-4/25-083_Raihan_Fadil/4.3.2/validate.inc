<?php

function validateName(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) ||
        trim((string)$field_list[$field_name]) === '') {
        $errors[$field_name] = 'required';
    } elseif (!is_string($field_list[$field_name]) ||
              !preg_match("/^[a-zA-Z'-]+$/", $field_list[$field_name])) {
        $errors[$field_name] = 'invalid';
    }
}

function validateRequired(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) ||
        trim((string)$field_list[$field_name]) === '') {
        $errors[$field_name] = 'required';
    }
}

function validateEmail(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) ||
        trim((string)$field_list[$field_name]) === '') {
        $errors[$field_name] = 'required';
    } elseif (!filter_var($field_list[$field_name], FILTER_VALIDATE_EMAIL)) {
        $errors[$field_name] = 'invalid';
    }
}

function validateOption(&$errors, $field_list, $field_name, $allowed_values)
{
    if (!isset($field_list[$field_name]) ||
        $field_list[$field_name] === '' ||
        $field_list[$field_name] === '-1') {
        $errors[$field_name] = 'required';
    } elseif (!in_array($field_list[$field_name], $allowed_values, true)) {
        $errors[$field_name] = 'invalid';
    }
}
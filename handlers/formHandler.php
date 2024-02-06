<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once BASE_PATH . 'classes/FormHandler.php';
require_once BASE_PATH . 'classes/Product.php';

use classes\FormHandler;
use classes\Product;

function isEmpty($value)
{
    return empty($value) && $value != 0;
}

switch ($_POST['formName']) {
    case 'signup':
        $result = FormHandler::signup($_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['email'], $_POST['password'], $_POST['repeat-password']);
        $path = ($result) ? '/index.php' : '/php/signup.php?error=true';
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $path);
        break;
    case 'signin':
        $result = FormHandler::signin($_POST['email'], $_POST['password']);
        $path = ($result) ? '/index.php' : '/php/signin.php?error=true';
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $path);
        break;
    case 'signout':
        FormHandler::signout();
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
        break;

    case 'insertProduct':
        $description = isEmpty($_POST['description']) ? null : $_POST['description'];

        Product::insert($_POST['title'], $description, (int)$_POST['price'], null, 1);
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/php/admin-panel.php');
        break;
    case 'updateProduct':
        $title = isEmpty($_POST['title']) ? null : $_POST['title'];
        $description = isEmpty($_POST['description']) ? null : $_POST['description'];
        $price = isEmpty($_POST['price']) ? null : $_POST['price'];

        Product::findOne($_POST['id'])->update($title, $description, $price, null, null);
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/php/admin-panel.php');
        break;
    case 'deleteProduct':
        Product::findOne($_POST['id'])->delete();
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/php/admin-panel.php');
        break;
}

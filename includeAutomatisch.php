<?php
//function my_autoloader($class) {
//    include 'class/' . $class . '.php';
//}

spl_autoload_register(function ($class) {
    include 'class/' . $class . '.php';
});


echo User::findById(6)->getFullName();
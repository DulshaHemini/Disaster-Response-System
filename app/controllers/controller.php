<?php

require_once 'User.php';

class UserController {

    public function index() {
        $model = new User();
        $users = $model->getUsers();

        require 'user_view.php';
    }
}

?>
<?php
require_once __DIR__ . '/../models/User.php';

class UserController {

    public function index() {
        $model = new User();
        $users = $model->getUsers();

        require __DIR__ . '/../views/user/list.php';
    }
}
?>
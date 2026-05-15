<?php
class assignmentController {

    function index($conn) {


        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {

            if ($_POST['action'] == 'update_status') {
                $id     = $_POST['id'];
                $status = $_POST['status'];

                $model   = new AssignmentModel($conn);
                $success = $model->updateStatus($id, $status);

                header('Content-Type: application/json');
                echo json_encode(['success' => $success]);
                exit; // ← very important!
            }
        }


        $model  = new AssignmentModel($conn);
        $result = $model->getAllAssignments();

        require APP_PATH . '/views/request/request.php';
    }
}
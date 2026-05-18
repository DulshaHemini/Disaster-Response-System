<?php
    function adminpage(){
        header("Location: ../app/controllers/admin.php");
        exit();
    }

    function affected_people(){
        header("Location: ../app/controllers/affected.php");
        exit();
    }

    function volunteer(){
        header("Location: ../app/controllers/volunteer.php");
        exit();
    }
    
?>
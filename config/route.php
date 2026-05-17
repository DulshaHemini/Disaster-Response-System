<?php
    function adminpage(){
        header("Location: ../app/controllers/admin.php");
        exit();
    }
    function relief_team(){
        header("Location: ../app/controllers/relief_team.php");
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

    function geust(){
        header("Location: ../app/controllers/geust.php");
        exit();
    }
    
?>
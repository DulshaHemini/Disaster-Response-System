<?php

session_start();

require_once "../config/config.php";

$conn->select_db("DRCS1");






/* =========================================
   GET LOGGED VOLUNTEER ID
========================================= */

if (!isset($_SESSION["user_id"])) {

    // die("Please login first.");    //original file

     $_SESSION["user_id"] = 1;  // this is for testing only. Remove this line in production.
}

$volunteer_id = $_SESSION["user_id"];

$message = "";




/*if (!isset($_SESSION["user_id"])) {

    die("Please login first.");
}

$volunteer_id = $_SESSION["user_id"];

$message = "";
   this is original code */





/* =========================================
   HANDLE FORM SUBMISSION
========================================= */

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $action = $_POST['action'];




        /*if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $action = $_POST['action'];   this is original code*/ 






    /* =========================================
       ADD RESOURCE TYPE
    ========================================= */

    if ($action == "add_type") {

        $type_name = strtoupper(trim($_POST['type_name']));

        if ($type_name != "") {

            // Check duplicate type
            $sql = "SELECT *
                    FROM resource_type
                    WHERE resource_name = ?";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param("s", $type_name);

            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows == 0) {

                $sql = "INSERT INTO resource_type
                        (resource_name)
                        VALUES (?)";

                $stmt2 = $conn->prepare($sql);

                $stmt2->bind_param("s", $type_name);

                $stmt2->execute();

                $stmt2->close();

                $message = "Resource type added successfully.";

            } else {

                $message = "Resource type already exists.";
            }

            $stmt->close();
        }
    }

    /* =========================================
       DELETE RESOURCE TYPE
    ========================================= */

    if ($action == "delete_type") {

        $resource_type_id =
            intval($_POST['resource_type_id']);

        // Check default type
        $sql = "SELECT *
                FROM resource_type
                WHERE resource_type_id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $resource_type_id);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {

            // Prevent deleting default type
            if ($row['is_default'] == 1) {

                $message =
                    "Default system types cannot be deleted.";
            }

            else {

                // Check resources using this type
                $sql2 = "SELECT *
                         FROM resource
                         WHERE resource_type_id = ?";

                $stmt2 = $conn->prepare($sql2);

                $stmt2->bind_param(
                    "i",
                    $resource_type_id
                );

                $stmt2->execute();

                $result2 = $stmt2->get_result();

                if ($result2->num_rows > 0) {

                    $message =
                        "Cannot delete type because resources are using it.";

                }

                else {

                    $sql3 = "DELETE FROM resource_type
                             WHERE resource_type_id = ?";

                    $stmt3 = $conn->prepare($sql3);

                    $stmt3->bind_param(
                        "i",
                        $resource_type_id
                    );

                    $stmt3->execute();

                    $stmt3->close();

                    $message =
                        "Resource type deleted successfully.";
                }

                $stmt2->close();
            }
        }

        $stmt->close();
    }

    /* =========================================
       ADD OR UPDATE RESOURCE
    ========================================= */

    if ($action == "save_resource") {

        $resource_id =
            intval($_POST['resource_id']);

        $resource_name =
            trim($_POST['resource_name']);

        $resource_type_id =
            intval($_POST['resource_type_id']);

        $resource_unit =
            trim($_POST['resource_unit']);

        $resource_count =
            max(0, intval($_POST['resource_count']));

        $resource_max =
            max(0, intval($_POST['resource_max']));

        $description =
            trim($_POST['description']);

        // Validation
        if (
            $resource_name == "" ||
            $resource_type_id <= 0 ||
            $resource_unit == ""
        ) {

            $message = "Please fill all required fields.";
        }

        // UPDATE RESOURCE
        else if ($resource_id > 0) {

            $sql = "UPDATE resource

                    SET
                        resource_name = ?,
                        resource_type_id = ?,
                        resource_unit = ?,
                        resource_count = ?,
                        resource_max = ?,
                        description = ?,
                        updated_at = NOW()

                    WHERE resource_id = ?
                    AND volunteer_id = ?";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "sisissii",
                $resource_name,
                $resource_type_id,
                $resource_unit,
                $resource_count,
                $resource_max,
                $description,
                $resource_id,
                $volunteer_id
            );

            $stmt->execute();

            $stmt->close();

            $message = "Resource updated successfully.";
        }

        // ADD RESOURCE
        else {

            $sql = "INSERT INTO resource
                    (
                        volunteer_id,
                        resource_type_id,
                        resource_name,
                        resource_count,
                        resource_unit,
                        resource_max,
                        description
                    )

                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "iisisis",
                $volunteer_id,
                $resource_type_id,
                $resource_name,
                $resource_count,
                $resource_unit,
                $resource_max,
                $description
            );

            $stmt->execute();

            $stmt->close();

            $message = "Resource added successfully.";
        }
    }

    /* =========================================
       DELETE RESOURCE
    ========================================= */

    if ($action == "delete_resource") {

        $resource_id =
            intval($_POST['resource_id']);

        $sql = "DELETE FROM resource
                WHERE resource_id = ?
                AND volunteer_id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "ii",
            $resource_id,
            $volunteer_id
        );

        $stmt->execute();

        $stmt->close();

        $message = "Resource deleted successfully.";
    }

    header(
        "Location: resource_management.php?msg=" .
        urlencode($message)
    );

    exit();
}

/* =========================================
   GET MESSAGE
========================================= */

if (isset($_GET['msg'])) {

    $message = $_GET['msg'];
}

/* =========================================
   LOAD RESOURCE TYPES
========================================= */

$resourceTypes = array();

$sql = "SELECT *
        FROM resource_type
        ORDER BY resource_name ASC";

$result = $conn->query($sql);

if ($result) {

    while ($row = $result->fetch_assoc()) {

        $resourceTypes[] = array(

            "id" => $row['resource_type_id'],

            "name" => $row['resource_name'],

            "default" => $row['is_default']
        );
    }
}

/* =========================================
   LOAD RESOURCES
========================================= */

$resources = array();

$sql = "SELECT

            resource.resource_id,
            resource.resource_name,
            resource.resource_count,
            resource.resource_unit,
            resource.resource_max,
            resource.description,
            resource.updated_at,

            resource_type.resource_type_id,
            resource_type.resource_name AS type_name

        FROM resource

        INNER JOIN resource_type

        ON resource.resource_type_id =
           resource_type.resource_type_id

        WHERE resource.volunteer_id = ?

        ORDER BY resource.updated_at DESC";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $volunteer_id);

$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {

    $resources[] = array(

        "id" => $row['resource_id'],

        "name" => $row['resource_name'],

        "type_id" => $row['resource_type_id'],

        "type_name" => $row['type_name'],

        "qty" => intval($row['resource_count']),

        "unit" => $row['resource_unit'],

        "max" => intval($row['resource_max']),

        "notes" => $row['description'],

        "updated" => $row['updated_at']
    );
}

$stmt->close();


if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_start();

    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: signin.php");
    exit();
}


?>

<!DOCTYPE html>
<html>

<head>

    <title>Resource Management</title>

    <link
        rel="stylesheet"
        href="resource_management.css">

    <script>

        const flashMessage =
            <?php echo json_encode($message); ?>;

        const resources =
            <?php echo json_encode($resources); ?>;

        const resourceTypes =
            <?php echo json_encode($resourceTypes); ?>;

    </script>

    <script
        src="resource_management.js"
        defer>
    </script>

</head>

<body>

    <!-- =========================================
         DASHBOARD
    ========================================= -->

    <div class="dashboard-wrapper">

        <div class="card">

            <h1 id="stat-total">0</h1>

            <p>Total Items</p>

        </div>

        <div class="card">

            <h1 id="stat-ok">0</h1>

            <p>Stocked</p>

        </div>

        <div class="card">

            <h1 id="stat-low">0</h1>

            <p>Running Low</p>

        </div>

        <div class="card">

            <h1 id="stat-out">0</h1>

            <p>Out of Stock</p>

        </div>

    </div>

    <!-- =========================================
         MAIN BOX
    ========================================= -->

    <div class="main-box">

        <!-- TOP CONTROLS -->

        <div class="row">

            <button
                class="btn-red"
                onclick="openModal()">

                + Add Resource

            </button>

            <input
                type="text"
                class="btn-outline-red"
                id="searchInput"
                placeholder="Search..."
                oninput="renderTable()">

            <select
                id="typeFilter"
                class="btn-outline-red"
                onchange="renderTable()">

                <option value="">All Types</option>

            </select>

            <select
                id="statusFilter"
                class="btn-outline-red"
                onchange="renderTable()">

                <option value="">All Status</option>

                <option>Stocked</option>

                <option>Running Low</option>

                <option>Out of Stock</option>

            </select>

            <button
                class="btn-logout"
                onclick="window.location.href='resource_management.php?action=logout'">

                log out

            </button>

        </div>

        <!-- ADD TYPE -->

        <div class="row">

            <input
                type="text"
                class="btn-outline-red"
                id="newTypeInput"
                placeholder="New type...">

            <button
                class="btn-outline-red"
                
                
                onclick="addType()">

                + Add Type

            </button>

        </div>

        <!-- TYPE LIST -->

        <div
            class="row"
            id="typeList">
        </div>

        <!-- RESOURCE TABLE -->

        <table>

            <thead>

                <tr>

                    <th>Resource</th>

                    <th>Type</th>

                    <th>Qty</th>

                    <th>Unit</th>

                    <th>Status</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody id="tableBody"></tbody>

        </table>

    </div>

        <!-- =========================================
         MODAL
    ========================================= -->

    <div
        class="modal-backdrop"
        id="modalBackdrop"
        onclick="handleBackdropClick(event)">

        <div class="modal">

            <div class="modal-header">

                <h3 id="modalTitle">
                    Add Resource
                </h3>

                <button onclick="closeModal()">
                    X
                </button>

            </div>

            <div class="modal-body">

                <input
                    type="hidden"
                    id="editId">

                <!-- RESOURCE NAME -->

                <div class="form-group">

                    <label>
                        Resource Name *
                    </label>

                    <input
                        type="text"
                        id="fName">

                </div>

                <!-- TYPE + UNIT -->

                <div class="form-row">

                    <div class="form-group">

                        <label>
                            Type *
                        </label>

                        <select id="fType">

                            <option value="">
                                Select Type
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>
                            Unit *
                        </label>

                        <input
                            type="text"
                            id="fUnit">

                    </div>

                </div>

                <!-- QTY + MAX -->

                <div class="form-row">

                    <div class="form-group">

                        <label>
                            Quantity *
                        </label>

                        <input
                            type="number"
                            id="fQty"
                            min="0">

                    </div>

                    <div class="form-group">

                        <label>
                            Max Capacity
                        </label>

                        <input
                            type="number"
                            id="fMax"
                            min="1">

                    </div>

                </div>

                <!-- NOTES -->

                <div class="form-group">

                    <label>
                        Notes
                    </label>

                    <textarea id="fNotes"></textarea>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    class="btn-white"
                    onclick="closeModal()">

                    Cancel

                </button>

                <button
                    class="btn-red"
                    onclick="saveResource()">

                    Save

                </button>

            </div>

        </div>

    </div>

    <!-- =========================================
         TOAST MESSAGE
    ========================================= -->

    <div
        class="toast"
        id="toast">
    </div>

    <!-- =========================================
         HIDDEN FORMS
    ========================================= -->

    <!-- RESOURCE FORM -->

    <form
        id="resourceForm"
        method="post"
        style="display:none;">

        <input
            type="hidden"
            name="action"
            id="actionType">

        <input
            type="hidden"
            name="resource_id"
            id="resourceId">

        <input
            type="hidden"
            name="resource_name"
            id="resourceName">

        <input
            type="hidden"
            name="resource_type_id"
            id="resourceTypeId">

        <input
            type="hidden"
            name="resource_unit"
            id="resourceUnit">

        <input
            type="hidden"
            name="resource_count"
            id="resourceCount">

        <input
            type="hidden"
            name="resource_max"
            id="resourceMax">

        <input
            type="hidden"
            name="description"
            id="descriptionInput">

    </form>

    <!-- DELETE RESOURCE FORM -->

    <form
        id="deleteForm"
        method="post"
        style="display:none;">

        <input
            type="hidden"
            name="action"
            value="delete_resource">

        <input
            type="hidden"
            name="resource_id"
            id="deleteResourceId">

    </form>

    <!-- ADD TYPE FORM -->

    <form
        id="addTypeForm"
        method="post"
        style="display:none;">

        <input
            type="hidden"
            name="action"
            value="add_type">

        <input
            type="hidden"
            name="type_name"
            id="typeNameInput">

    </form>

    <!-- DELETE TYPE FORM -->

    <form
        id="deleteTypeForm"
        method="post"
        style="display:none;">

        <input
            type="hidden"
            name="action"
            value="delete_type">

        <input
            type="hidden"
            name="resource_type_id"
            id="deleteTypeId">

    </form>

</body>

</html>
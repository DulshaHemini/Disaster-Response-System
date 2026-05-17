<?php
// 1. Enable full error reporting to display any hidden errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once "../config/config.php";
$conn->select_db("DRCS");
// 2. Force override $_SESSION and $volunteer_id to 7
$_SESSION["user_id"] = 9;
$volunteer_id = $_SESSION["user_id"];
$message = "";







//{

/*

<?php
session_start();
require_once "../config/config.php";
$conn->select_db("DRCS");
/*   get logged volunteer id */   /*
if (!isset($_SESSION["user_id"])) {

    // die("Please login first.");    //original file

     $_SESSION["user_id"] = 5;  // this is for testing only. Remove this line in production.
}

$volunteer_id = $_SESSION["user_id"];
$message = "";


*/  //}      //this is original code that check user comes from previous page, but to testing we hard code user_id, to do that remove this part and added above part line 1 to 13

/*if (!isset($_SESSION["user_id"])) {

    die("Please login first.");

}

$volunteer_id = $_SESSION["user_id"];

$message = "";
   this is original code */





/* 
 handle form submissions
 */

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $action = $_POST['action'];




        /*if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $action = $_POST['action'];   this is original code*/ 






    /* 
    //    add resource type
     */

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

    /* 
    //    delete
     */

    if ($action == "delete_type") {

        $resource_type_id =
            intval($_POST['resource_type_id']);

        // check default type
        $sql = "SELECT *
                FROM resource_type
                WHERE resource_type_id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $resource_type_id);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {

            // prevent deleting default type
            if ($row['is_default'] == 1) {

                $message =
                    "Default system types cannot be deleted.";
            }

            else {

                // check resources using this type
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

    /* 
    //    add or update resource
     */

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

        // validation
        if (
            $resource_name == "" ||
            $resource_type_id <= 0 ||
            $resource_unit == ""
        ) {

            $message = "Please fill all required fields.";
        }

        // update existing resource
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

        // add resource
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

    /* 
    //    delete resource
     */

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

/* 
//    get message from query string
 */

if (isset($_GET['msg'])) {

    $message = $_GET['msg'];
}

/* 
//    load resource types for filters and forms
 */

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

/* 
 load resources for the logged volunteer
*/

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

    // unset all session variables
    session_unset();

    // destroy the session
    session_destroy();

    // Redirect to login page
   
}


?>

<!DOCTYPE html>
<html>

<head>

    <title>Resource Management</title>

    <!-- Theme and Component CSS Stylesheets -->
    <link
        rel="stylesheet"
        href="../public/assets/css/theme.css">
    <link
        rel="stylesheet"
        href="../public/assets/css/navbar.css">
    <link
        rel="stylesheet"
        href="../public/assets/css/ticker.css">
    <link
        rel="stylesheet"
        href="resource_management.css">

    <!-- Helper JavaScript for Navbar Actions -->
    <script>
        function setLang(lang, btn) {
            document.querySelectorAll('.lang-btn').forEach(b => b.classList.remove('active'));
            if (btn) btn.classList.add('active');
        }
        function openModal(action) {
            if (action === 'signin') {
                window.location.href = 'signin.php';
            } else if (action === 'signup') {
                window.location.href = 'signup.php';
            }
        }
    </script>

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

    <!-- Navbar Component -->
    <?php include '../app/views/home/_navbar.php'; ?>

    <!-- Ticker Component -->
    <?php include '../app/views/home/_ticker.php'; ?>

    <!-- Space between Ticker and Dashboard Wrapper -->
    <div style="margin-top: 20px;"></div>

    <!-- dashboard -->
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

  <!-- main box  -->

    <div class="main-box">

        <!-- top comtrols -->

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
                onclick="window.location.href=' signin.php?action=logout'">

                log out

            </button>

        </div>
         
        <!-- add type -->

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
<!-- 
        type list -->

        <div
            class="row"
            id="typeList">
        </div>

        <!-- resource table -->

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

        <!--    
        modal
     -->

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

                <!-- resource name -->

                <div class="form-group">

                    <label>
                        Resource Name *
                    </label>

                    <input
                        type="text"
                        id="fName">

                </div>

                <!-- type + unit -->

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

                <!-- qyt + max -->

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

                <!-- notes -->

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

    <!--
         toast message
         -->

    <div
        class="toast"
        id="toast">
    </div>

    <!-- 
         hidden forms
    -->

    <!-- resource form -->

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

    <!-- delete resource form -->

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

    <!-- add type form -->

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

    <!-- delete type form -->

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
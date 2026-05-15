/* =========================================
   RESOURCE STATUS
========================================= */

function getStatus(qty, max) {

    if (qty == 0) {
        return "Out of Stock";
    }

    if (max > 0) {

        if ((qty / max) < 0.25) {
            return "Running Low";
        }
    }

    return "Stocked";
}

/* =========================================
   TYPE FUNCTIONS
========================================= */

function renderTypeOptions(
    selectId,
    includeAll,
    selectedValue = ""
) {

    let select =
        document.getElementById(selectId);

    // Reset options
    if (includeAll) {

        select.innerHTML =
            '<option value="">All Types</option>';

    } else {

        select.innerHTML =
            '<option value="">Select Type</option>';
    }

    // Add types
    for (let i = 0; i < resourceTypes.length; i++) {

        let type = resourceTypes[i];

        let option =
            document.createElement("option");

        option.value = type.id;

        option.textContent = type.name;

        select.appendChild(option);
    }

    select.value = selectedValue;
}

/* =========================================
   TYPE TAG LIST
========================================= */

function renderTypeManager() {

    renderTypeOptions("typeFilter", true);

    renderTypeOptions("fType", false);

    let typeList =
        document.getElementById("typeList");

    typeList.innerHTML = "";

    for (let i = 0; i < resourceTypes.length; i++) {

        let type = resourceTypes[i];

        let deleteButton = "";

        // Hide delete button for default types
        if (type.default == 0) {

            deleteButton = `
                <span
                    onclick="deleteType(${type.id})">
                    ×
                </span>
            `;
        }

        typeList.innerHTML += `

            <div class="tag">

                ${type.name}

                ${deleteButton}

            </div>
        `;
    }
}

/* =========================================
   ADD TYPE
========================================= */

function addType() {

    let input =
        document.getElementById("newTypeInput");

    let value =
        input.value.trim();

    if (value == "") {

        showToast("Enter a type name.");

        return;
    }

    document.getElementById("typeNameInput").value =
        value;

    document.getElementById("addTypeForm").submit();
}

/* =========================================
   DELETE TYPE
========================================= */

function deleteType(typeId) {

    let confirmDelete =
        confirm("Delete this resource type?");

    if (!confirmDelete) {
        return;
    }

    document.getElementById("deleteTypeId").value =
        typeId;

    document.getElementById("deleteTypeForm").submit();
}

/* =========================================
   TABLE FUNCTIONS
========================================= */

function renderTable() {

    let searchValue =
        document.getElementById("searchInput")
        .value
        .toLowerCase();

    let typeFilter =
        document.getElementById("typeFilter")
        .value;

    let statusFilter =
        document.getElementById("statusFilter")
        .value;

    let tableBody =
        document.getElementById("tableBody");

    tableBody.innerHTML = "";

    let filteredResources = [];

    // Filter resources
    for (let i = 0; i < resources.length; i++) {

        let resource = resources[i];

        let status =
            getStatus(resource.qty, resource.max);

        let matchesSearch =

            resource.name
            .toLowerCase()
            .includes(searchValue)

            ||

            resource.type_name
            .toLowerCase()
            .includes(searchValue);

        let matchesType =

            typeFilter == ""

            ||

            resource.type_id == typeFilter;

        let matchesStatus =

            statusFilter == ""

            ||

            status == statusFilter;

        if (
            matchesSearch &&
            matchesType &&
            matchesStatus
        ) {

            filteredResources.push(resource);
        }
    }

    /* =========================================
       NO RECORDS
    ========================================= */

    if (filteredResources.length == 0) {

        tableBody.innerHTML = `

            <tr>

                <td
                    colspan="6"
                    class="no-data">

                    No resources found.

                </td>

            </tr>
        `;
    }

    /* =========================================
       SHOW RECORDS
    ========================================= */

    else {

        for (
            let i = 0;
            i < filteredResources.length;
            i++
        ) {

            let resource =
                filteredResources[i];

            let status =
                getStatus(
                    resource.qty,
                    resource.max
                );

            tableBody.innerHTML += `

                <tr>

                    <td>

                        <strong>
                            ${resource.name}
                        </strong>

                        <br>

                        <span class="table-date">

                            ${resource.updated}

                        </span>

                    </td>

                    <td>

                        <div class="tag table-tag">

                            ${resource.type_name}

                        </div>

                    </td>

                    <td>

                        ${resource.qty}

                    </td>

                    <td>

                        ${resource.unit}

                    </td>

                    <td>

                        ${status}

                    </td>

                    <td>

                        <button
                            class="btn-white table-btn"
                            onclick="editResource(${resource.id})">

                            Edit

                        </button>

                        <button
                            class="btn-red table-btn"
                            onclick="deleteResource(${resource.id})">

                            Delete

                        </button>

                    </td>

                </tr>
            `;
        }
    }

    updateStats();
}

/* =========================================
   DASHBOARD STATS
========================================= */

function updateStats() {

    let total =
        resources.length;

    let stocked = 0;

    let low = 0;

    let out = 0;

    for (let i = 0; i < resources.length; i++) {

        let status =
            getStatus(
                resources[i].qty,
                resources[i].max
            );

        if (status == "Stocked") {

            stocked++;
        }

        else if (status == "Running Low") {

            low++;
        }

        else {

            out++;
        }
    }

    document.getElementById("stat-total")
        .textContent = total;

    document.getElementById("stat-ok")
        .textContent = stocked;

    document.getElementById("stat-low")
        .textContent = low;

    document.getElementById("stat-out")
        .textContent = out;
}

/* =========================================
   MODAL FUNCTIONS
========================================= */

function openModal(clearForm = true) {

    if (clearForm) {

        document.getElementById("modalTitle")
            .textContent = "Add Resource";

        document.getElementById("editId").value = "";

        document.getElementById("fName").value = "";

        document.getElementById("fType").value = "";

        document.getElementById("fUnit").value = "";

        document.getElementById("fQty").value = "";

        document.getElementById("fMax").value = "";

        document.getElementById("fNotes").value = "";
    }

    document.getElementById("modalBackdrop")
        .classList.add("open");
}

function closeModal() {

    document.getElementById("modalBackdrop")
        .classList.remove("open");
}

function handleBackdropClick(event) {

    if (event.target.id == "modalBackdrop") {

        closeModal();
    }
}

/* =========================================
   EDIT RESOURCE
========================================= */

function editResource(id) {

    for (let i = 0; i < resources.length; i++) {

        if (resources[i].id == id) {

            let resource =
                resources[i];

            document.getElementById("modalTitle")
                .textContent = "Edit Resource";

            document.getElementById("editId").value =
                resource.id;

            document.getElementById("fName").value =
                resource.name;

            document.getElementById("fType").value =
                resource.type_id;

            document.getElementById("fUnit").value =
                resource.unit;

            document.getElementById("fQty").value =
                resource.qty;

            document.getElementById("fMax").value =
                resource.max;

            document.getElementById("fNotes").value =
                resource.notes;

            openModal(false);

            break;
        }
    }
}

/* =========================================
   SAVE RESOURCE
========================================= */

function saveResource() {

    let name =
        document.getElementById("fName")
        .value
        .trim();

    let typeId =
        document.getElementById("fType")
        .value;

    let unit =
        document.getElementById("fUnit")
        .value
        .trim();

    let qty =
        parseInt(
            document.getElementById("fQty").value
        ) || 0;

    let max =
        parseInt(
            document.getElementById("fMax").value
        ) || 0;

    let notes =
        document.getElementById("fNotes")
        .value
        .trim();

    let id =
        document.getElementById("editId").value;

    // Validation
    if (
        name == "" ||
        typeId == "" ||
        unit == ""
    ) {

        showToast(
            "Please fill all required fields."
        );

        return;
    }

    // Set hidden form values
    document.getElementById("actionType").value =
        "save_resource";

    document.getElementById("resourceId").value =
        id;

    document.getElementById("resourceName").value =
        name;

    document.getElementById("resourceTypeId").value =
        typeId;

    document.getElementById("resourceUnit").value =
        unit;

    document.getElementById("resourceCount").value =
        qty;

    document.getElementById("resourceMax").value =
        max;

    document.getElementById("descriptionInput").value =
        notes;

    // Submit form
    document.getElementById("resourceForm").submit();
}

/* =========================================
   DELETE RESOURCE
========================================= */

function deleteResource(id) {

    let confirmDelete =
        confirm("Delete this resource?");

    if (!confirmDelete) {
        return;
    }

    document.getElementById("deleteResourceId")
        .value = id;

    document.getElementById("deleteForm")
        .submit();
}

/* =========================================
   TOAST MESSAGE
========================================= */

function showToast(message) {

    let toast =
        document.getElementById("toast");

    toast.textContent = message;

    toast.classList.add("show");

    setTimeout(function () {

        toast.classList.remove("show");

    }, 2500);
}

/* =========================================
   INITIAL LOAD
========================================= */

renderTypeManager();

renderTable();

if (flashMessage) {

    showToast(flashMessage);
}
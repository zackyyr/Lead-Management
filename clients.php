<?php
$koneksi = new mysqli("localhost", "root", "", "emailLeads");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Add leads
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $company = $_POST['company'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $source = $_POST['source'];
    $location = $_POST['location'];

    $stmt = $koneksi->prepare("INSERT INTO leads (name, position, company, email, status, source, location)
                     VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $position, $company, $email, $status, $source, $location);
    // Eksekusi statement
    if ($stmt->execute()) {
        header("Location: clients.php");
        exit();
    } else {
        die("Execute failed: " . $stmt->error);
    };
    // Tutup statement
    $stmt->close();
}

// Edit Leads
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $company = $_POST['company'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $source = $_POST['source'];
    $location = $_POST['location'];

    $stmt = $koneksi->prepare("UPDATE leads SET name=?, position=?, company=?, email=?, status=?, source=?, location=? WHERE id=?");
    $stmt->bind_param("sssssssi", $name, $position, $company, $email, $status, $source, $location, $id);
    
    // Eksekusi statement
    if ($stmt->execute()) {
        header("Location: clients.php");
        exit();
    } else {
        die("Execute failed: " . $stmt->error);
    };
    // Tutup statement
    $stmt->close();
}

// Delete Leads
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $stmt = $koneksi->prepare("DELETE FROM leads WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: clients.php");
        exit();
    } else {
        die("Execute failed: " . $stmt->error);
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leads Management</title>

    <!-- CSS -->
     <link rel="stylesheet" href="style.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css" integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

</head>
<body>
    <main>
        <div class="main-container">
            <div class="main-header">
                <div class="header-text">
                    <h1>Leads Management</h1>
                    <p>Organize leads and track their progress effectively.</p>
                </div>
                <div class="header-add">
                    <button class="add-btn" id="addModal" onclick="openAddModal()"><i class="ri-add-line"></i>Add Lead</button>
                </div>
            </div>

            
            <div class="items">
                <div class="items-container">
                    <div class="items-header">
                        <div class="items-searchbar">
                            <i class="ri-search-line"></i>
                            <input type="text" id="search" placeholder="Search by name or email address" onkeyup="searchLeads()">
                        </div>
                    </div>

                    <div class="items-data">
                        <table>
                            <thead>
                                <tr class="table-header">
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Source</th>
                                    <th>Location</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="dataLeads">
                                <?php 
                                    $result = $koneksi->query("SELECT * FROM leads");

                                    while ($row = $result->fetch_assoc()) { 
                                        // Bikin class status berdasarkan value statusnya
                                        $statusClass = strtolower(str_replace(' ', '-', $row['status'])); // Convert ke lowercase & ganti spasi jadi '-'

                                        echo "<tr>";
                                        echo "<td>
                                                <div class='name-info'>
                                                    <strong>" . htmlspecialchars($row['name']) . "</strong>
                                                    <span>" . htmlspecialchars($row['position']) . "</span>
                                                </div>
                                            </td>";
                                        echo "<td>" . htmlspecialchars($row['company']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "<td><span class='status $statusClass'>" . htmlspecialchars($row['status']) . "</span></td>";
                                        echo "<td>" . htmlspecialchars($row['source']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                                        echo "<td>
                                                <button class='edit' onclick='openEditModal(" . $row['id'] . ", \"" . htmlspecialchars($row['name']) . "\", \"" . htmlspecialchars($row['position']) . "\", \"" . htmlspecialchars($row['company']) . "\", \"" . htmlspecialchars($row['email']) . "\", \"" . htmlspecialchars($row['status']) . "\", \"" . htmlspecialchars($row['source']) . "\", \"" . htmlspecialchars($row['location']) . "\")'><i class='ri-edit-line'></i></button>
                                                <button class='delete' onclick='deleteLead(" . $row['id'] . ")'><i class='ri-delete-bin-7-line'></i></button>
                                            </td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Add Lead -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Add New Lead</h2>
                <form method="POST">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter full name" required>

                    <label for="position">Position</label>
                    <input type="text" id="position" name="position" placeholder="Enter position" required>

                    <label for="company">Company</label>
                    <input type="text" id="company" name="company" placeholder="Enter company name" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter email" required>

                    <label for="status">Status</label>
                    <select name="status" id="status">
                        <option value="new">New</option>
                        <option value="contacted">Contacted</option>
                        <option value="closed">Closed</option>
                    </select>

                    <label for="source">Source</label>
                    <input type="text" id="source" name="source" placeholder="Enter lead source">

                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" placeholder="Enter location">

                    <button type="submit" name="add" class="save-btn">Save Lead</button>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="modalEdit" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h2>Edit Lead</h2>
                <form method="POST">
                    <input type="hidden" id="editId" name="id">

                    <label for="editName">Name</label>
                    <input type="text" id="editName" name="name" placeholder="Enter full name" required>

                    <label for="editPosition">Position</label>
                    <input type="text" id="editPosition" name="position" placeholder="Enter position" required>

                    <label for="editCompany">Company</label>
                    <input type="text" id="editCompany" name="company" placeholder="Enter company name" required>

                    <label for="editEmail">Email</label>
                    <input type="email" id="editEmail" name="email" placeholder="Enter email" required>

                    <label for="editStatus">Status</label>
                    <select name="status" id="editStatus">
                        <option value="new">New</option>
                        <option value="contacted">Contacted</option>
                        <option value="closed">Closed</option>
                    </select>

                    <label for="editSource">Source</label>
                    <input type="text" id="editSource" name="source" placeholder="Enter lead source">

                    <label for="editLocation">Location</label>
                    <input type="text" id="editLocation" name="location" placeholder="Enter location">

                    <button type="submit" name="update" class="save-btn">Update</button>
                </form>
            </div>
        </div>

        <!-- Delete Modal -->
        <div id="modalDelete" class="modalDelete">
            <div class="modal-content">
                <div class="delete-header">
                    <i class="ri-error-warning-fill"></i>
                    <h3>Delete Leads</h3>
                    <p>You're going to delete the leads. <br> Are you sure?</p>
                </div>
                <div class="delete-btn">
                    <form method="POST">
                        <input type="hidden" name="id" id="deleteId"> <!-- ID Barang yang akan dihapus -->
                        <button type="submit" name="delete" class="btn-danger">Yes, Delete!</button>
                        <button type="button" class="btn-cancel" onclick="closeDeleteModal('modalDelete')">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

    </main>


    <script>
        function openModal(id) {
            document.getElementById(id).classList.add("show");
        }
        function openAddModal() {
            let modal = document.getElementById("modal");
            let modalContent = document.querySelector(".modal-content");

            modal.style.display = "flex";
            setTimeout(() => {
                modalContent.classList.add("show");
            }, 10); // Delay dikit biar animasi jalan mulus
            openModal('addModal');
        }

        function closeModal() {
            let modal = document.getElementById("modal");
            let modalContent = document.querySelector(".modal-content");

            modalContent.classList.remove("show");
            setTimeout(() => {
                modal.style.display = "none";
            }, 300); // Tunggu animasi slide down selesai sebelum hide modal
        }

        
        // Edit Modal
        function openEditModal(id, name, position, company, email, status, source, location) {
            let modal = document.getElementById("modalEdit");
            let modalContent = modal.querySelector(".modal-content");

            // Set nilai input
            document.getElementById("editId").value = id;
            document.getElementById("editName").value = name;
            document.getElementById("editPosition").value = position;
            document.getElementById("editCompany").value = company;
            document.getElementById("editEmail").value = email;
            document.getElementById("editStatus").value = status;
            document.getElementById("editSource").value = source;
            document.getElementById("editLocation").value = location;

            modal.style.display = "flex";
            setTimeout(() => {
                modalContent.classList.add("show");
            }, 10);
        }
        function closeEditModal() {
            let modal = document.getElementById("modalEdit");
            let modalContent = modal.querySelector(".modal-content");
            modalContent.classList.remove("show");

            setTimeout(() => {
                modal.style.display = "none";
            }, 300);
        }

        window.onclick = function(event) {
            let modal = document.getElementById("modal");
            if (event.target === modal) {
                closeModal();
            }
        }

        // Delete modal
        function deleteLead(id) {
            let modal = document.getElementById("modalDelete");
            let modalContent = modal.querySelector(".modal-content");

            // Set ID yang akan dihapus
            document.getElementById("deleteId").value = id;

            // Tampilkan modal dengan efek animasi
            modal.style.display = "flex";
            setTimeout(() => {
                modalContent.classList.add("show");
            }, 10);
        }

        function closeDeleteModal(modalId) {
            let modal = document.getElementById(modalId);
            let modalContent = modal.querySelector(".modal-content");

            // Hilangkan efek animasi dulu
            modalContent.classList.remove("show");

            // Tunggu animasi selesai, lalu sembunyikan modal
            setTimeout(() => {
                modal.style.display = "none";
            }, 300);
        }

        window.onclick = function(event) {
            let modals = document.querySelectorAll(".modal");
            modals.forEach((modal) => {
                if (event.target === modal) {
                    closeModal(modal.id);
                }
            });
        };

        // Search
        document.getElementById("search").addEventListener("keyup", function () {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll("#dataLeads tr");

        rows.forEach(row => {
            let name = row.querySelector("td:first-child strong").innerText.toLowerCase();
            let email = row.querySelector("td:nth-child(3)").innerText.toLowerCase();

            if (name.includes(searchValue) || email.includes(searchValue)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
         });
        });

        function searchLeads() {
        let input = document.getElementById("search").value.toLowerCase();
        let rows = document.querySelectorAll("#dataLeads tr");

        rows.forEach(row => {
            let name = row.cells[0].innerText.toLowerCase();
            let email = row.cells[2].innerText.toLowerCase();

            if (name.includes(input) || email.includes(input)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
    </script>
</body>
</html>
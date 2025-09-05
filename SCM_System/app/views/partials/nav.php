<?php
session_start();
?>

<div class="sidebar" id="sidebar">
    <h2>Colors of Excellence <br /><span class="uppername">SUSL</span></h2>

    <div>
        <h3>Add Student</h3>
        <div class="innerdiv">
            <label><a href="/SCM_System/app/pages/add_students.php">Add</a></label>
            <label><a href="/SCM_System/app/pages/manage_students.php">Manage</a></label>
        </div>
    </div>
    <div>
        <h3>Add Student's Colors</h3>
        <div class="innerdiv">
            <label><a href="/SCM_System/app/pages/add_colors.php">Add</a></label>
            <label> <a href="/SCM_System/app/pages/manage_colors.php">Manage</a></label>
        </div>
    </div>
    <button> <a href="/SCM_System/app/pages/login.php" class="btn">logout</a></button>
</div>

<style>
.sidebar {
    height: 100%;
    width: 350px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #520103;
    padding-top: 20px;
    transition: transform 0.28s ease;
    transform: translateX(-100%);
    /* hide offscreen by default on small screens */
    font-family: sans-serif;
    z-index: 1000;
}

.sidebar.active {
    transform: translateX(0);
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 20px;
    color: #ffffff;
    margin-right: 120px;
}

.sidebar h3 {
    color: #ffffff;
    margin-left: 50px;
}

.uppername {
    font-size: 30px;
    margin-top: 150px;
}

.sidebar>div {
    padding-top: 12px;
}

.innerdiv {
    margin-left: 45px;
}

.sidebar a,
.sidebar label {
    padding: 5px 10px;
    text-decoration: none;
    font-size: 15px;
    color: #C1BCBCFF;
    display: block;
}

.sidebar label {
    cursor: pointer;
}

.sidebar a:hover {
    background-color: #6b2d2d;
}

.hamburger {
    font-size: 30px;
    cursor: pointer;
    padding: 10px;
    position: fixed;
    top: 10px;
    left: 10px;
    color: #520103;
    display: block;
    z-index: 1100;
    /* above sidebar */
}

.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 995;
    /* sits below hamburger but above page content */
}

.sidebar button {
    background: none;
    border: 2px solid #ffffff;
    margin: 50px 50px;
    color: #ffffff;
    width: 100px;
    height: auto;
    padding: 10px;
    border-radius: 10px;
    cursor: pointer;
    font-size: 15px;
}

.sidebar button:hover {
    background-color: #ffffff;
    border: 2px solid #520103;
    color: #520103;

}

.sidebar button a {
    text-decoration: none;
}

.overlay.active {
    display: block;
}

.btn {
    text-decoration: none;
}

.btn:hover {}

@media screen and (min-width: 768px) {
    .sidebar {
        transform: none;
        left: 0px;
        z-index: auto;
    }

    .hamburger {
        display: none;
        color: #ffffff;
    }

    .overlay {
        display: none !important;
    }
}
</style>

<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("overlay").classList.toggle("active");
}
document.addEventListener("click", function(event) {
    const sidebar = document.getElementById("sidebar");
    const hamburger = document.querySelector(".hamburger");
    const overlay = document.getElementById("overlay");
    if (!sidebar.contains(event.target) && !hamburger.contains(event.target) && sidebar.classList.contains(
            "active")) {
        sidebar.classList.remove("active");
        overlay.classList.remove("active");
    }
});
</script>

<div class="hamburger" onclick="toggleSidebar()">☰</div>
<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
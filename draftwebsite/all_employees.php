<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>AQUILA CORPS</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="all_employees.css">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #283a7a;
            color: white;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
        }

        .sidebar h1 {
            margin-bottom: 20px;
            font-size: 1.5em;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar h1 img {
            width: 50px;
            height: auto;
        }

        .sidebar a {
            text-decoration: none;
            color: inherit;
        }

        .sidebar p {
            margin: 15px 0;
            cursor: pointer;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            width: 100%;
            padding: 20px;
            height: 100vh;
            background-color: #2e3859;
            overflow: auto;
        }

    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h1>
        <img src="design\aquila.png" alt="Logo">
        AQUILA CORPS
    </h1>
    <a href="dashboard.php"><p>Dashboard</p></a>
    <a href="all_employees.php"><p>Employees</p></a>
    <a href="all_departments.php"><p>Departments</p></a>
    <a href="attendance.php"><p>Attendance</p></a>
    <a href="jobs.php"><p>Jobs</p></a>
    <a href="candidates.php"><p>Candidates</p></a>
    <a href="leaves.php"><p>Leaves</p></a>
    <a href="holidays.php"><p>Holidays</p></a>
    <a href="login_page.php"><p>Logout</p></a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="content-overlay">
        <p>Employees</p>
        <div class="container">
        <header>
            <div class="filterEntries">
                <div class="entries">
                    Show <select name="" id="table_size">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> entries
                </div>
                <div class="filter">
                    <label for="search">Search Employee:</label>
                    <input type="search" name="" id="search" placeholder="Enter name/city/post">
                </div>
            </div>
            <div class="addMemberBtn">
                <button>Add Employee</button>
            </div>
        </header>
        <table>
            <thead>
                <tr class="heading">
                    <th>SL No</th>
                    <th>Picture</th>
                    <th>Full Name</th>
                    <th>Age</th>
                    <th>City</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th>Start Date</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="userInfo">
            
            </tbody>
        </table>
        <footer>
            <span class="showEntries">Showing 1 to 10 of 50 entries</span>
            <div class="pagination">
                <!-- <button>Prev</button>
                <button class="active">1</button>
                <button>2</button>
                <button>3</button>
                <button>4</button>
                <button>5</button>
                <button>Next</button> -->
            </div>
        </footer>
    </div>
    <!--Popup Form-->
    <div class="dark_bg">
        <div class="popup">
             <header>
                <h2 class="modalTitle">Fill the Form</h2>
                <button class="closeBtn">&times;</button>
             </header>
             <div class="body">
                <form action="#" id="myForm">
                    <div class="imgholder">
                        <label for="uploadimg" class="upload">
                            <input type="file" name="" id="uploadimg" class="picture">
                            <i class="fa-solid fa-plus"></i>
                        </label>
                        <img src="./img/pic1.png" alt="" width="150" height="150" class="img">
                    </div>
                    <div class="inputFieldContainer">
                        <div class="nameField">
                            <div class="form_control">
                                <label for="fName">First Name:</label>
                                <input type="text" name="" id="fName" required>
                            </div>
                            <div class="form_control">
                                <label for="lName">Last Name:</label>
                                <input type="text" name="" id="lName" required>
                            </div>
                        </div>
                        <div class="ageCityField">
                            <div class="form_control">
                                <label for="age">Age:</label>
                                <input type="number" name="" id="age" required>
                            </div>
                            <div class="form_control">
                                <label for="city">City:</label>
                                <input type="text" name="" id="city" required>
                            </div>
                        </div>
                        <div class="postSalary">
                            <div class="form_control">
                                <label for="position">Position:</label>
                                <input type="text" name="" id="position" required>
                            </div>
                            <div class="form_control">
                                <label for="salary">Salary:</label>
                                <input type="text" name="" id="salary" required>
                            </div>
                        </div>
                        <div class="form_control">
                            <label for="sDate">Start Date:</label>
                            <input type="date" name="" id="sDate" required>
                        </div>
                        <div class="form_control">
                            <label for="email">Email:</label>
                            <input type="email" name="" id="email" required>
                        </div>
                        <div class="form_control">
                            <label for="phone">Phone:</label>
                            <input type="number" name="" id="phone" required>
                        </div>
                    </div>
                </form>
             </div>
             <footer class="popupFooter">
                <button form="myForm" class="submitBtn">Submit</button>
             </footer>
        </div>
    </div>
    <script src="all_employee.js"></script>
</body>
</html>

    </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AQUILA CORPS</title>
    <link rel="stylesheet" href="dashboard.css">
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
            width:100%;
            
            padding: 20px;
            height: 100vh;
            background-color: #2e3859;
            overflow:auto;
        }

        /* Calendar Styles */
        .calendar-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .calendar-header {
            background-color: #283a7a;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            font-size: 1.2em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            padding: 20px;
            gap: 5px;
            font-size: 0.9em;
            text-align: center;
        }

        .day-name, .day {
            padding: 10px;
            border-radius: 4px;
        }

        .day-name {
            font-weight: bold;
            color: #283a7a;
        }

        .day {
            background-color: #f0f4ff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50px; /* Adjust the height for proper visibility */
        }

        .day:hover {
            background-color: #d2e2ff;
        }

        /* Days of the week */
        .day-name:nth-child(1), .day:nth-child(7n+1) {
            color: #d9534f;
        }

        .day-name:nth-child(7), .day:nth-child(7n) {
            color: #5bc0de;
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
        <p>Welcome to Aquila Corps Dashboard</p>
    </div>

    <!-- Calendar Component -->
    <div class="calendar-container">
        <div class="calendar-header">
            <button id="prevMonth" style="background-color: #283a7a; color: white; border: none; padding: 5px 10px;">&lt;</button>
            <div id="calendarMonth">November 2024</div>
            <button id="nextMonth" style="background-color: #283a7a; color: white; border: none; padding: 5px 10px;">&gt;</button>
        </div>
        <div class="calendar-grid" id="calendarGrid">
            <!-- Days of the Week -->
            <div class="day-name">Sun</div>
            <div class="day-name">Mon</div>
            <div class="day-name">Tue</div>
            <div class="day-name">Wed</div>
            <div class="day-name">Thu</div>
            <div class="day-name">Fri</div>
            <div class="day-name">Sat</div>
        </div>
    </div>
</div>

<script>
    // Get elements
    const calendarMonth = document.getElementById('calendarMonth');
    const calendarGrid = document.getElementById('calendarGrid');
    const prevMonthButton = document.getElementById('prevMonth');
    const nextMonthButton = document.getElementById('nextMonth');

    // Initialize current date
    let currentDate = new Date();

    // Function to render the calendar for the given month and year
    function renderCalendar() {
        const month = currentDate.getMonth(); // 0-11
        const year = currentDate.getFullYear();

        // Set month name and year
        const options = { year: 'numeric', month: 'long' };
        calendarMonth.textContent = currentDate.toLocaleDateString('en-US', options);

        // Get the first day of the month and number of days in the month
        const firstDay = new Date(year, month, 1).getDay(); // 0 (Sunday) to 6 (Saturday)
        const lastDate = new Date(year, month + 1, 0).getDate(); // Number of days in the month

        // Clear previous days
        calendarGrid.innerHTML = `
            <div class="day-name">Sun</div>
            <div class="day-name">Mon</div>
            <div class="day-name">Tue</div>
            <div class="day-name">Wed</div>
            <div class="day-name">Thu</div>
            <div class="day-name">Fri</div>
            <div class="day-name">Sat</div>
        `;

        // Add empty divs for the days before the 1st of the month
        for (let i = 0; i < firstDay; i++) {
            const emptyDiv = document.createElement('div');
            calendarGrid.appendChild(emptyDiv);
        }

        // Add the actual days of the month
        for (let day = 1; day <= lastDate; day++) {
            const dayDiv = document.createElement('div');
            dayDiv.classList.add('day');
            dayDiv.textContent = day;
            calendarGrid.appendChild(dayDiv);
        }
    }

    // Event listeners for buttons to navigate months
    prevMonthButton.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    nextMonthButton.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    // Initial render
    renderCalendar();
</script>

</body>
</html>

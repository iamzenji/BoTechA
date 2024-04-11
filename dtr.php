<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTR ATTENDANCE</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body,
        button,
        input,
        select,
        textarea {
            font-family: 'Space Grotesk', sans-serif;
        }

        /* Additional CSS for borders */
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        /* CSS for adjusting dropdown size */
        .year-dropdown {
            width: 100px;
            /* Adjust width as needed */
        }

        /* CSS for coloring only the top part of the table */
        .table-bordered thead {
            background-color: #3943ac;
            /* Desired color */
            color: #ffffff;
            /* Text color on the background */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">DTR ATTENDANCE</h2>
        <!-- Search and Year Selection -->
        <div class="row mb-3">
            <div class="col-4">
                <input type="text" class="form-control form-control-sm" placeholder="Search...">
            </div>
            <div class="col-4">
                <select class="form-control form-control-sm year-dropdown">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <!-- Add more years as needed -->
                </select>
            </div>
        </div>
        <!-- Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Shift</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>William</td>
                    <td>Morning Shift</td>
                    <td>
                        <Form>
                            <input class="form-control" type="datetime-local" placeholder="Select DateTime">
                        </Form>
                    </td>
                </tr>
            <tbody>
                <tr>
                    <td>Marco</td>
                    <td>Afternoon Shift</td>
                    <td>
                        <Form>
                            <input class="form-control" type="datetime-local" placeholder="Select DateTime">
                        </Form>
                    </td>
                    </td>
                </tr>
            <tbody>
                <tr>
                    <td>Charles</td>
                    <td>Evening Shift</td>
                    <td>
                        <Form>
                            <input class="form-control" type="datetime-local" placeholder="Select DateTime">
                        </Form>
                    </td>
                </tr>
            <tbody>
                <tr>
                    <td>Alvin</td>
                    <td>Night Shift</td>
                    <td>
                        <Form>
                            <input class="form-control" type="datetime-local" placeholder="Select DateTime">
                        </Form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <Script>
        config = {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            altInput: true,
            altFormat: "F j, Y (h:S K)"
        }
        flatpickr("input[type=datetime-local]", config);
    </Script>
</body>

</html>
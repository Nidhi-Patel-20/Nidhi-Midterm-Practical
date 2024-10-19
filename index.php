<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Tour Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        .container {
            display: flex;
            justify-content: space-between;
        }
        form, table {
            width: 45%;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions {
            display: flex;
            justify-content: space-around;
        }
    </style>
</head>
<body>

<h1>Travel Tour Registration</h1>

<div class="container">
    <!-- Add Trip Form -->
    <form action="code.php" method="POST">
        <h2>Add Trip</h2>
        <label>First Name: <input type="text" name="first_name" required></label><br><br>
        <label>Last Name: <input type="text" name="last_name" required></label><br><br>
        <label>Date of Birth: <input type="date" name="dob" required></label><br><br>
        <label>Gender:
            <input type="radio" name="gender" value="Male" required> Male
            <input type="radio" name="gender" value="Female" required> Female
            <input type="radio" name="gender" value="Other" required> Other
        </label><br><br>
        <label>Email: <input type="email" name="email" required></label><br><br>
        <label>Phone Number: <input type="text" name="phone" required></label><br><br>
        <label>Tour Destination:
            <select name="destination" required>
                <option value="Paris">Paris</option>
                <option value="Rome">Rome</option>
                <option value="Tokyo">Tokyo</option>
            </select>
        </label><br><br>
        <label>Tour Type:
            <select name="tour_type" required>
                <option value="Adventure">Adventure</option>
                <option value="Relaxation">Relaxation</option>
                <option value="Cultural">Cultural</option>
            </select>
        </label><br><br>
        <label>Preferred Travel Dates: <input type="date" name="travel_dates" required></label><br><br>
        <input type="submit" name="add_trip" value="Add Trip">
    </form>

    <!-- View Trip Table -->
    <div>
        <h2>View Trips</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Destination</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db.php';
                $result = mysqli_query($conn, "SELECT * FROM trips");
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['first_name']}</td>
                        <td>{$row['last_name']}</td>
                        <td>{$row['destination']}</td>
                        <td class='actions'>
                            <a href='code.php?update={$row['id']}'>Update</a>
                            <a href='code.php?delete={$row['id']}'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

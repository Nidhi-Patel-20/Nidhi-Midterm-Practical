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
    <?php
    include 'db.php';
    $update_trip = null;

    // Check if we are updating a trip
    if (isset($_GET['update'])) {
        $id = $_GET['update'];
        $result = mysqli_query($conn, "SELECT * FROM trips WHERE id=$id");
        if (mysqli_num_rows($result) > 0) {
            $update_trip = mysqli_fetch_assoc($result);
        }
    }
    ?>

    <!-- Add Trip / Update Trip Form -->
    <form action="code.php" method="POST">
        <h2><?php echo isset($update_trip) ? 'Update Trip' : 'Add Trip'; ?></h2>
        <input type="hidden" name="id" value="<?php echo isset($update_trip) ? $update_trip['id'] : ''; ?>">
        
        <label>First Name: <input type="text" name="first_name" value="<?php echo isset($update_trip) ? $update_trip['first_name'] : ''; ?>" required></label><br><br>
        <label>Last Name: <input type="text" name="last_name" value="<?php echo isset($update_trip) ? $update_trip['last_name'] : ''; ?>" required></label><br><br>
        <label>Date of Birth: <input type="date" name="dob" value="<?php echo isset($update_trip) ? $update_trip['dob'] : ''; ?>" required></label><br><br>
        <label>Gender:
            <input type="radio" name="gender" value="Male" <?php if (isset($update_trip) && $update_trip['gender'] == 'Male') echo 'checked'; ?>> Male
            <input type="radio" name="gender" value="Female" <?php if (isset($update_trip) && $update_trip['gender'] == 'Female') echo 'checked'; ?>> Female
            <input type="radio" name="gender" value="Other" <?php if (isset($update_trip) && $update_trip['gender'] == 'Other') echo 'checked'; ?>> Other
        </label><br><br>
        <label>Email: <input type="email" name="email" value="<?php echo isset($update_trip) ? $update_trip['email'] : ''; ?>" required></label><br><br>
        <label>Phone Number: <input type="text" name="phone" value="<?php echo isset($update_trip) ? $update_trip['phone'] : ''; ?>" required></label><br><br>
        <label>Tour Destination:
            <select name="destination" required>
                <option value="Paris" <?php if (isset($update_trip) && $update_trip['destination'] == 'Paris') echo 'selected'; ?>>Paris</option>
                <option value="Rome" <?php if (isset($update_trip) && $update_trip['destination'] == 'Rome') echo 'selected'; ?>>Rome</option>
                <option value="Tokyo" <?php if (isset($update_trip) && $update_trip['destination'] == 'Tokyo') echo 'selected'; ?>>Tokyo</option>
            </select>
        </label><br><br>
        <label>Tour Type:
            <select name="tour_type" required>
                <option value="Adventure" <?php if (isset($update_trip) && $update_trip['tour_type'] == 'Adventure') echo 'selected'; ?>>Adventure</option>
                <option value="Relaxation" <?php if (isset($update_trip) && $update_trip['tour_type'] == 'Relaxation') echo 'selected'; ?>>Relaxation</option>
                <option value="Cultural" <?php if (isset($update_trip) && $update_trip['tour_type'] == 'Cultural') echo 'selected'; ?>>Cultural</option>
            </select>
        </label><br><br>
        <label>Preferred Travel Dates: <input type="date" name="travel_dates" value="<?php echo isset($update_trip) ? $update_trip['travel_dates'] : ''; ?>" required></label><br><br>
        <input type="submit" name="<?php echo isset($update_trip) ? 'update_trip' : 'add_trip'; ?>" value="<?php echo isset($update_trip) ? 'Update Trip' : 'Add Trip'; ?>">
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
                // Fetch all trips from the database and display them
                $result = mysqli_query($conn, "SELECT * FROM trips");
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['first_name']}</td>
                        <td>{$row['last_name']}</td>
                        <td>{$row['destination']}</td>
                        <td class='actions'>
                            <a href='index.php?update={$row['id']}'>Update</a>
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

<?php
session_start();
include 'db.php';

$update_trip = null;

if (isset($_GET['update'])) {
    $id = $_GET['update'];
    $stmt = $conn->prepare("SELECT * FROM trips WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $update_trip = $result->fetch_assoc();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wanderlust Adventures - Travel Tour Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .hero {
            background-image: url('img/hero.avif');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
        }
        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: -50px;
            position: relative;
        }
        .btn-primary {
            background-color: #FF6B6B;
            border-color: #FF6B6B;
        }
        .btn-primary:hover {
            background-color: #ee5253;
            border-color: #ee5253;
        }
        .form-control:focus {
            border-color: #FF6B6B;
            box-shadow: 0 0 0 0.2rem rgba(255,107,107,.25);
        }
        table {
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        th {
            background-color: #4ECDC4;
            color: white;
        }
        .icon-feature {
            font-size: 2rem;
            color: #FF6B6B;
        }
        .action-icons a {
            margin: 0 5px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<div class="hero">
    <div>
        <h1>Wanderlust Adventures</h1>
        <p class="lead">Discover the world with us</p>
    </div>
</div>

<div class="container">
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='alert alert-" . $_SESSION['message_type'] . " alert-dismissible fade show' role='alert'>
                {$_SESSION['message']}
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
    ?>

    <div class="row mb-4">
        <div class="col-md-4 text-center">
            <i class="fas fa-globe-americas icon-feature mb-3"></i>
            <h4>Explore</h4>
            <p>Discover new destinations</p>
        </div>
        <div class="col-md-4 text-center">
            <i class="fas fa-camera-retro icon-feature mb-3"></i>
            <h4>Experience</h4>
            <p>Create lasting memories</p>
        </div>
        <div class="col-md-4 text-center">
            <i class="fas fa-hiking icon-feature mb-3"></i>
            <h4>Adventure</h4>
            <p>Embark on thrilling journeys</p>
        </div>
    </div>

    <form action="code.php" method="POST" class="mb-5">
        <h2 class="text-center mb-4"><?php echo isset($update_trip) ? 'Update Your Adventure' : 'Book Your Next Adventure'; ?></h2>
        
        <input type="hidden" name="id" value="<?php echo isset($update_trip) ? $update_trip['id'] : ''; ?>">
        
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>First Name:</label>
                <input type="text" class="form-control" name="first_name" value="<?php echo isset($update_trip) ? htmlspecialchars($update_trip['first_name']) : ''; ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label>Last Name:</label>
                <input type="text" class="form-control" name="last_name" value="<?php echo isset($update_trip) ? htmlspecialchars($update_trip['last_name']) : ''; ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Date of Birth:</label>
                <input type="date" class="form-control" name="dob" value="<?php echo isset($update_trip) ? $update_trip['dob'] : ''; ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label>Gender:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" value="Male" <?php if (isset($update_trip) && $update_trip['gender'] == 'Male') echo 'checked'; ?>>
                    <label class="form-check-label">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" value="Female" <?php if (isset($update_trip) && $update_trip['gender'] == 'Female') echo 'checked'; ?>>
                    <label class="form-check-label">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" value="Other" <?php if (isset($update_trip) && $update_trip['gender'] == 'Other') echo 'checked'; ?>>
                    <label class="form-check-label">Other</label>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo isset($update_trip) ? htmlspecialchars($update_trip['email']) : ''; ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label>Phone Number:</label>
                <input type="text" class="form-control" name="phone" value="<?php echo isset($update_trip) ? htmlspecialchars($update_trip['phone']) : ''; ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Tour Destination:</label>
                <select name="destination" class="form-control" required>
                    <option value="" disabled selected>Select Destination</option>
                    <option value="Paris" <?php if (isset($update_trip) && $update_trip['destination'] == 'Paris') echo 'selected'; ?>>Paris</option>
                    <option value="Rome" <?php if (isset($update_trip) && $update_trip['destination'] == 'Rome') echo 'selected'; ?>>Rome</option>
                    <option value="Tokyo" <?php if (isset($update_trip) && $update_trip['destination'] == 'Tokyo') echo 'selected'; ?>>Tokyo</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Tour Type:</label>
                <select name="tour_type" class="form-control" required>
                    <option value="" disabled selected>Select Tour Type</option>
                    <option value="Adventure" <?php if (isset($update_trip) && $update_trip['tour_type'] == 'Adventure') echo 'selected'; ?>>Adventure</option>
                    <option value="Relaxation" <?php if (isset($update_trip) && $update_trip['tour_type'] == 'Relaxation') echo 'selected'; ?>>Relaxation</option>
                    <option value="Cultural" <?php if (isset($update_trip) && $update_trip['tour_type'] == 'Cultural') echo 'selected'; ?>>Cultural</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Preferred Travel Dates:</label>
                <input type="date" class="form-control" name="travel_dates" value="<?php echo isset($update_trip) ? $update_trip['travel_dates'] : ''; ?>" required>
            </div>
        </div>

        <button type="submit" name="<?php echo isset($update_trip) ? 'update_trip' : 'add_trip'; ?>" class="btn btn-primary btn-block">
            <?php echo isset($update_trip) ? 'Update Adventure' : 'Book Adventure'; ?>
        </button>
    </form>

    <h2 class="text-center mb-4">Your Adventures</h2>
    <div class="table-responsive">
        <table class='table table-hover'>
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Destination</th>
                    <th>Tour Type</th>
                    <th>Travel Dates</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM trips");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</td>
                        <td>" . htmlspecialchars($row['destination']) . "</td>
                        <td>" . htmlspecialchars($row['tour_type']) . "</td>
                        <td>" . htmlspecialchars($row['travel_dates']) . "</td>
                        <td class='action-icons'>
                            <a href='index.php?update={$row['id']}' title='Update'><i class='fas fa-edit text-warning'></i></a>
                            <a href='code.php?delete={$row['id']}' onclick='return confirm(\"Are you sure you want to cancel this adventure?\");' title='Cancel'><i class='fas fa-trash-alt text-danger'></i></a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
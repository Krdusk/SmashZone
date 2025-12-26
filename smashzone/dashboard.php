<?php 
session_start();
include 'db.php'; 

// RESTRICT ACCESS: Redirect to login if not logged in
if (!isset($_SESSION['uid'])) {
    header("Location: index.html");
    exit();
}

$user_id = $_SESSION['uid'];
$display_name = isset($_SESSION['name']) ? explode(' ', $_SESSION['name'])[0] : 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - SmashZone</title>
    <style>
        :root { --primary: #27ae60; --dark: #2c3e50; --light: #f4f7f6; --warning: #f1c40f; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--light); margin: 0; display: flex; }
        
        /* Sidebar Navigation */
        nav { width: 250px; background: var(--dark); color: white; min-height: 100vh; padding: 20px; box-sizing: border-box; position: fixed; }
        nav h2 { color: var(--primary); margin-bottom: 30px; }
        nav a { display: block; color: #bdc3c7; text-decoration: none; padding: 12px; margin-bottom: 5px; border-radius: 8px; transition: 0.3s; }
        nav a:hover, nav a.active { background: #34495e; color: white; }
        
        /* Main Content */
        main { flex: 1; margin-left: 250px; padding: 40px; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
        
        /* Form Alignment Fix */
        .booking-form {
            display: grid; 
            gap: 20px; 
            grid-template-columns: repeat(3, 1fr) auto; 
            align-items: end;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-group label {
            font-weight: bold;
            font-size: 0.9rem;
            color: var(--dark);
        }

        select, input[type="date"] {
            padding: 12px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box; /* Ensures padding doesn't break alignment */
            font-family: inherit;
        }

        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 15px; border-bottom: 1px solid #eee; }
        
        /* Buttons */
        .btn-booking { background: var(--primary); color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer; font-weight: bold; height: 45px; }
        .btn-pay { background: var(--warning); color: #2c3e50; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; margin-right: 5px; font-size: 0.9rem; }
        .btn-cancel { background: #ff7675; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <nav>
        <h2>🏸 SmashZone</h2>
        <a href="home.php">🏠 Home</a> 
        <a href="dashboard.php" class="active">📊 Dashboard</a>
        <a href="tournaments.php">🏆 Tournaments</a>
        <a href="transactions.php">💳 Payments</a>
        <a href="logout.php" style="margin-top: 50px; color: #ff7675;">🚪 Logout</a>
    </nav>

    <main>
        <h1>Welcome, <?php echo htmlspecialchars($display_name); ?>!</h1>

        <div class="card">
            <h3>Book a Court</h3>
            <form action="book.php" method="POST" class="booking-form">
                <div class="form-group">
                    <label>Court</label>
                    <select name="court" required>
                        <option value="">Select Court</option>
                        <?php
                        $courts = $conn->query("SELECT * FROM courts");
                        while($c = $courts->fetch_assoc()) echo "<option value='{$c['id']}'>{$c['name']}</option>";
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group">
                    <label>Time Slot</label>
                    <select name="time" required>
                        <option value="08:00 - 09:00">08:00 - 09:00</option>
                        <option value="09:00 - 10:00">09:00 - 10:00</option>
                    </select>
                </div>
                <button type="submit" class="btn-booking">Book Court</button>
            </form>
        </div>

        <div class="card">
            <h3>Your Active Bookings</h3>
            <table>
                <thead>
                    <tr><th>Court</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php
                    $res = $conn->query("SELECT bookings.id, courts.name, booking_date, time_slot, payment_status 
                                         FROM bookings JOIN courts ON bookings.court_id = courts.id 
                                         WHERE user_id = $user_id ORDER BY booking_date ASC");
                    while($b = $res->fetch_assoc()): ?>
                        <tr>
                            <td><b><?php echo htmlspecialchars($b['name']); ?></b></td>
                            <td><?php echo $b['booking_date']; ?></td>
                            <td><?php echo $b['time_slot']; ?></td>
                            <td><?php echo ($b['payment_status'] == 'completed') ? '<b style="color:green">Paid</b>' : '<b style="color:orange">Pending</b>'; ?></td>
                            <td style="display: flex; gap: 5px;">
                                <?php if($b['payment_status'] != 'completed'): ?>
                                    <a href="pay_now.php?id=<?php echo $b['id']; ?>" class="btn-pay">Pay</a>
                                <?php endif; ?>
                                <form action="cancel_booking.php" method="POST" style="margin:0;">
                                    <input type="hidden" name="booking_id" value="<?php echo $b['id']; ?>">
                                    <button class="btn-cancel">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
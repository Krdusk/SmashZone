SmashZone Website Setup Guide (WAMP)
Follow these steps to deploy the SmashZone Elite Badminton Booking system on your local machine using WAMP.

1. Prerequisites
WAMP Server (Ensure it is installed and the icon in the taskbar is green).

Code Editor (e.g., VS Code or Notepad++ or simply notepad).

2. File Structure
In WAMP, the web directory is www. Create a folder named smashzone inside C:\wamp64\www\ and organize your files as follows:

C:\wamp64\www\smashzone\
├── db.php               # Database connection settings
├── index.html           # Login/Register page
├── auth.php             # Authentication logic (Processes login/register)
├── home.php             # Secure landing page (Slideshow)
├── dashboard.php        # User booking dashboard
├── transactions.php     # Payment history
├── logout.php           # Ends the session
└── auth/
    └── register.php     # Registration processing


3. Database Configuration
Open phpMyAdmin by visiting http://localhost/phpmyadmin/ in your browser.

Login (Default WAMP username is root, and the password is usually blank).

Create a new database named smashzone.

Click the SQL tab and paste/run the following code:

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user'
);

CREATE TABLE courts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50)
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    court_id INT,
    booking_date DATE,
    time_slot VARCHAR(50),
    payment_status ENUM('pending', 'completed') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (court_id) REFERENCES courts(id)
);

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    amount DECIMAL(10,2),
    payment_method VARCHAR(50),
    status VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Initial Data
INSERT INTO courts (name) VALUES ('Court A'), ('Court B'), ('Court C');


if this doesn't work insert the sql files on the folder to the database manually



4. How to Run
Launch WAMP Server.

Ensure your project is in C:\wamp64\www\smashzone\.

Open your browser and navigate to: http://localhost/smashzone/index.html.

Test the flow: Register an account, log in (it will redirect you to home.php), and then navigate to your dashboard.php to book a court.

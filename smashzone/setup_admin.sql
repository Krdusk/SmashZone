-- Create Transactions Table
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    amount DECIMAL(10,2),
    payment_method VARCHAR(50),
    status VARCHAR(20) DEFAULT 'completed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert Permanent Admin (Password is admin123)
INSERT IGNORE INTO users (fullname, email, password, role) 
VALUES ('System Admin', 'admin@smashzone.com', '$2y$10$89.p84/X6SInB2Kq/C87f.vQz1ZfC3Yl00H1NnC6h8P8jW6rV.vK.', 'admin');;
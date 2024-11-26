-- Step 2: Create the database
CREATE DATABASE IF NOT EXISTS webtech_fall2024_aduot_jok;

-- Step 3: Use the database
USE webtech_fall2024_aduot_jok;

-- Step 5: Create the Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    userpass VARCHAR(255) NOT NULL,
    userrole ENUM('admin', 'user') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Step 6: Create the Regions Table
CREATE TABLE regions (
    region_id INT AUTO_INCREMENT PRIMARY KEY,
    region_name VARCHAR(100) NOT NULL UNIQUE,
    country VARCHAR(100) NOT NULL
);


CREATE TABLE purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    region VARCHAR(100) NOT NULL,
    quantity INT NOT NULL,
    cost DECIMAL(10,2) NOT NULL,
    seller VARCHAR(100) NOT NULL,
    status ENUM('Paid', 'Pending') NOT NULL
);

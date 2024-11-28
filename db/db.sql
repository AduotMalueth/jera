-- Step 2: Create the database
CREATE DATABASE IF NOT EXISTS webtech_fall2024_aduot_jok;
-- This creates the database named 'webtech_fall2024_aduot_jok' if it doesn't already exist. Useful for ensuring the database is only created once.

-- Step 3: Use the database
USE webtech_fall2024_aduot_jok;
-- This command sets the context to use the 'webtech_fall2024_aduot_jok' database for subsequent SQL operations.

-- Step 5: Create the Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY, -- The 'id' column is an integer that auto-increments with each new user. It's the primary key.
    name VARCHAR(255) NOT NULL, -- 'name' stores the user's full name. It cannot be null.
    email VARCHAR(255) UNIQUE NOT NULL, -- 'email' is the user's email address. It must be unique and cannot be null.
    userpass VARCHAR(255) NOT NULL, -- 'userpass' stores the user's password. It is mandatory and cannot be null.
    userrole ENUM('admin', 'user') NOT NULL, -- 'userrole' defines whether the user is an 'admin' or a 'user'. It cannot be null.
    coconuts INT DEFAULT 0, -- 'coconuts' tracks some form of user points or currency, defaulting to 0.
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- 'created_at' auto-generates the timestamp of when the user is created.
);

-- Create the Comments Table
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY, -- The 'id' is the unique identifier for each comment.
    name VARCHAR(255) NOT NULL, -- 'name' stores the commenter's name.
    email VARCHAR(255) NOT NULL, -- 'email' stores the commenter's email.
    contact VARCHAR(15) NOT NULL, -- 'contact' stores the phone number of the commenter, limited to 15 characters.
    type ENUM('buyer', 'seller') NOT NULL, -- 'type' defines whether the commenter is a 'buyer' or 'seller'.
    region VARCHAR(255) NOT NULL, -- 'region' records the region where the commenter is located.
    comment TEXT NOT NULL, -- 'comment' stores the actual feedback or comment text.
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- 'created_at' auto-generates the timestamp of when the comment was created.
);

-- Create the Buy Now Table
CREATE TABLE buy_now (
    id INT AUTO_INCREMENT PRIMARY KEY, -- 'id' is the unique identifier for each purchase record.
    purchase_date DATE NOT NULL, -- 'purchase_date' stores the date of the purchase.
    region VARCHAR(255) NOT NULL, -- 'region' indicates where the purchase is made.
    quantity INT NOT NULL, -- 'quantity' specifies how many units were purchased.
    unit_price DECIMAL(10, 2) NOT NULL, -- 'unit_price' defines the price per unit of the product.
    total_price DECIMAL(10, 2) NOT NULL -- 'total_price' is the total cost of the purchase, calculated as quantity * unit_price.
);

-- Create the Products Table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY, -- 'id' is the unique identifier for each product.
    image VARCHAR(255) NOT NULL, -- 'image' stores the product image URL or path.
    description TEXT NOT NULL, -- 'description' provides a detailed description of the product.
    contact_info VARCHAR(255) NOT NULL, -- 'contact_info' stores the seller's contact information.
    region VARCHAR(255) NOT NULL, -- 'region' specifies the location of the product.
    price DECIMAL(10, 2) NOT NULL, -- 'price' indicates the product price.
    status ENUM('Available', 'Not Available') NOT NULL, -- 'status' shows whether the product is available for sale or not.
    name VARCHAR(255) NOT NULL, -- 'name' stores the product's name.
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- 'date_added' auto-generates the timestamp when the product is listed.
);

-- Insert a sample comment record into the comments table
INSERT INTO comments (name, email, contact, type, region, comment) 
VALUES ('John Doe', 'john@example.com', '1234567890', 'buyer', 'Western', 'Test comment.');
-- This inserts a sample comment by a buyer named John Doe with their contact information and region into the comments table.

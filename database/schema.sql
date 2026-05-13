-- EchoCare Fundraising System Database Schema
-- CSIT314 Software Development Methodologies
-- Purpose: Shows MySQL backend data design and relationships.

CREATE DATABASE IF NOT EXISTS echocare_db;
USE echocare_db;

DROP TABLE IF EXISTS monthly_reports;
DROP TABLE IF EXISTS weekly_reports;
DROP TABLE IF EXISTS daily_reports;
DROP TABLE IF EXISTS donations;
DROP TABLE IF EXISTS favourites;
DROP TABLE IF EXISTS fundraising_activities;
DROP TABLE IF EXISTS fra_categories;
DROP TABLE IF EXISTS user_profiles;
DROP TABLE IF EXISTS user_accounts;

CREATE TABLE user_accounts (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user_admin', 'donee', 'fundraiser', 'platform_manager') NOT NULL,
    permission VARCHAR(100) DEFAULT 'Basic Access',
    status ENUM('Active', 'Suspended') DEFAULT 'Active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_profiles (
    profile_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    phone VARCHAR(30),
    address VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user_accounts(user_id)
);

CREATE TABLE fra_categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL,
    description TEXT,
    status ENUM('Active', 'Suspended') DEFAULT 'Active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE fundraising_activities (
    fra_id INT AUTO_INCREMENT PRIMARY KEY,
    fundraiser_id INT NOT NULL,
    category_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    goal_amount DECIMAL(10,2) NOT NULL,
    current_amount DECIMAL(10,2) DEFAULT 0.00,
    status ENUM('Active', 'Disabled', 'Completed') DEFAULT 'Active',
    start_date DATE,
    end_date DATE,
    views INT DEFAULT 0,
    shortlist_count INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fundraiser_id) REFERENCES user_accounts(user_id),
    FOREIGN KEY (category_id) REFERENCES fra_categories(category_id)
);

CREATE TABLE favourites (
    favourite_id INT AUTO_INCREMENT PRIMARY KEY,
    donee_id INT NOT NULL,
    fra_id INT NOT NULL,
    saved_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (donee_id) REFERENCES user_accounts(user_id),
    FOREIGN KEY (fra_id) REFERENCES fundraising_activities(fra_id)
);

CREATE TABLE donations (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    donee_id INT NOT NULL,
    fra_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    donation_status ENUM('Completed', 'Pending', 'Failed') DEFAULT 'Completed',
    donated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (donee_id) REFERENCES user_accounts(user_id),
    FOREIGN KEY (fra_id) REFERENCES fundraising_activities(fra_id)
);

CREATE TABLE daily_reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    report_date DATE NOT NULL,
    total_funds_raised DECIMAL(10,2) DEFAULT 0.00,
    total_donations INT DEFAULT 0,
    total_transactions INT DEFAULT 0,
    completed_fra INT DEFAULT 0,
    generated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE weekly_reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    week_start_date DATE NOT NULL,
    week_end_date DATE NOT NULL,
    total_funds_raised DECIMAL(10,2) DEFAULT 0.00,
    total_donations INT DEFAULT 0,
    total_transactions INT DEFAULT 0,
    completed_fra INT DEFAULT 0,
    generated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE monthly_reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    report_month INT NOT NULL,
    report_year INT NOT NULL,
    total_funds_raised DECIMAL(10,2) DEFAULT 0.00,
    total_donations INT DEFAULT 0,
    completed_fra INT DEFAULT 0,
    average_donation DECIMAL(10,2) DEFAULT 0.00,
    generated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Sample users
INSERT INTO user_accounts (username, email, password_hash, role, permission, status) VALUES
('System Admin', 'admin@echocare.com', 'hashed_admin123', 'user_admin', 'Full Access', 'Active'),
('Donee User', 'donee@echocare.com', 'hashed_donee123', 'donee', 'Donation Access', 'Active'),
('Fundraiser User', 'fundraiser@echocare.com', 'hashed_fundraiser123', 'fundraiser', 'Campaign Access', 'Active'),
('Platform Manager', 'pm@echocare.com', 'hashed_pm123456', 'platform_manager', 'Platform Access', 'Active');

-- Sample profiles
INSERT INTO user_profiles (user_id, full_name, phone, address) VALUES
(1, 'System Admin', '90000001', 'Singapore'),
(2, 'Donee User', '90000002', 'Singapore'),
(3, 'Fundraiser User', '90000003', 'Singapore'),
(4, 'Platform Manager', '90000004', 'Singapore');

-- Sample categories
INSERT INTO fra_categories (category_name, description, status) VALUES
('Education', 'Fundraising activities for school fees, books, and learning support.', 'Active'),
('Food Support', 'Fundraising activities for food aid and meal support.', 'Active'),
('Healthcare', 'Fundraising activities for medical and healthcare support.', 'Active');

-- Sample campaigns
INSERT INTO fundraising_activities
(fundraiser_id, category_id, title, description, goal_amount, current_amount, status, start_date, end_date, views, shortlist_count)
VALUES
(3, 1, 'School Supplies Donation Drive', 'Raising funds to provide school supplies for children in need.', 5000.00, 1200.00, 'Active', '2026-05-01', '2026-06-30', 18, 2),
(3, 2, 'Community Meal Support', 'Providing meals for low-income families.', 8000.00, 3000.00, 'Completed', '2026-04-01', '2026-04-30', 24, 3);

-- Sample favourites
INSERT INTO favourites (donee_id, fra_id) VALUES
(2, 1),
(2, 2);

-- Sample donations
INSERT INTO donations (donee_id, fra_id, amount, donation_status, donated_at) VALUES
(2, 1, 50.00, 'Completed', '2026-05-01 10:30:00'),
(2, 2, 30.00, 'Completed', '2026-05-05 14:15:00');

-- Sample reports
INSERT INTO daily_reports (report_date, total_funds_raised, total_donations, total_transactions, completed_fra) VALUES
('2026-05-05', 30.00, 1, 1, 1);

INSERT INTO weekly_reports (week_start_date, week_end_date, total_funds_raised, total_donations, total_transactions, completed_fra) VALUES
('2026-05-01', '2026-05-07', 80.00, 2, 2, 1);

INSERT INTO monthly_reports (report_month, report_year, total_funds_raised, total_donations, completed_fra, average_donation) VALUES
(5, 2026, 80.00, 2, 1, 40.00);
-- EchoCare Fundraising System Database Schema
-- CSIT314 Software Development Methodologies
-- Purpose: Shows MySQL backend data design and relationships.

CREATE DATABASE IF NOT EXISTS echocare_db;
USE echocare_db;

DROP TABLE IF EXISTS monthly_reports;
DROP TABLE IF EXISTS weekly_reports;
DROP TABLE IF EXISTS daily_reports;
DROP TABLE IF EXISTS donations;
DROP TABLE IF EXISTS favorites;
DROP TABLE IF EXISTS fundraising_activities;
DROP TABLE IF EXISTS fra_categories;
DROP TABLE IF EXISTS user_profiles;
DROP TABLE IF EXISTS managed_user_accounts;

CREATE TABLE managed_user_accounts (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) DEFAULT 'default_password_hash',
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
    role VARCHAR(50) NOT NULL,
    status VARCHAR(50) DEFAULT 'Active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES managed_user_accounts(user_id)
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
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    goal_amount DECIMAL(10,2) NOT NULL,
    current_amount DECIMAL(10,2) DEFAULT 0.00,
    category VARCHAR(100) NOT NULL,
    status ENUM('Active', 'Disabled', 'Completed') DEFAULT 'Active',
    start_date DATE,
    end_date DATE,
    view_count INT DEFAULT 0,
    shortlist_count INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fundraiser_id) REFERENCES managed_user_accounts(user_id)
);

CREATE TABLE favorites (
    favorite_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    fra_id INT NOT NULL,
    saved_date DATE NOT NULL,
    UNIQUE KEY unique_user_fra (user_id, fra_id),
    FOREIGN KEY (user_id) REFERENCES managed_user_accounts(user_id),
    FOREIGN KEY (fra_id) REFERENCES fundraising_activities(fra_id)
);

CREATE TABLE donations (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    donee_id INT NOT NULL,
    fra_title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    donation_date DATE NOT NULL,
    status VARCHAR(50) NOT NULL,
    FOREIGN KEY (donee_id) REFERENCES managed_user_accounts(user_id)
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

INSERT INTO managed_user_accounts
(username, email, password_hash, role, permission, status)
VALUES
('System Admin', 'admin@echocare.com', 'hashed_admin123', 'user_admin', 'Full Access', 'Active'),
('Donee User', 'donee@echocare.com', 'hashed_donee123', 'donee', 'Donation Access', 'Active'),
('Fundraiser User', 'fundraiser@echocare.com', 'hashed_fundraiser123', 'fundraiser', 'Campaign Access', 'Active'),
('Platform Manager', 'pm@echocare.com', 'hashed_pm123456', 'platform_manager', 'Platform Access', 'Active');

INSERT INTO user_profiles
(user_id, full_name, phone, address, role, status)
VALUES
(1, 'System Admin', '90000001', 'Singapore', 'user_admin', 'Active'),
(2, 'Donee User', '90000002', 'Singapore', 'donee', 'Active'),
(3, 'Fundraiser User', '90000003', 'Singapore', 'fundraiser', 'Active'),
(4, 'Platform Manager', '90000004', 'Singapore', 'platform_manager', 'Active');

INSERT INTO fra_categories
(category_name, description, status)
VALUES
('Education', 'Fundraising activities for school fees, books, and learning support.', 'Active'),
('Food Support', 'Fundraising activities for food aid and meal support.', 'Active'),
('Healthcare', 'Fundraising activities for medical and healthcare support.', 'Active');

INSERT INTO fundraising_activities
(fundraiser_id, title, description, goal_amount, current_amount, category, status, start_date, end_date, view_count, shortlist_count)
VALUES
(3, 'School Supplies Donation Drive', 'Raising funds to provide school supplies for children in need.', 5000.00, 1200.00, 'Education', 'Active', '2026-05-01', '2026-06-30', 18, 2),
(3, 'Community Meal Support', 'Providing meals for low-income families.', 8000.00, 3000.00, 'Food Support', 'Completed', '2026-04-01', '2026-04-30', 24, 3);

INSERT INTO favorites
(user_id, fra_id, saved_date)
VALUES
(2, 1, '2026-05-01'),
(2, 2, '2026-05-05');

INSERT INTO donations
(donee_id, fra_title, category, amount, donation_date, status)
VALUES
(2, 'School Supplies Donation Drive', 'Education', 50.00, '2026-05-01', 'Completed'),
(2, 'Community Meal Support', 'Food Support', 30.00, '2026-05-05', 'Completed');

INSERT INTO daily_reports
(report_date, total_funds_raised, total_donations, total_transactions, completed_fra)
VALUES
('2026-05-05', 30.00, 1, 1, 1);

INSERT INTO weekly_reports
(week_start_date, week_end_date, total_funds_raised, total_donations, total_transactions, completed_fra)
VALUES
('2026-05-01', '2026-05-07', 80.00, 2, 2, 1);

INSERT INTO monthly_reports
(report_month, report_year, total_funds_raised, total_donations, completed_fra, average_donation)
VALUES
(5, 2026, 80.00, 2, 1, 40.00);

-- Completed FRA demo records for User Story:
-- Search/View Completed Fundraising History

INSERT INTO fundraising_activities
(fundraiser_id,title,description,goal_amount,current_amount,
category,status,start_date,end_date,view_count,shortlist_count)

VALUES

(3,
'Completed Meal Support Campaign',
'Completed food support campaign for low-income families.',
8000.00,
8000.00,
'Food Support',
'Completed',
'2026-04-01',
'2026-04-30',
24,
3),

(3,
'Completed Education Fundraiser',
'Completed school supplies fundraising campaign.',
5000.00,
5000.00,
'Education',
'Completed',
'2026-03-01',
'2026-03-31',
18,
2),

(3,
'Completed Healthcare Aid',
'Completed medical aid fundraising campaign.',
10000.00,
10000.00,
'Healthcare',
'Completed',
'2026-02-01',
'2026-02-28',
30,
5);
-- Create Database (if not exists)
IF NOT EXISTS (SELECT name FROM master.sys.databases WHERE name = N'PARKIR_V1_Sept2026')
BEGIN
    CREATE DATABASE [PARKIR_V1_Sept2026];
END
GO

USE [PARKIR_V1_Sept2026];
GO

-- Create Users Table
IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='users' and xtype='U')
BEGIN
    CREATE TABLE users (
        id INT IDENTITY(1,1) PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT GETDATE()
    );
END
GO

-- Insert default admin user (password is md5 of 'admin' -> '21232f297a57a5a743894a0e4a801fc3')
IF NOT EXISTS (SELECT * FROM users WHERE email = 'admin@smartpark.com')
BEGIN
    INSERT INTO users (name, email, password) 
    VALUES ('Andi', 'admin@smartpark.com', '21232f297a57a5a743894a0e4a801fc3');
END
GO

-- Create Parking Transactions Table
IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='parking_transactions' and xtype='U')
BEGIN
    CREATE TABLE parking_transactions (
        id INT IDENTITY(1,1) PRIMARY KEY,
        receipt_number VARCHAR(50) NOT NULL UNIQUE,
        plate_number VARCHAR(20) NOT NULL,
        time_in DATETIME NOT NULL,
        time_out DATETIME NULL,
        photo_in VARCHAR(255) NULL,
        photo_out VARCHAR(255) NULL,
        operator_id INT NOT NULL,
        total_fare DECIMAL(10,2) NULL,
        created_at DATETIME DEFAULT GETDATE(),
        CONSTRAINT FK_Parking_Operator FOREIGN KEY (operator_id) REFERENCES users(id)
    );
END
GO

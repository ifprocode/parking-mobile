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
        role VARCHAR(20) DEFAULT 'operator',
        created_at DATETIME DEFAULT GETDATE()
    );
END
GO

-- Add role column to existing table if it does not exist
IF COL_LENGTH('users', 'role') IS NULL
BEGIN
    ALTER TABLE users ADD role VARCHAR(20) DEFAULT 'operator';
END
GO

-- Insert default admin user (password is md5 of 'admin' -> '21232f297a57a5a743894a0e4a801fc3')
IF NOT EXISTS (SELECT * FROM users WHERE email = 'admin@ifpro.id')
BEGIN
    INSERT INTO users (name, email, password, role) 
    VALUES ('Andi', 'admin@ifpro.id', '21232f297a57a5a743894a0e4a801fc3', 'admin');
END
GO

-- Insert default operator user
IF NOT EXISTS (SELECT * FROM users WHERE email = 'operator@ifpro.id')
BEGIN
    INSERT INTO users (name, email, password, role) 
    VALUES ('Budi', 'operator@ifpro.id', '21232f297a57a5a743894a0e4a801fc3', 'operator');
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
        tarif_id INT NULL,
        total_fare DECIMAL(10,2) NULL,
        status VARCHAR(20) DEFAULT 'unpaid',
        created_at DATETIME DEFAULT GETDATE(),
        CONSTRAINT FK_Parking_Operator FOREIGN KEY (operator_id) REFERENCES users(id)
    );
END
GO

-- Add tarif_id column if it doesn't exist (for existing tables)
IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('parking_transactions') AND name = 'tarif_id')
BEGIN
    ALTER TABLE parking_transactions ADD tarif_id INT NULL;
END
GO

-- Add status column if it doesn't exist (for existing tables)
IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('parking_transactions') AND name = 'status')
BEGIN
    ALTER TABLE parking_transactions ADD status VARCHAR(20) DEFAULT 'unpaid';
END
GO

-- Create Master Tarif Table
IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='tarifs' and xtype='U')
BEGIN
    CREATE TABLE tarifs (
        id INT IDENTITY(1,1) PRIMARY KEY,
        vehicle_type VARCHAR(50) NOT NULL,
        mode VARCHAR(20) DEFAULT 'progresif',
        flat_fare DECIMAL(10,2) NOT NULL,
        hourly_fare DECIMAL(10,2) NOT NULL,
        updated_at DATETIME DEFAULT GETDATE()
    );
END
GO

-- If table already exists, alter it to remove base_fare and add flat_fare and mode
IF COL_LENGTH('tarifs', 'base_fare') IS NOT NULL
BEGIN
    ALTER TABLE tarifs DROP COLUMN base_fare;
END
GO
IF COL_LENGTH('tarifs', 'flat_fare') IS NULL
BEGIN
    ALTER TABLE tarifs ADD flat_fare DECIMAL(10,2) DEFAULT 0 NOT NULL;
END
GO
IF COL_LENGTH('tarifs', 'mode') IS NULL
BEGIN
    ALTER TABLE tarifs ADD mode VARCHAR(20) DEFAULT 'progresif';
END
GO

-- Insert default tarif for Car
IF NOT EXISTS (SELECT * FROM tarifs WHERE vehicle_type = 'Mobil')
BEGIN
    INSERT INTO tarifs (vehicle_type, mode, flat_fare, hourly_fare) 
    VALUES ('Mobil', 'progresif', 25000, 2000);
END
GO

-- Create App Headers Table
IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='app_headers' and xtype='U')
BEGIN
    CREATE TABLE app_headers (
        id INT IDENTITY(1,1) PRIMARY KEY,
        header_name VARCHAR(100) NOT NULL,
        is_active INT DEFAULT 0,
        updated_at DATETIME DEFAULT GETDATE()
    );
END
GO

-- Insert default app header
IF NOT EXISTS (SELECT * FROM app_headers)
BEGIN
    INSERT INTO app_headers (header_name, is_active) 
    VALUES ('Smart Parking', 1);
END
GO

CREATE DATABASE it_tickets;

USE it_tickets;

CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_submitted DATE,
    requester_name VARCHAR(100),
    department VARCHAR(100),
    contact_info VARCHAR(100),
    request_type VARCHAR(50),
    title VARCHAR(100),
    description TEXT,
    priority VARCHAR(50),
    expected_action TEXT,
    deadline DATE,
    additional_info TEXT,
    status VARCHAR(50),
    iku_achieved VARCHAR(100),
    iku_formula TEXT,
    achievement TEXT,
    comments TEXT,
    technician_name VARCHAR(100),
    completion_date DATE,
    resolution_comments TEXT
);

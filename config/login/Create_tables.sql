Create DATABASE disaster_db;
USE disaster_db;
CREATE TABLE Location(
    loc_id INT AUTO_INCREMENT PRIMARY KEY,
    latitude DECIMAL (10,8),
    longitude DECIMAL (10,8),
    province VARCHAR (50) NOT NULL,
    district VARCHAR (50) NOT NULL,
    street VARCHAR (50) NOT NULL
);
Create TABLE Request(
    req_id INT PRIMARY KEY AUTO_INCREMENT,
    req_name VARCHAR(255) NOT NULL,
    req_type VARCHAR(50) NOT NULL,
    description VARCHAR(256) ,
    contact_number VARCHAR(20) NOT NULL,
    priority VARCHAR(50) ,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50),
    loc_id INT,
    FOREIGN KEY (loc_id) REFERENCES Location(loc_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);


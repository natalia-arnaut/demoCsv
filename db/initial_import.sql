CREATE DATABASE demo;

CREATE TABLE employee(
    id VARCHAR(32) NOT NULL,
    employee VARCHAR(255) NOT NULL,
    distance INTEGER NOT NULL DEFAULT 0,
    weekHours INTEGER NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY employee (employee)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- possible queries
INSERT INTO employee (id, employee, distance, weekHours) VALUES (uuid(), "Paul", 30, 40);
SELECT * FROM employee WHERE employee = "Paul";
SELECT * FROM employee WHERE distance > 10;

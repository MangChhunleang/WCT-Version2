CREATE DATABASE UniversityDB;
USE UniversityDB;

-- Students Table
CREATE TABLE Students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    date_of_birth DATE,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Departments Table
CREATE TABLE Departments (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL
);

-- Faculty Table
CREATE TABLE Faculty (
    faculty_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES Departments(department_id) 
        ON DELETE SET NULL ON UPDATE CASCADE
);

-- Courses Table
CREATE TABLE Courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(10) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    faculty_id INT,
    department_id INT,
    FOREIGN KEY (faculty_id) REFERENCES Faculty(faculty_id) 
        ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (department_id) REFERENCES Departments(department_id) 
        ON DELETE SET NULL ON UPDATE CASCADE
);

-- Enrollments Table (Many-to-Many between Students and Courses)
CREATE TABLE Enrollments (
    enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    grade CHAR(2) CHECK (grade IN ('A', 'B', 'C', 'D', 'F', 'P', 'NP')), -- Example: A, B+, C, etc.
    FOREIGN KEY (student_id) REFERENCES Students(student_id) 
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (course_id) REFERENCES Courses(course_id) 
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- 1. Departments Data
INSERT INTO Departments (name) VALUES
('Computer Science'),
('Mathematics'),
('Physics'),
('Literature'),
('Engineering');

-- 2. Faculty Data
INSERT INTO Faculty (name, email, department_id) VALUES
-- Computer Science
('Dr. Alice Smith', 'alice.smith@university.edu', 1),
('Prof. John Doe', 'john.doe@university.edu', 1),
-- Mathematics
('Dr. Maria Garcia', 'maria.garcia@university.edu', 2),
('Prof. Robert Lee', 'robert.lee@university.edu', 2),
-- Physics
('Dr. Wei Zhang', 'wei.zhang@university.edu', 3),
-- Literature
('Prof. Emily Wilson', 'emily.wilson@university.edu', 4),
-- Engineering
('Dr. James Brown', 'james.brown@university.edu', 5);

-- 3. Courses Data
INSERT INTO Courses (course_code, name, faculty_id, department_id) VALUES
-- Computer Science
('CS101', 'Introduction to Programming', 1, 1),
('CS202', 'Database Systems', 2, 1),
-- Mathematics
('MATH301', 'Linear Algebra', 3, 2),
('MATH205', 'Calculus III', 4, 2),
-- Physics
('PHY150', 'Quantum Mechanics', 5, 3),
-- Literature
('LIT220', 'Modern Poetry', 6, 4),
-- Engineering
('ENG310', 'Thermodynamics', 7, 5);

-- 4. Students Data
INSERT INTO Students (name, email, date_of_birth) VALUES
('Emily Johnson', 'emily.johnson@university.edu', '2000-05-15'),
('Michael Chen', 'michael.chen@university.edu', '1999-11-22'),
('Sarah Williams', 'sarah.williams@university.edu', '2001-03-08'),
('David Kim', 'david.kim@university.edu', '2000-07-30'),
('Jessica Martinez', 'jessica.martinez@university.edu', '2002-01-18'),
('Daniel Brown', 'daniel.brown@university.edu', '1999-09-12'),
('Priya Patel', 'priya.patel@university.edu', '2001-06-30'),
('Mohammed Al-Farsi', 'mohammed.alfarsi@university.edu', '2000-10-11'),
('Ling Zhang', 'ling.zhang@university.edu', '2002-04-22'),
('Robert Johnson', 'robert.johnson@grad.university.edu', '1995-07-19');

INSERT INTO Enrollments (student_id, course_id, grade) VALUES
-- Computer Science enrollments
(1, 1, 'A'),   -- Emily → CS101 (A)
(2, 1, 'B'),   -- Michael → CS101 (B)
(3, 2, 'A'),   -- Sarah → Database Systems (A)
(4, 2, 'C'),   -- David → Database Systems (C)
-- Math enrollments
(5, 3, 'P'),   -- Jessica → Linear Algebra (Pass)
(6, 4, 'B'),   -- Daniel → Calculus III (B)
-- Physics/Literature/Engineering
(7, 5, 'A'),   -- Priya → Quantum Mechanics (A)
(8, 6, 'NP'),  -- Mohammed → Modern Poetry (No Pass)
(9, 7, 'A'),   -- Ling → Thermodynamics (A)
(10, 1, 'B');  -- Robert → Intro to Programming (B)

-- 1. Retrieve all students who enrolled in a specific course
-- Example: Find all students taking 'CS101' (Intro to Programming)
SELECT s.student_id, s.name, s.email, e.grade
FROM Students s
JOIN Enrollments e ON s.student_id = e.student_id
JOIN Courses c ON e.course_id = c.course_id
WHERE c.course_code = 'CS101';

-- 2. Find all faculty members in a particular department.
-- Example: Find all Computer Science faculty
SELECT f.faculty_id, f.name, f.email, d.name AS department
FROM Faculty f
JOIN Departments d ON f.department_id = d.department_id
WHERE d.name = 'Computer Science';

--  3. List all courses a particular student is enrolled in.
-- Example: Find all courses for student_id 3 (Sarah Williams)
SELECT c.course_code, c.name AS course_name, 
       d.name AS department, e.grade
FROM Courses c
JOIN Enrollments e ON c.course_id = e.course_id
JOIN Departments d ON c.department_id = d.department_id
WHERE e.student_id = 3;

--  4. Retrieve students who have not enrolled in any course.
SELECT s.student_id, s.name, s.email
FROM Students s
LEFT JOIN Enrollments e ON s.student_id = e.student_id
WHERE e.enrollment_id IS NULL;

--  5. Find the average grade of students in a specific course.
-- Example: Average grade for 'CS101' (using GPA values)
SELECT 
    c.course_code,
    c.name AS course_name,
    AVG(CASE 
        WHEN e.grade = 'A' THEN 4.0
        WHEN e.grade = 'B+' THEN 3.5
        WHEN e.grade = 'B' THEN 3.0
        WHEN e.grade = 'C+' THEN 2.5
        WHEN e.grade = 'C' THEN 2.0
        WHEN e.grade = 'D+' THEN 1.5
        WHEN e.grade = 'D' THEN 1.0
        ELSE 0.0
    END) AS average_gpa
FROM Courses c
JOIN Enrollments e ON c.course_id = e.course_id
WHERE c.course_code = 'CS101'
GROUP BY c.course_id;


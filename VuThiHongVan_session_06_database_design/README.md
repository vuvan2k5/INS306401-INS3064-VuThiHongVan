# Session 06 – Database Design

## Part 1: Normalization

### Task 1: Identify Violations

The raw table **STUDENT_GRADES_RAW** contains redundancy and several functional dependencies that lead to normalization issues.

Functional dependencies:

- StudentID → StudentName
- CourseID → CourseName
- ProfessorName → ProfessorEmail
- (StudentID, CourseID) → Grade

These dependencies cause:

- **Redundancy:** Student name, course name, and professor information are repeated multiple times.
- **Update anomaly:** If a professor's email changes, it must be updated in multiple rows.
- **Insertion anomaly:** A new course or professor cannot be added unless a student enrolls.
- **Deletion anomaly:** Deleting a student's record may remove course or professor information.

Because of these issues, the table does not satisfy **Third Normal Form (3NF)**.

---

### Task 2: Decompose to 3NF

To eliminate redundancy and anomalies, the table is decomposed into the following tables:

| Table Name | Primary Key | Foreign Key | Normal Form | Description |
| :--- | :--- | :--- | :--- | :--- |
| Students | StudentID | None | 3NF | Stores student information such as student name |
| Professors | ProfessorID | None | 3NF | Stores professor name and email |
| Courses | CourseID | ProfessorID | 3NF | Stores course information and the professor who teaches it |
| Enrollments | (StudentID, CourseID) | StudentID, CourseID | 3NF | Stores student enrollment and the grade received |

This decomposition removes redundancy and ensures the database structure satisfies **Third Normal Form (3NF)**.

---

## Part 2: Relationship Drills

1. **Author – Book**  
Relationship Type: One-to-Many (1:N)  
FK Location: `author_id` in the **Books** table.

2. **Citizen – Passport**  
Relationship Type: One-to-One (1:1)  
FK Location: `citizen_id` in the **Passport** table.

3. **Customer – Order**  
Relationship Type: One-to-Many (1:N)  
FK Location: `customer_id` in the **Orders** table.

4. **Student – Class**  
Relationship Type: Many-to-Many (N:N)  
FK Location: A junction table (e.g., **Student_Class**) containing  
`student_id` and `class_id`.

5. **Team – Player**  
Relationship Type: One-to-Many (1:N)  
FK Location: `team_id` in the **Players** table.
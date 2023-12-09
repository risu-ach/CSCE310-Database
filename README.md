# CSCE310-Database
StartPage: index.php (directs to loginpage.php)        
    Admin_App.php(Admin_App_nav)
        functions_admin.php
        admin_page.php
        program.php
        admin_program.php
        Classes.php
        class_enrollment.php
        intern.php
        intern_app.php
        certificate.php
        cert_enrollment.php
        cc_event.php
        eventtrack.php
    Student_App.php (Student_App_nav)
        functions_student.php
        student_page.php
        Student_App.php
        Student_program.php
        Student_classes.php
        Student_intern.php
        student_certificate.php
        document.php
        update_document.php
    logout.php
Connector:Db.php
ALL Sql Commands to create the initial database : SQLCommands.pdf

Admin Functionalities: 
User Authentication and Roles (Maya)
 Insert: Add new administrators with their respective roles.
 Update: Modify roles or details of existing user types
Select: View a list of all user types along with their roles.
Delete: Remove all user types from the system.
i. In our system, we have two delete types. The first delete is removing
access to the system for a given account. The second is a full delete with
corresponding data.

	Files associated:
        functions_admin.php
        admin_page.php
        loginpage.php
        logout.php
        adminPageScript.js
        styles_admin_page.css
        db.php

Program Information Management (Matthew) 
Insert: Add a new program with its details.
Update: Edit existing programs.
Select: Create a report for each program.
Delete: Remove a program from the system.
Index: An index was implemented for the table of applications. Due to the potential large number of total applications, an index would be useful here to speed up access.

Program Progress Tracking (Rishika) 
 Insert: Record a student's progress within various programs.
Update: Edit a student's progress (e.g., course enrollments, certifications).
 Select: Retrieve progress information for a specific student related to a program.
 Delete: Remove a specific report.
    Files associated:
        Admin_App.php
        Classes.php
        class_enrollment.php
        intern.php
        intern_app.php
        certificate.php
        cert_enrollment.php
        Db.php
        Admin_App_nav.php

Event management (Sarah)
 Insert: Create an event for various programs.
 Update: Edit an event's details, including student attendance information.
 Select: Retrieve information for each event.
 Delete: Remove an event.

    Files associated:
        db.php
        cc_event.php
        eventtrack.php
        update_event.php
        style.css


Student Functionalities: 
User Authentication and Roles (Maya)
 Insert: Create a new student for the tracking system.
 Update: Change login credentials or update personal information.
 Select: Access their own profile information.
 Delete: Deactivate their own account.

    Files associated:
        functions_student.php
        student_page.php
        loginpage.php
        logout.php
        studentPageScript.js
        Styles_student_page.css
        db.php

Application Information Management (Matthew)
 Insert: Submit application forms for various programs.
 Update: Edit application details as needed.
 Select: Review their own application information and status.
 Delete: Remove a program application
View: A view was implemented here. The view displays all the applications a student has submitted.
Program Progress Tracking (Rishika) 
 Insert: Add new progress records (e.g., course enrollments, certifications).
 Update: Edit their own progress records.
 Select: View their own progress within TAMCC's programs.
Delete: Remove a specific progress record.
    Files associated:
        Student_App.php
        Student_classes.php
        Student_intern.php
        student_certificate.php
        Db.php
        Student_App_nav.php

Document Upload and Management (Sarah)
 Insert: Upload resumes and other documents for program opportunities.
 Update: Replace or edit uploaded documents.
 Select: View their uploaded documents.
 Delete: Remove a specific document
    Files associated:
        db.php
        document.php
        update_document.php
        style.css


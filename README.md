# FOCUS: Online Course Ecommerce Platform

## Project Description

FOCUS is an online platform designed to facilitate the creation, purchase, and consumption of educational courses. It serves three primary user types: Administrators, Teachers, and Students, each with specific functionalities tailored to their roles. The platform supports different payment models for courses and includes interactive features like a chat system and course reviews.

## Technologies Used

* **Backend:** PHP
* **Frontend:** JavaScript
* **Database:** MySQL
* **API Integrations:**
    * Microsoft Translator API: For automatic translation within the chat system.
    * VirusTotal API: For file verification of uploaded course content.

## Features

### Core Features

* **Course Creation:** Teachers can create new courses, defining the course title, description, and structure.
* **Flexible Purchasing Options:** Users can purchase entire courses or individual levels within a course.
* **Course Levels:** Teachers can add and organize content within distinct levels for each course.
* **File Uploads:** Teachers can upload helpful files to course levels (files are scanned by VirusTotal upon upload).
* **User Authentication and Authorization:** Secure login and access control based on user roles.
* **Database Management:** Storage of user data, course information, enrollments, comments, and reports.

### User Role Specific Features

#### Administrator

* **Comment Moderation:** Ability to ban comments on any course.
* **Course Category Management:** Create, edit, and delete categories for courses.
* **Platform-Wide Reports:** Access and view reports on user activity, course sales, and other relevant platform metrics.

#### Teacher

* **Course Creation:**
    * Define course details (title, description).
    * Set payment type (full course or level-based).
* **Course Editing:** Modify existing course details and structure.
* **Level Management:** Add, edit or remove levels within their courses.
* **File Management:** Upload and manage helpful files associated with course levels (files are scanned by VirusTotal).

#### Student

* **Course Browse:** View available courses and their details.
* **Course and Level Purchase:** Buy entire courses or specific levels.
* **View Bought Content:** Access courses and levels they have purchased.
* **Commenting:** Leave comments on a course after completing it.
* **Course Ranking:** Rate completed courses on a scale of 0 to 5.

### Communication System

* **Teacher-Student Chat:** A real-time chat system allowing students to communicate with teachers before and after purchasing a course.
* **Automatic Translation:** Integrated button in the chat to translate messages to English using the Microsoft Translator API.

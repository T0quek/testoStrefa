# TestoStrefa E-Learning Platform

TestoStrefa is an innovative web-based e-learning platform designed to facilitate knowledge verification and learning for students, teachers, and learners of all ages. Built with Laravel 11 and Livewire, the application follows the MVC architecture, ensuring a clear separation of business logic, data management, and user interface.

## Features

- **User Roles**:
    - *Students*: Create and complete custom tests using accessible question sets.
    - *Teachers*: Create question sets, edit questions, and generate access tokens for students.
- **Dynamic Exam System**:
    - Multiple question types: Single choice, multiple choice, text inputs, and gap-fill exercises.
    - Real-time feedback for answers during tests.
    - Test summaries including scores, detailed question reviews, and correctness breakdowns.
- **User Management**:
    - Registration with email verification and secure password validation.
    - Password reset functionality with time-sensitive reset links.
    - Profile management for updating personal data.
- **Authorization & Tokens**:
    - Teachers can generate unique access tokens for granting students permissions to specific resources.
- **Database**:
    - Managed with Laravel migrations for structured and version-controlled data handling.
    - Relational database design optimized for storing exams, questions, and user data.

## Technologies

- **Backend**: PHP (Laravel 11)
- **Frontend**: Blade templates, Livewire components, Bootstrap v.5.3, TailwindCSS
- **Database**: MariaDB
- **Other Tools**: reCAPTCHA v3, node.js

## Availabity
- Hosted on [testoStrefa.pl](https://testostrefa.pl)

## Planned Features

- Priority-based question selection for exams.
- Built-in communication tools for teachers and students.
- Class creation to manage teacher-student groups.
- Change te way to store questions (instead of JSON arrays)
- Cache managment system

Explore the project and contribute to the development of this user-friendly and feature-rich e-learning platform!

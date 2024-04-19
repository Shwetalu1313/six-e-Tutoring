# Six-eTutoring System

## Overview
The Six-eTutoring System is a web application developed using Laravel and MySQL, designed to facilitate online tutoring services. This system enables efficient scheduling, activity tracking, tutor allocation, user registration, blog management, account moderation, and reporting functionalities. 

This project was developed by the **Creative Builders** group as part of a collaborative effort.

## Features
- **Scheduling:** Users can view and manage schedules through a calendar interface. They can also share schedules with other users.
- **Activity Tracking:** The system tracks user activity to provide insights into user engagement and progress.
- **Browser Tracking:** Monitors user activity within the application for enhanced analytics and user experience.
- **Tutor Allocation:** Enables bulk allocation and deallocation of tutors to students.
- **User Registration:** Authorised users can register new users and send registration emails.
- **Blog Management:** Users can upload blog posts, attach files, and interact with posts through comments and reactions.
- **Account Moderation:** Authorised staff members can ban accounts as necessary and modify user accounts.
- **Reporting:** Provides static reports for authorised users and teachers.

## Usage

Before starting, ensure that your machine has PHP installed, with a minimum version of 8.2^.

Follow these steps to set up and run the Six-eTutoring System:

1. **Download or Clone the Repository:**
    - Download the repository ZIP file or clone it using Git to a specific folder on your machine.

2. **Navigate to the Project Folder:**
    - Open your command prompt (CMD) or terminal and change directory to the folder where you downloaded or cloned the repository.

3. **Install Dependencies:**
    - Run the following command to install the required dependencies:
      ```
      composer install
      ```

4. **Run Migration and Seed Database:**
    - Execute database migrations to create the necessary tables:
      ```
      php artisan migrate
      ```
    - Optionally, seed the database with sample data:
      ```
      php artisan db:seed
      ```

5. **Start the Development Server:**
    - Launch the Laravel development server by running the following command:
      ```
      php artisan serve
      ```

6. **Access the Application:**
    - Once the server is running, open your web browser and navigate to `http://localhost:8000` to access the Six-eTutoring System.

That's it! You're now ready to use the Six-eTutoring System on your local machine.


## Tools

The Six-eTutoring System utilizes a variety of technologies to deliver its features and functionality. Here's a breakdown of the key tools and technologies used:

- **HTML (Bootstrap):**
  - HTML is the standard markup language for creating web pages.
  - Bootstrap is a popular front-end framework for building responsive and mobile-first websites. It provides pre-designed templates and components for easy and efficient web development.

- **CSS and SCSS:**
  - CSS (Cascading Style Sheets) is used to style the visual presentation of web pages.
  - SCSS (Sassy CSS) is a CSS preprocessor that extends the functionality of CSS with features like variables, nesting, and mixins, making CSS code more maintainable and scalable.

- **JavaScript (jQuery):**
  - JavaScript is a programming language that enables interactive and dynamic behavior on web pages.
  - jQuery is a fast and concise JavaScript library that simplifies HTML document traversing, event handling, animating, and Ajax interactions for rapid web development.

- **PHP (Laravel):**
  - PHP is a server-side scripting language used for web development.
  - Laravel is a PHP web application framework known for its elegant syntax, expressive and intuitive syntax, and developer-friendly features. It provides tools and utilities for tasks such as routing, authentication, database management, and more.

- **MySQL:**
  - MySQL is an open-source relational database management system (RDBMS) used for storing and managing data in the Six-eTutoring System. It provides a robust and scalable solution for data storage and retrieval.

By leveraging these technologies, the Six-eTutoring System delivers a powerful and user-friendly platform for online tutoring services, offering features such as scheduling, activity tracking, user management, and more.


## License
[Information about the license under which the project is distributed, e.g., MIT License]

## Copyright
© 2024 Creative Builder Group. All rights reserved.

## Support
[Information about how users can get support or report issues]

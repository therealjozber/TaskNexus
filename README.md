# TaskNexus

TaskNexus is a modern, responsive web application for intelligent task management and efficiency tracking. Built with PHP, MySQL, HTML, CSS, and JavaScript, it provides a secure and intuitive interface for managing tasks and projects.

## Features

- Secure user authentication system
- Task creation, editing, and deletion
- Priority, effort, and urgency-based task organization
- Task status tracking (pending, in progress, completed, delayed)
- Efficiency metrics and insights dashboard
- Responsive design for all devices
- Modern and intuitive user interface

## Project Structure

```
TaskNexus/
├── assets/
│   ├── css/
│   │   └── styles.css
│   └── js/
│       └── main.js
├── config/
│   └── database.php
├── includes/
│   ├── auth_check.php
│   └── db_operations.php
├── pages/
│   ├── dashboard.php
│   ├── task-composer.php
│   ├── edit-task.php
│   ├── delete-task.php
│   ├── insights.php
│   ├── login.php
│   ├── logout.php
│   └── register.php
└── README.md
```

## Getting Started

1. Clone the repository
2. Set up a local web server (e.g., Apache, XAMPP, WAMP)
3. Configure the database connection in `config/database.php`
4. Import the database schema
5. Access the application through your web server

## Technologies Used

- PHP 7.4+
- MySQL/MariaDB
- HTML5
- CSS3
- JavaScript (ES6+)
- Session-based authentication

## Features in Detail

### User Management
- Secure registration with password hashing
- Login/logout functionality
- Session-based authentication
- User profile management

### Task Management
- Create new tasks with title, description, and metadata
- Edit existing tasks
- Delete tasks
- Set task priorities (high, medium, low)
- Define effort levels (high, medium, low)
- Set urgency levels (high, medium, low)
- Assign due dates
- Track task status

### Dashboard
- Overview of active assignments
- Efficiency score calculation
- Delayed tasks tracking
- Recent tasks list with quick actions

### Insights
- Task completion rate analytics
- Task distribution statistics
- Status overview with percentage breakdowns
- Export functionality (PDF, Excel, PNG)
- Filterable data views

## Security Features

- Password hashing using PHP's password_hash()
- Prepared SQL statements to prevent SQL injection
- Session-based authentication
- Input validation and sanitization
- CSRF protection
- Secure password requirements (minimum 8 characters)

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.
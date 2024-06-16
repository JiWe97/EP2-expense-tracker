# EP2 Expense Tracker

Welcome to the EP2 Expense Tracker project! This application helps users track and manage their expenses effectively. It provides a user-friendly interface for recording, categorizing, and analyzing financial transactions.

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Usage](#usage)
- [Mailables](#mailables)
- [Contributing](#contributing)

## Features

- **User Authentication**: Secure login and registration system.
- **Expense Tracking**: Add, edit, and delete expenses.
- **Categories**: Organize expenses by customizable categories.
- **Reporting**: View detailed reports and charts on spending habits.

## Technologies Used

- **Laravel**: A PHP framework used for building the backend of the application.
- **Livewire**: A full-stack framework for Laravel that makes building dynamic interfaces simple, without leaving the comfort of Laravel.
- **MySQL**: A relational database management system used to store user and expense data.
- **Tailwind CSS**: A utility-first CSS framework used for designing the user interface.
- **Alpine.js**: A minimal JavaScript framework used for interactive components.

## Installation

To set up this project locally, follow these steps:

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/JiWe97/EP2-expense-tracker.git
   cd EP2-expense-tracker
   ```

2. **Install Dependencies**:
   Make sure you have [Composer](https://getcomposer.org/) installed. Then, run:
   ```bash
   composer install
   npm install
   npm run dev
   ```

3. **Set Up Environment Variables**:
   Copy the example environment file and set your configurations.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database**:
   Update your `.env` file with your database credentials. Then, run the migrations:
   ```bash
   php artisan migrate
   ```

5. **Serve the Application**:
   Start the local development server:
   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000` in your browser to see the application.

## Usage

Once the application is set up, you can register a new user, log in, and start tracking your expenses. You can add new expenses, categorize them, and view reports to analyze your spending habits.

## Mailables

This project includes the use of Laravel Mailables for sending emails. Mailables are used to send notifications, such as:

- **Expense Reports**: Users can receive periodic summaries of their expenses via email.
- **Notifications**: Alerts for unusual spending patterns or reminders to log expenses.

To configure mail settings, update the mail configuration in your `.env` file:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```
Make sure to replace the placeholder values with your actual mail server credentials.

## Contributing

We welcome contributions to improve this project! To contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes and commit them (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Open a pull request.

Please make sure to update tests as appropriate.


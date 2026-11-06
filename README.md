# CipherNote

A secure, private digital journal application that allows users to store and manage their personal notes with authentication.

## 🚀 Features

- **User Authentication**: Secure registration and login system.
- **Password Security**: Uses `password_verify` and hashing for secure credential storage.
- **Private Journaling**: A dedicated space for users to write and manage their secret notes.
- **Database Integration**: Powered by MySQL via PDO for reliable data management.

## 🛠️ Tech Stack

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript

## 📁 Project Structure

- `api.php`: Handles backend requests and data processing.
- `functions.php`: Core utility functions for database connectivity and user management.
- `journal.php`: The main interface for viewing and creating notes.
- `login.php` / `register.php`: Authentication entry points.
- `css/` & `JS/`: Styling and client-side interactivity.

## ⚙️ Installation

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   ```

2. **Database Setup**:
   - Create a MySQL database.
   - Ensure you have a `users` table with the following columns: `id_user`, `nom`, `prenom`, `email`, and `pwd`.

3. **Configuration**:
   - Update the database credentials in `functions.php` (or your configuration file) to match your local environment.

4. **Run the app**:
   - Move the project folder to your server directory (e.g., `htdocs` for XAMPP).
   - Access the application via `http://localhost/note_secret`.

## 🔒 Security Note

This project implements basic password hashing. For production environments, ensure you use SSL/HTTPS and further sanitize all user inputs to prevent XSS and other vulnerabilities.

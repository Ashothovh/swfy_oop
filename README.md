# PHP SWFY Tech Task (Pure PHP, No Frameworks)

This is a **pure PHP web application** implementing an authentication system with **login, user roles, and an API endpoint**.

## Features
- ✅ User **Login & Logout**
- ✅ User **Roles & Permissions** / used middleware
- ✅ No any framework
- ✅ Uses **Object-Oriented Programming (OOP)** 
- ✅ **Database Integration (MySQL)**
- ✅ **Autoloading** via **Composer**

---

## 📂 Installation

### Clone the repository
```bash
git clone https://github.com/Ashothovh/swfy_oop.git
cd swfy_oop
composer install
create a database "swfy"
Import the database.sql file:
```
## Endpoints
### POST /api/register  / body: {"name": "Steve", "email": "steve@example.com", "password": "steve123!"}
### POST /api/login     / body: {"email": "jobs@example.com", "password": "password123"}  / HEADERS: Content-Type: application/json
### POST /api/logout 
### GET /api/admin      
### GET /api/user       

## Features
### 1. **User Login**
URL: /api/login
Method: POST
Headers: Content-Type: application/json
Request Body:
```bash
{
    "email": "jobs@example.com",
    "password": "password123"
}
```
### Response:
✅ 200 OK (Login successful)
```bash
{
    "message": "Login successful",
    "user": {
        "id": 1,
        "name": "Steve Jobs",
        "email": "steve@example.com",
        "role": "admin",
        "created_at": "2025-03-13 10:00:00"
    }
}
```
Or
❌ 401 Unauthorized (Invalid credentials)
```bash
{
    "error": "Invalid credentials"
}
```



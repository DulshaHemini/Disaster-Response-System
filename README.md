# 🚨 Disaster Response Coordination System (DRCS)

A web-based platform designed to connect disaster-affected people with volunteers and organizations in real time.  
This system helps coordinate emergency responses for floods, landslides, and other natural disasters by automating request handling, prioritization, and resource allocation.

---

## 🌍 Project Overview

Natural disasters often create chaos where help exists, but coordination doesn’t.  
DRCS acts as a **central command bridge** between:

- 🧍 Affected People
- 🙋 Volunteers / Organizations
- 🛠️ Administrators

The system ensures **faster response times**, **fair resource distribution**, and **real-time tracking** of relief efforts.

---

## 🏗️ Architecture

This project follows the **MVC (Model-View-Controller)** architecture:

- **Model** → Handles database logic (MySQL)
- **View** → Frontend UI (HTML, CSS, JS)
- **Controller** → Business logic & request handling (PHP)

```
project-root/
│
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
│
├── public/
│   ├── assets/
│   └── index.php
│
├── config/
│   └── database.php
│
├── routes/
│   └── web.php
│
└── README.md
```

---

## ⚙️ Tech Stack

- 🎨 Frontend: HTML, CSS, Vanilla JavaScript
- 🧠 Backend: PHP
- 🗄️ Database: MySQL
- 🖥️ Server: XAMPP (Apache)

---

## ✨ Features

### 🔐 Authentication
- Role-based registration (Volunteer / Affected People)
- Secure login using PHP sessions
- Admin managed separately

### 🆘 Help Request System
- Submit emergency requests (food, shelter, medical)
- Instant request option (no login required)
- Real-time request tracking

### 📦 Resource Management
- Volunteers can manage available resources
- Dynamic inventory updates
- Task acceptance/rejection system

### 🤖 Automated Assignment
- Smart matching based on:
  - 📍 Location
  - 📊 Resource availability
  - ⚠️ Priority level

Priority Levels:
- 🔴 Critical (Medical)
- 🟠 Medium (Families)
- 🟢 Normal

### 🛠️ Admin Panel
- Monitor all system activities
- Override assignments
- Manage users and resources
- View analytics & reports

### 🌐 Public Interface
- View ongoing relief activities
- System statistics
- Encourage volunteer participation

---

## 🗃️ Database Design

Main Entities:

- `users` → All system users with roles
- `locations` → Address + GPS (latitude, longitude)
- `requests` → Help requests with status & priority
- `resources` → Volunteer resource inventory
- `assignments` → Mapping between requests & volunteers

---

## 🚀 Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/drcs.git
   ```

2. Move project to XAMPP `htdocs`:
   ```
   C:/xampp/htdocs/drcs
   ```

3. Start Apache & MySQL from XAMPP

4. Create database:
   - Open phpMyAdmin
   - Create database: `DRCS`
   - Import SQL file (if available)

5. Configure database connection:
   ```
   config/database.php
   ```

6. Run in browser:
   ```
   http://localhost/drcs/public
   ```

---

## 👥 Team Contribution

All members contributed to:
- Frontend development
- JavaScript functionality
- PHP backend logic
- Database design & integration

### Module Responsibilities

| Module | Area | Description |
|------|------|------------|
| Module 1 | Public & Auth | Home, Register, Login, Instant Request |
| Module 2 | User Pages | Requests, Resources, Task Handling |
| Module 3 | Admin & Logic | Dashboard, Automation, Control |

---

## 🧪 Testing

- Unit testing for each module
- Integration testing across modules
- Simulated disaster scenarios for real-world validation

---

## 🎯 Project Goals

- Reduce response time during disasters
- Improve coordination between stakeholders
- Ensure fair and efficient resource allocation
- Provide transparency via public interface

---

## 📌 Future Improvements

- 📱 Mobile responsive enhancements
- 🌍 Live map integration (Google Maps API)
- 🔔 Real-time notifications
- ☁️ Cloud deployment (AWS)

---

## 📄 License

This project is developed for academic purposes.

---

## 💡 Final Note

Think of this system as a **digital rescue nerve center** —  
where every click could mean faster help, and every request finds its responder.

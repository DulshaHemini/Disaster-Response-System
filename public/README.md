# DRCS – Disaster Response Coordination System

A PHP web application built with MVC architecture for coordinating disaster response operations in Sri Lanka.

## 📁 Project Structure

```
project/
├── index.php                      # Front controller (entry point)
├── app/
│   ├── controllers/
│   │   └── HomeController.php     # Handles home page logic
│   ├── models/
│   │   └── DashboardModel.php     # Provides dashboard data
│   └── views/
│       ├── layouts/
│       │   └── main.php           # Main HTML layout wrapper
│       └── home/
│           ├── index.php          # Main view (assembles components)
│           ├── _navbar.php        # Navigation bar component
│           ├── _ticker.php        # Alert ticker component
│           ├── _hero.php          # Hero section component
│           ├── _dashboard.php     # Dashboard KPIs & map component
│           ├── _needs.php         # Resource needs component
│           ├── _analysis.php      # Analysis charts component
│           ├── _vision.php        # Vision & mission component
│           ├── _footer.php        # Footer component
│           └── _modal.php         # Modal overlay component
└── public/
    ├── css/
    │   └── style.css              # All styles (external)
    └── js/
        └── main.js                # All JavaScript (external)
```

## 🚀 Getting Started

### Prerequisites
- PHP 7.4 or higher
- Web server (Apache, Nginx, or PHP built-in server)
- Modern web browser

### Installation

1. **Clone or download** this project to your web server directory (e.g., `htdocs` for XAMPP)

2. **Configure your web server** to point to the project root directory

3. **Access the application** via your browser:
   ```
   http://localhost/your-project-folder/
   ```

### Using PHP Built-in Server

For quick testing, you can use PHP's built-in server:

```bash
cd /path/to/project
php -S localhost:8000
```

Then visit: `http://localhost:8000`

## 🏗️ MVC Architecture

### Model (Data Layer)
- **DashboardModel.php**: Provides all data for the dashboard
  - KPI metrics
  - Live alerts
  - Resource needs
  - Analysis data
  - Emergency contacts

In a production app, these methods would fetch data from a database.

### View (Presentation Layer)
- **layouts/main.php**: HTML wrapper with `<head>` and external CSS/JS links
- **home/index.php**: Assembles all page components
- **home/_*.php**: Reusable view components (navbar, hero, dashboard, etc.)

Views use PHP to loop through data and render HTML with proper escaping.

### Controller (Logic Layer)
- **HomeController.php**: 
  - Fetches data from the model
  - Passes data to views
  - Renders the final page

## 🎨 Styling

All CSS is in `public/css/style.css`:
- CSS custom properties for theming
- Responsive grid layouts
- Animations and transitions
- Mobile-first responsive design

## 📜 JavaScript

All JavaScript is in `public/js/main.js`:
- Scroll reveal animations
- Language switcher
- Modal system (sign in, sign up, instant help)
- Smooth scrolling

## 🔧 Extending the Application

### Adding a New Page

1. **Create a controller** in `app/controllers/`:
   ```php
   <?php
   class AboutController {
       public function index() {
           // Your logic here
       }
   }
   ```

2. **Create views** in `app/views/about/`:
   ```
   app/views/about/index.php
   ```

3. **Access via URL**:
   ```
   http://localhost/?controller=about&action=index
   ```

### Adding a Model

Create a new file in `app/models/`:
```php
<?php
class YourModel {
    public function getData() {
        // Fetch from database
        return [];
    }
}
```

### Database Integration

To connect to a database:

1. Create `app/config/database.php`:
   ```php
   <?php
   $host = 'localhost';
   $db   = 'drcs';
   $user = 'root';
   $pass = '';
   
   try {
       $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   } catch (PDOException $e) {
       die('Database connection failed: ' . $e->getMessage());
   }
   ```

2. Update models to use `$pdo` for queries

## 🌐 Features

- ✅ **MVC Architecture**: Clean separation of concerns
- ✅ **Component-Based Views**: Reusable PHP view components
- ✅ **External CSS & JS**: All styles and scripts in separate files
- ✅ **Responsive Design**: Mobile, tablet, and desktop support
- ✅ **Smooth Animations**: Scroll reveals and transitions
- ✅ **Modal System**: Sign in, sign up, and emergency help modals
- ✅ **Multi-Language Support**: Sinhala, English, Tamil (UI ready)
- ✅ **Live Dashboard**: KPIs, alerts, maps, and analytics

## 📝 Notes

- The original `Home .html` file is preserved for reference
- All data is currently static (from the model) – connect to a database for dynamic data
- Form submissions are stubbed – implement authentication logic in a new `AuthController`
- The map visual is a placeholder – integrate a real mapping library (Leaflet, Google Maps) as needed

## 🔐 Security Considerations

- All user input is escaped with `htmlspecialchars()` in views
- Controller/action names are sanitized with regex
- Use prepared statements when adding database queries
- Implement CSRF protection for forms
- Add input validation in controllers
- Use HTTPS in production

## 📄 License

This project is provided as-is for educational and development purposes.

---

**Built with ❤️ for disaster response coordination in Sri Lanka**

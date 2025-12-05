Car Reservation 🚗

Car Reservation is a web application for car rental/reservation built with PHP, MySQL (via PDO), HTML, CSS and JavaScript. It offers a user-friendly interface for both clients and administrators, allowing clients to browse available cars and make reservations, and administrators to manage cars and view or delete reservations.

📦 Technologies & Stack

Backend: PHP (with PDO)

Database: MySQL (via phpMyAdmin)

Frontend: HTML5, CSS3, JavaScript

Structure: Modular with MVC-inspired separation (controllers, views, config)

Session & Authentication: Simple login system with role-based access (client vs admin)

🧩 Features
For Clients

Register / Login.

Browse list of cars, filtered by brand (marque) and availability dates.

Reserve a car for a chosen date range (with overlap checks—car must not already be reserved for these dates).

Receive a confirmation message after successful reservation.

For Administrators

Login with admin privileges.

View full list of cars.

Add, edit, or delete cars.

Search/filter cars by brand and availability status.

Delete cars (and optionally clear associated reservations).

🔄 Reservation Logic & Database Design

Two main tables: voiture and reservation.

voiture stores car info (brand, model, year, registration number, etc.).

reservation stores reservations (start date, end date, references to voiture and user).

Reservation conflict prevention: a car can only be reserved for a date range if there is no existing reservation overlapping that range.

Auto-increment IDs, foreign keys, and relational integrity between cars, reservations, and users.

📂 Project Structure (partial)
/config         – database configuration, initialization  
/controllers   – business logic (auth, CRUD, reservation)  
/views         – HTML/PHP pages (login, register, list, admin, dashboards)  
/public/css    – shared stylesheet (style.css)  
/public/js     – JS functions (modals, form validation)  

🚀 Installation & Setup

Clone the repository:

git clone https://github.com/Med-Slimen/Gestion_Voitures.git


Import the database structure using phpMyAdmin (or MySQL shell).

Create a database (e.g. gestion_voitures)

Create tables voiture, reservation, user, etc. with correct schema (IDs, foreign keys).

Update config/db.php (or init.php) with your database credentials (host, user, password, database name).

Ensure your web server (Apache / Nginx / XAMPP) document root points to the project folder.

Access the application via browser. Register or login, and enjoy managing/reserving cars.

✅ Usage & Workflow

As a client: register → login → search cars by brand or date → reserve an available car → get confirmation message.

As an admin: login with admin privilege → add / edit / delete cars → manage fleet and availability.

🛡️ Notes & Considerations

The reservation logic disallows overlapping bookings for the same car.

The “availability” field in voiture is used for simple, quick availability checks — but real availability is determined at reservation time via date-overlap logic.

All user inputs are handled using prepared statements (PDO) to avoid SQL injection.

Session-based authentication ensures that only logged-in users can reserve, and only admins can manage cars.

📈 Future Improvements

Possible next steps to enhance the project:

Add user profile management (view reservations, cancel, history).

Send email notifications upon successful reservation (requires mail setup).

Add an admin dashboard with statistics (total cars, reserved cars, upcoming reservations).

Add file upload for car images and display them in the car list.

Improve UI/UX: better styling, responsive design, animations, modals, etc.

Implement pagination for long lists.

Add data validation & sanitation (client- and server-side).

📝 License & Author

Author: Mohamed Amine Slimene
Project created as a learning exercise in web development using PHP/MySQL and to build a functional car-rental prototype.

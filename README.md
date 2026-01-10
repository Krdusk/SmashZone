# SmashZone  
## Badminton Court Scheduling and Reservation System

SmashZone is a web-based badminton court reservation system designed to simplify court booking for customers while giving administrators full control over court management, reservations, and reporting. The system ensures secure access, role-based dashboards, and conflict-free scheduling.

---

## Table of Contents
1. [Project Overview](#project-overview)  
2. [Project Members](#project-members)  
3. [System Technologies](#system-technologies)  
4. [System Features](#system-features)  
5. [User Types and Access Control](#user-types-and-access-control)  
6. [Authentication Flow](#authentication-flow)  
7. [Customer Panel](#customer-panel)  
8. [Admin Panel](#admin-panel)  
9. [Database Design](#database-design)  
10. [Database Relationships](#database-relationships)  
11. [Double Booking Prevention](#double-booking-prevention)  
12. [Setup and Installation](#setup-and-installation)  
13. [Future Enhancements](#future-enhancements)  

---

## Project Overview

SmashZone’s Badminton Court Scheduling and Reservation System is a centralized platform that allows customers to reserve badminton courts online while enabling administrators to manage courts, reservations, users, and reports efficiently. The system is designed with role-based access control to ensure that users only access features appropriate to their role.

---

## Project Members

**Head:**  
- Santos, Samantha Lui A.

**Members:**  
- Amio, John Carlson  
- Castro, James Adrian  
- Cinco, Michaela  
- Tarlac, Carlo Jose  

---

## System Technologies

The system uses the following technologies:  
- MySQL database for storing user, court, and reservation data.  
- HTML, CSS, and JavaScript for the user interface.  
- Backend logic using PHP, Java, or Node.js.  
- Role-based access control for differentiating administrative and customer access.  

---

## System Features

The system provides the following features:  
- Online badminton court reservations.  
- Secure user authentication.  
- Role-based dashboards for customers and administrators.  
- Real-time court availability checking.  
- Prevention of double-booking.  
- Administrative management and reporting.  
- Scalable database design.  

---

## User Types and Access Control

The system has two main classifications of users:

**Customer**  
- Normal system user.  
- Can register and log in.  
- Can reserve badminton courts.  
- Can view and manage only their own reservations.  

**Admin**  
- Business owner or authorized staff.  
- Uses pre-created accounts.  
- Has full access to system management.  
- Can view, approve, and manage all reservations.  

User roles are determined using the `role` field stored in the database.  

---

## Authentication Flow

The system verifies user roles using the following process:  
1. User logs in using their email address and password.  
2. The backend validates credentials against the Users table.  
3. If login is successful, the system reads the `role` column.  
4. Users are redirected based on their role:  
   - Admin users are directed to the Admin Dashboard.  
   - Customer users are directed to the Customer Dashboard.  

Customers cannot access admin pages even if they know the URL. Admin pages are fully secured through role verification.  

---

## Customer Panel

**Registration Page**  
- Customers provide their full name, email address, password, and phone number.  
- Only customers can register through this page.  

**Login Page**  
- Email address and password.  
- The same login page is used by both customers and administrators.  

**Customer Dashboard**  
- View available badminton courts.  
- See court prices per hour.  
- Quick access to court reservation.  

**Court Reservation Page**  
- Select a court and reservation date.  
- Select start and end time.  
- Review total hours and total price.  
- Confirm reservation.  
- The system checks for time conflicts before confirming.  

**My Reservations Page**  
- View unique reservation ID, court name, date, time, and status.  
- Option to cancel reservation.  
- Customers can only view their own reservations.  

**Logout**  
- Ends the user session securely.  

---

## Admin Panel

**Admin Dashboard Summary**  
- Total number of courts.  
- Total number of bookings.  
- Pending bookings.  
- Bookings for the current day.  
- Estimated revenue.  

**Court Management**  
- Add, edit, or disable courts.  
- Set hourly rates.  

**Reservation Management**  
- View all reservations.  
- Filter reservations by date or court.  
- Approve or disapprove bookings.  
- View customer details.  

**Reports Module**  
- Daily and monthly reservation reports.  
- Revenue summaries.  
- Peak booking hour analysis.  

**User Management (Optional)**  
- View all registered users.  
- Identify frequent users.  

**Logout**  
- Securely ends the admin session.  

---

## Database Design

**Database Name:** `smashzone_db`  

**Users Table**  
- `user_id` (Primary Key)  
- `full_name`  
- `email_address`  
- `password`  
- `role` (admin or customer)  

**Courts Table**  
- `court_id` (Primary Key)  
- `court_name`  
- `court_price_per_hour`  
- `court_status`  

**Reservations Table**  
- `reservation_id` (Primary Key)  
- `user_id` (Foreign Key)  
- `court_id` (Foreign Key)  
- `start_time`  
- `end_time`  
- `total_hours`  
- `total_amount`  
- `reservation_status`  

**Add Ons Table**  
- `addon_id` (Primary Key)  
- `addon_name`  
- `price`  

**Reservation Add Ons Table**  
- `reservation_id` (Foreign Key)  
- `addon_id` (Foreign Key)  

---

## Database Relationships

- One user can have many reservations.  
- One court can have many reservations.  
- One reservation can have many add-ons.  

These relationships ensure data integrity, scalability, and efficient querying.  

---

## Double Booking Prevention

The system prevents double booking by:  
- Checking court availability for selected time slots.  
- Validating overlapping start and end times.  
- Rejecting reservations with scheduling conflicts.  

This guarantees accurate and conflict-free bookings.  

---

## Setup and Installation

1. Clone the repository:  
```bash
git clone <repository_url>

---

## Future Enhancements

The following improvements are planned for future versions of SmashZone:

1. **Online Payment Integration**  
   - Allow customers to pay for their reservations directly online.  
   - Support multiple payment methods including credit/debit cards and e-wallets.  

2. **Email and SMS Notifications**  
   - Send automatic confirmation emails or SMS when a reservation is made, approved, or cancelled.  
   - Notify customers before their reservation start time.  

3. **Court Rating and Feedback System**  
   - Enable customers to rate courts and provide feedback.  
   - Help administrators monitor court quality and customer satisfaction.  

4. **Mobile-Responsive Design**  
   - Ensure the web interface works seamlessly on tablets and smartphones.  
   - Improve accessibility and usability for all devices.  

5. **Waitlist System for Fully Booked Courts**  
   - Allow customers to join a waitlist if the desired court/time is unavailable.  
   - Automatically notify customers if a slot becomes available.  

6. **Analytics and Reporting Enhancements**  
   - Provide administrators with visual dashboards to monitor booking trends.  
   - Include advanced reports such as revenue projections, peak hours, and customer statistics.  

7. **User Activity Tracking**  
   - Track frequent customers and their preferences.  
   - Provide insights to optimize scheduling and promotions.  

8. **Additional Add-ons and Services**  
   - Include more optional services like coaching sessions or equipment rentals.  
   - Integrate these add-ons into the reservation and billing system.  

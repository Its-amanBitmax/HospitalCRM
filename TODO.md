# Employee Login and Role-Based Dashboard Implementation

## Tasks to Complete

### 1. Create EmployeeAuthController
- [ ] Create app/Http/Controllers/EmployeeAuthController.php
- [ ] Implement login method with employee_code and password validation
- [ ] Implement logout method
- [ ] Implement dashboard method with role-based redirection

### 2. Update Routes
- [ ] Add employee authentication routes in routes/web.php
- [ ] Add employee dashboard routes
- [ ] Add middleware protection for employee routes

### 3. Update Employee Model
- [ ] Implement Laravel authentication interfaces
- [ ] Add authentication methods (getAuthIdentifier, etc.)
- [ ] Ensure password hashing works correctly

### 4. Create Employee Login View
- [ ] Create resources/views/employee/login.blade.php
- [ ] Style similar to admin login but for employees
- [ ] Form with employee_code and password fields

### 5. Create Role-Based Dashboard Views
- [ ] Create resources/views/employee/dashboard.blade.php (base)
- [ ] Create resources/views/employee/doctor-dashboard.blade.php
- [ ] Create resources/views/employee/nurse-dashboard.blade.php
- [ ] Add role-specific content and navigation

### 6. Create Employee Authentication Middleware
- [ ] Create app/Http/Middleware/EmployeeAuth.php
- [ ] Register middleware in app/Http/Kernel.php

### 7. Update Employee Model for Authentication
- [ ] Ensure Employee model implements proper authentication interfaces
- [ ] Add guard configuration if needed

### 8. Test Implementation
- [ ] Test login with different employee codes
- [ ] Verify role-based redirection (Doctor vs Nurse)
- [ ] Test logout functionality
- [ ] Ensure proper session management

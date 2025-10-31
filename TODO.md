# TODO: Update Navbar in Laravel Hospital CRM

## Approved Plan Steps
- [x] Update `resources/views/website/layout/navbar.blade.php` to replace the content with the new navbar structure, converted to Blade syntax.
  - [x] Use `@guest` for auth-links (Login/Signup).
  - [x] Use `@auth` for user-actions (Book Appointment/Logout).
  - [x] Implement role-based home link: If authenticated and user type is 'user', href='index2.html'; if 'employee', href='employee-dashboard.html'; else 'index.html'.
  - [x] Implement profile link logic: If authenticated, redirect to 'User-profile.html'; else 'employee-userlogin.html'.
  - [x] Include the provided CSS styles (inlined).
  - [x] Include the JS script, adapted to use Laravel routes/URLs instead of hardcoded ones, remove localStorage checks (use Blade-rendered variables), keep mobile toggle JS, and handle logout via POST to Laravel logout route.
- [x] Ensure mobile toggle and other JS work; logout triggers POST to /logout.
- [x] Dependent files: `resources/views/website/layout/navbar.blade.php` (primary edit). No external CSS/JS files created yet.
- [x] Followup steps:
  - [x] Test the navbar on pages where it's included (e.g., welcome.blade.php). (Server started at http://127.0.0.1:8000; browser tool disabled, so manual testing needed.)
  - [ ] Verify auth redirects work (may need to adjust routes if URLs like 'index2.html' don't exist).
  - [ ] Run the app and check mobile responsiveness/console for errors.
  - [ ] If issues, debug JS or auth logic.

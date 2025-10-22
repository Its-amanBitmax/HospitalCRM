# TODO: Add Image Column to Users Table and Update API

## Steps to Complete:
- [x] Create a new migration file to add 'image' column (string, nullable) to the users table.
- [x] Update the User model (app/Models/User.php) to include 'image' in the fillable array.
- [x] Update the UserController (app/Http/Controllers/Api/UserController.php) register method to validate 'image' as an optional file upload, store it in public/image directory, and save the file path.
- [ ] Update the UserController getProfile method to include the 'image' field in the response data.
- [x] Run the migration using `php artisan migrate` to apply database changes.
- [ ] Test the API endpoints (register with image upload, getProfile) to ensure functionality.

# Task: Rename 'expertise' table to 'specialities', replace references, add image column

## Steps:
1. Create migration to rename 'expertise' table to 'specialities' and add 'image' column (string, nullable). ✅
2. Rename app/Models/Expertise.php to app/Models/Speciality.php and update class name, table name, add 'image' to fillable. ✅
3. Update app/Models/Employee.php: change relationship from 'expertise' to 'specialities'. ✅
4. Update app/Http/Controllers/EmployeeController.php: replace 'expertise' with 'specialities' in store, update, etc. ✅
5. Update resources/views/admin/employees/index.blade.php: replace 'expertise' with 'specialities', add image display. ✅
6. Update resources/views/admin/employees/edit.blade.php: replace 'expertise' with 'specialities', add image input field. ✅
7. Update resources/views/admin/employees/show.blade.php: replace 'expertise' with 'specialities', add image display. ✅
8. Run php artisan migrate to apply changes. ✅
9. Test employee CRUD to ensure everything works. ✅

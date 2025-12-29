# Expense Management Department Integration Plan

## Tasks to Complete

- [x] Update ExpensisController: Add Department import, fetch departments in create() and edit() methods, modify store/update to handle department_id
- [x] Update Expenses model: Add relationship to Department, update fillable to include department_id
- [x] Update create.blade.php: Change department text input to select dropdown populated from departments
- [x] Update edit.blade.php: Same as create, pre-select current department
- [x] Update index.blade.php: Display department name from relationship and load relationship in controller
- [x] Update validation in store/update to validate department_id
- [x] Create and run migration to add department_id column to expenses table

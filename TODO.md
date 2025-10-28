# UI and Layout Update for User Show Page

## Tasks
- [ ] Update topbar to include profile image and better styling
- [ ] Split user details into multiple individual cards for each section
- [ ] Add dedicated profile image display section
- [ ] Add icons to field labels and improve typography
- [ ] Add hover effects and ensure responsive design
- [ ] Test page load and visual changes
- [ ] Test responsiveness on different screen sizes
- [ ] Verify JavaScript functionality (delete user)

# Database Refactoring

## Tasks
- [x] Create new migration to refactor patient data tables
- [x] Remove visit-related columns from users table (visit_type, date_of_visit, chief_complaint, referred_by, department_consultant)
- [x] Create patient_visits table with user_id foreign key and visit columns
- [x] Create patient_checkups table with user_id, checkup_date, diagnosis, treatment
- [x] Create patient_documents table with user_id, document_type, document_path
- [x] Run migration to apply changes
- [x] Update User model to remove visit-related fillable attributes
- [x] Create PatientVisit, PatientCheckup, PatientDocument models
- [x] Update controllers to handle new table structures
- [x] Update views/forms to use new table structures
- [x] Test data migration and application functionality
- [x] Add "Visits" button to user show page
- [x] Create visits.blade.php view with tabs for visits, checkups, and documents
- [x] Create PatientVisitController and route

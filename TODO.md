# TODO: Implement Bed Assignment for IPD Patients

## Current Status
- [x] Analyze existing code and plan implementation
- [x] Get user approval for plan

## Steps to Complete

### 1. Create BedAssignment Model and Migration
- [ ] Create migration file: `database/migrations/create_bed_assignments_table.php`
- [ ] Create model: `app/Models/BedAssignment.php`

### 2. Update Models with Relationships
- [ ] Update `app/Models/Bed.php` to add bed assignment relationship
- [ ] Update `app/Models/User.php` to add bed assignment relationship

### 3. Add Routes for Bed Assignment Operations
- [ ] Update `routes/web.php` to add bed assignment routes

### 4. Add Controller Methods
- [ ] Update `app/Http/Controllers/WardBedController.php` with bed assignment methods

### 5. Modify IPD Patients View
- [x] Update `resources/views/admin/ipd-patients.blade.php`:
  - [x] Add bed status column to table
  - [x] Add bed details icon/button in actions
  - [x] Create modal for viewing bed details or assigning bed
  - [x] Show message if no bed assigned

### 6. Followup Steps
- [x] Run the new migration
- [ ] Test bed assignment functionality

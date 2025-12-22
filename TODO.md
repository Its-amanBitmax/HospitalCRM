# TODO: Fix Pharmacist Dashboard Data Loading Issue

## Problem
- Data is not loading on the pharmacist dashboard.
- Pharmacists don't have a `store_id` assigned, causing queries to fail.

## Solution Steps
- [x] Create migration to add `store_id` to employees table
- [x] Run migration to update database
- [x] Update Employee model fillable array to include `store_id`
- [x] Add store relationship to Employee model
- [x] Add error handling in PharmacyController for missing store_id
- [x] Update dashboard view to show error message when no store assigned
- [ ] Assign store_id to existing pharmacist employees in database
- [ ] Test the dashboard with assigned store_id

## Next Steps
1. Assign store_id to pharmacist employees via database seeder or manual update
2. Test dashboard functionality
3. Ensure all queries work correctly with store filtering

## Summary of Changes Made
- Added `store_id` column to employees table via migration
- Updated Employee model to include `store_id` in fillable and added store relationship
- Added error handling in PharmacyController to show message when no store assigned
- Updated dashboard view to display error message

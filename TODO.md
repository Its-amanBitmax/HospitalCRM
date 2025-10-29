# TODO List for User Form Modifications

## Tasks
- [x] Update resources/views/admin/users/create.blade.php:
  - Change "Registered Through" option from "Google" to "Offline".
  - In "Type" select: Add "Emergency", remove "Discharged".
  - In "Status" select: Add "Discharged".
- [x] Update resources/views/admin/users/edit.blade.php:
  - In "Type" select: Add "Emergency", remove "Discharged".
  - In "Status" select: Add "Discharged".
- [x] Update AdminController methods for emergency patients:
  - Rename updateDischargedPatient to updateEmergencyPatient.
  - Rename deleteDischargedPatient to deleteEmergencyPatient.
- [x] Update routes for emergency patients:
  - Change /update-discharged-patient/{id} to /update-emergency-patient/{id}.
  - Change /delete-discharged-patient/{id} to /delete-emergency-patient/{id}.
- [x] Update emergency-patients.blade.php:
  - Change fetch URL for update from /admin/update-discharged-patient/{id} to /admin/update-emergency-patient/{id}.
  - Change fetch URL for delete from /admin/delete-discharged-patient/{id} to /admin/delete-emergency-patient/{id}.
- [x] Update sidebar.blade.php:
  - Add "Discharged Patients" link in the Patients dropdown.
- [x] Add routes for discharged patients:
  - /discharged-patients, /get-discharged-patients, /update-discharged-patient/{id}, /delete-discharged-patient/{id}.
- [x] Add methods to AdminController for discharged patients:
  - dischargedPatients, getDischargedPatients, updateDischargedPatient, deleteDischargedPatient.
- [x] Create discharged-patients.blade.php view.
- [ ] Test the forms to ensure options display correctly.
- [ ] Update this TODO.md with progress.

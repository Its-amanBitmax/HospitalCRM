# TODO: Fix 500 Error on /admin/get-rooms Endpoint

## Issue
- GET /admin/get-rooms returns 500 Internal Server Error
- Response is HTML instead of expected JSON
- Frontend throws SyntaxError when parsing response

## Root Cause
- Database foreign key constraints causing query failure when rooms reference non-existent departments/employees
- Eager loading with with() fails when relationships are broken

## Plan
1. Modify RoomController@getRooms to use robust query with left joins
2. Test the endpoint to ensure it returns proper JSON
3. Verify frontend loads rooms correctly

## Steps
- [ ] Update getRooms method in RoomController.php to use DB::select with left joins
- [ ] Test the endpoint manually
- [ ] Verify frontend functionality

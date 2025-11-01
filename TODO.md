# TODO: Update Banner Images from Assets to Storage

## Approved Plan Steps
- [x] Create storage link if not exists (php artisan storage:link). (Already exists)
- [x] Move banner images from public/assets/image/ to storage/app/public/uploads/banners/. (Already moved)
- [x] Create a migration to update image_url in banners table for existing records to use /storage/uploads/banners/ path.
- [x] Run the migration to update database.
- [ ] Test banner display in admin panel.

## Information Gathered
- BannerController stores new images to 'uploads/banners' in 'public' disk, image_url set to '/storage/' . $imagePath.
- Existing banner images: banner1.jpg, Banner2.jpg, banner3.jpg, banner4.jpg, banner5.jpg in public/assets/image/.
- Banners table likely has image_url pointing to /assets/image/... for existing records.
- Need to move files and update DB to /storage/uploads/banners/... .

## Dependent Files to be edited
- None (file move via command, DB update via migration).

## Followup steps
- Run php artisan storage:link.
- Move files manually or via command.
- Run migration.
- Verify in admin banner page.

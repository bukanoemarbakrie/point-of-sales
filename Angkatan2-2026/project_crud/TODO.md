# TODO

- [ ] Fix SQL error in pages/create-role.php: UPDATE statement currently targets `users` table and column `is_active` mismatch with roles flow.
- [ ] Fix form field name mismatch: form uses `status` but PHP reads `$_POST['is_active']`.
- [ ] Fix HTML select value rendering and selected option based on edit data.
- [ ] After edits, verify page=create-role and page=role for create/edit/delete flows.
- [ ] Run quick PHP syntax check (optional) and/or load pages in browser.

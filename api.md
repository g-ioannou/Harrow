# Backend API for  **harrow** database

**Add user**

`CALL add_user(email,username,password,firstname,lastname)`

**Get user**

`CALL get_user(email)`

Returns row of data [file_id,email,username,firstname,lastname,reg_date,is_admin]

(Does not return password)

**Validate login**

`CALL validate_login(email,password)`

**_Next proceedures must be called together to add a complete file_**

**Add File**

`CALL add_file(user_id,file_name,file_size,upload_isp,upload_location)`

Returns file id [file_id]



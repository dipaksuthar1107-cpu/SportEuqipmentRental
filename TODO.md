# TODO: Fix Undefined Variable Error in request-book.blade.php

## Steps to Complete:
- [x] Update routes/web.php to make the request-book route parameterized with {id}
- [x] Update StudentController.php requestBook method to accept $id parameter, find equipment details, and pass $equipment_name to the view
- [x] Test the changes to ensure $equipment_name is defined in the view

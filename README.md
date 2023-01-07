## 1. Add a column to the database auth login (default users) table.
We will return this column by typing its name AuthenticatesUsers.php method.
  - Example:
    - custom_field (db users table column name)

## 2. Find Folder
vendor -> laravel -> ui -> auth-backend -> AuthenticatesUsers.php

## 3. Find Trait And Add Method
```php
// Custom Field Method
protected function customField()
{
    //Column name in database
    return "custom_field";
}
```

## 4. Update Validation Method
```php
// Default core laravel method
protected function validateLogin(Request $request)
{
    $request->validate([
        $this->username() => 'required|string',
        'password' => 'required|string',

        /**
         * Example 1
         * 
         * Add Our Method
         * key   -> our method/function
         * value -> Optional Options
         */
        $this->customField() => 'required|string',

        /**
         * Example 2
         * 
         * Without Using Method/Function
         */
        "custom_field" => 'required|string',
    ]);
}
```

## 5. We can now check the user at login with an Auth::attempt(). Thanks to this, the login process will be done by checking the Custom Field we added in the Auth users table.

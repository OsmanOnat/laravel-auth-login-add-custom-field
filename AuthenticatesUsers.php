<?php

trait AuthenticatesUsers
{

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
            //"custom_field" => 'required|string',
        ]);
    }

    // Custom Field Method
    protected function customField()
    {
        //Column name in database
        return "custom_field";
    }

}

?>
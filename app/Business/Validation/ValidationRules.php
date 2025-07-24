<?php

namespace App\Business\Validation;


class ValidationRules
{
    public static function CategoryAddValidator():array
    {
        return [
            'categoryName'=>'required|string',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public static function CategoryUpdateValidator():array
    {
        return [
            'categoryId'=>'required|integer',
            'categoryName'=>'required|string',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public static function ProductAddValidator():array
    {
        return [
            'productName'=>'required|string',
            'price'=>'numeric|decimal:0,2|min:0',
            'categoryId'=>'required|integer',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public static function ProductUpdateValidator():array
    {
        return [
            'productId'=>'required|integer',
            'productName'=>'required|string',
            'price'=>'numeric|decimal:0,2|min:0',
            'categoryId'=>'required|integer',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public static function AdminValidator():array
    {
        return [
                   'username'=>'required|string',
                   'email'=>'required|email',
                   'name'=>'required|string',
                   'surname'=>'required|string',
                   'role'=>'required|string',
                   'isActive'=>'required|integer',
                   'phone' => [
                                'required',
                                'regex:/^(\+90|0)?5\d{9}$/'
                              ],
                   'image'=>'nullable|file|mimes:jpeg,png,jpg,gif|max:20480' // yani max:20 MB olabilir
               ];
    }

    public static function AdminPasswordValidator():array
    {
        return [
            'adminId'=>'required|integer',
            'password'=>'required|string|min:8',
            'oldPassword'=>'required|string|min:8', // eski kullanıcı şifresi
            'repeatPassword'=>'required|string|same:password'
        ];
    }

    public static function AdminProfilValidator():array {
        // burada size:20480 dosyanın bu boyuta eşit olması gerektiğini söyler
        return [
            'adminId'=>'required|integer',
            'image'=>'nullable|image|mimes:png,jpg,jpeg,gif|max:20480', // kb cinsinden
            'phone'=>'nullable|string',
            'email'=>'nullable|email'
        ];
    }

}

<?php

namespace App\Business\Validation;

class Keys
{
    public static function AdminAdd():array
    {
        return ['username','name','surname','email','phone','role','isActive','password'];
    }

    public static function ProfilUpdate():array
    {
        return ['adminId','username','name','surname','email','phone'];
    }
    public static function AdminUpdate():array
    {
        return ['adminId','name','surname','username','email','phone','role','isActive'];
    }

    public static function UserPasswordUpdate():array
    {
        return ['adminId','oldPassword','repeatPassword','password'];
    }

    public static function CustomCategoryAdd():array
    {
        return ['customCategoryName'];
    }

    public static function CustomCategoryUpdate():array
    {
        return ['customCategoryId','customCategoryName'];
    }

    public static function TicketAdded():array
    {
        return ['title','description','priority','status'];
    }

    public static function TicketUpdated():array
    {
        return ['ticketId','title','description','priority'];
    }

    public static function TicketResponseAdded():array
    {
        return ['ticketId','adminId','responseText'];
    }

    public static function StatusUpdate():array
    {
        return ['ticketId','status'];
    }

}

// $data =[
//      'productId'=>1,
//      'productName'=>'Oralet',
//      'price'=>10,
//      'categoryId'=>1,
//      'productContent'=>[
//          ['price'=>10,'content'=>'Kivi'],
//          ['price'=>10,'content'=>'Karadut']
//      ]
//];

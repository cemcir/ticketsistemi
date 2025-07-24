<?php

namespace App\Business\Constants\Abstract;

interface IMessage
{
    public function CategoryAdded():string;
    public function CategoryNotAdded():string;
    public function CategoryDeleted():string;
    public function CategoryNotDeleted():string;
    public function CategoryNotFound():string;
    public function CategoryUpdated():string;
    public function CategoryNotUpdated():string;
    public function LicenceExistForCategory():string;
    public function CategoryNameExist():string;
    public function LicenceNameExist():string;
    public function LicenceAdded():string;
    public function LicenceNotAdded():string;
    public function LicenceDeleted():string;
    public function LicenceNotDeleted():string;
    public function LicenceNotFound():string;
    public function LicenceUpdated():string;
    public function LicenceNotUpdated():string;
    public function AdminUpdated():string;
    public function AdminAdded():string;
    public function AdminNotFound():string;
    public function AdminPasswordUpdate():string;
    public function AdminPasswordNotUpdate():string;
    public function AdminNotUpdated():string;
    public function AdminEmailAlreadyExist():string;
    public function AdminPhoneAlreadyExist():string;
    public function AdminNameAlreadyExist():string;
    public function AdminAlreadyExistForPayment():string;
    public function AdminDeleted():string;
    public function AdminNotAdded():string;
    public function AdminNotDeleted():string;
    public function AdminExistForPaymentCustomer():string;
    public function AdminPasswordUpdated():string;
    public function AdminPasswordNotUpdated():string;
    public function AdminExistForRezervation():string;
}

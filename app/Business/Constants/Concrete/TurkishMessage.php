<?php

namespace App\Business\Constants\Concrete;
use App\Business\Constants\Abstract\IMessage;

class TurkishMessage implements IMessage
{
    public function AdminUpdated(): string
    {
        return "Yönetici Başarıyla Güncellendi";
    }

    public function AdminNotUpdated(): string
    {
        return "Yönetici Güncellenirken Hata Oluştu";
    }


    public function AdminAdded(): string
    {
        return "Yönetici Kaydı Başarıyla Eklendi";
    }

    public function AdminPasswordUpdate(): string
    {
        return "Yönetici Ait Şifre Başarıyla Güncellendi";
    }

    public function AdminPasswordNotUpdate(): string
    {
        return "Yönetici Ait Şifre Güncellenirken Hata Oluştu";
    }

    public function AdminEmailAlreadyExist(): string
    {
        return "Yönetici Eposta Hesabı Zaten Mevcut";
    }

    public function AdminPhoneAlreadyExist(): string
    {
        return "Yönetici Telefon Kaydı Zaten Mevcut";
    }

    public function AdminNameAlreadyExist(): string
    {
        return "Yönetici Adı Zaten Mevcut";
    }

    public function AdminNotFound(): string
    {
        return "Yönetici Kaydı Bulunamadı";
    }

    public function AdminAlreadyExistForPayment(): string
    {
        return "Yöneticinin Yapmış Olduğu Tahsilat Kaydı Mevcut";
    }

    public function AdminDeleted(): string
    {
        return "Yönetici Başarıyla Silindi";
    }

    public function AdminNotDeleted(): string
    {
        return "Yönetici Kaydı Silinirken Hata Oluştu";
    }

    public function AdminExistForPaymentCustomer(): string
    {
        return "Yöneticinin Yapmış Olduğu Cari Tahsilat Kaydı Mevcut";
    }

    public function AdminPasswordUpdated(): string
    {
        return "Yönetici Şifresi Başarıyla Güncellendi";
    }

    public function AdminPasswordNotUpdated(): string
    {
        return "Yönetici Şifresi Güncellenirken Hata Oluştu";
    }

    public function AdminNotAdded(): string
    {
        return "Yönetici Kaydı Eklenirken Hata Oluştu";
    }

    public function AdminExistForRezervation(): string
    {
        return "Yöneticinin Yapmış Olduğu Rezervasyon Kaydı Mevcut";
    }

    public function OldPasswordFalse():string {

        return 'Eski Şifreniz Doğru Değil';
    }

    public function CategoryAdded(): string
    {
        return 'Kategori Kaydı Başarıyla Eklendi';
    }

    public function CategoryNotAdded(): string
    {
        return 'Kategoori Kaydı Eklenirken Hata Oluştu';
    }

    public function CategoryDeleted(): string
    {
        return 'Kategori Kaydı Başarıyla Sillindi';
    }

    public function CategoryNotDeleted(): string
    {
        return 'Kategori Kaydı Silinirken Hata Oluştu';
    }

    public function CategoryNotFound(): string
    {
        return 'Kategori Kaydı Bulunamadı';
    }

    public function CategoryUpdated(): string
    {
        return 'Kategori Kaydı Başarıyla Güncellendi';
    }

    public function CategoryNotUpdated(): string
    {
        return 'Kategori Kaydı Güncellenirken Hata Oluştu';
    }

    public function ProductExistForCategory(): string
    {
        return 'Kategoriye Ait Ürün Kaydı Mevcut';
    }

    public function CategoryNameExist(): string
    {
        return 'Kategori Adı Zaten Kayıtlı';
    }

    public function LicenceNameExist(): string
    {
        return "Lİsans Adı Zaten Kayıtlı";
    }

    public function LicenceAdded(): string
    {
        return "Lisans Kaydı Başarıyla Eklendi";
    }

    public function LicenceNotAdded(): string
    {
        return "Lisans Kaydı Eklenirken Hata Oluştu";
    }

    public function LicenceDeleted(): string
    {
        return "Lisans Başarıyla Silindi";
    }

    public function LicenceNotDeleted(): string
    {
        return "Lisans Silinirken Hata Oluştu";
    }

    public function LicenceNotFound(): string
    {
        return "Lisans Kaydı Bulunamadı";
    }

    public function LicenceUpdated(): string
    {
        return "Lisans Kaydı Başarıyla Güncellendi";
    }

    public function LicenceNotUpdated(): string
    {
        return "Lisans Kaydı Güncellenirken Hata Oluştu";
    }

    public function LicenceExistForCategory(): string
    {
        return "Kategoriye Ait Lisans Kaydı Mevcut";
    }

}

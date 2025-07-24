@extends('backend.layout')
@section('title','Profil')
@section('content')
<section class="content-header">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Profil</h3>
            <button class="btn btn-success" style="float: right;" id="passwordUpdate">Şifre Güncelle</button>
        </div>
        <div class="box-body">

            <div class="modal-overlay" id="modal">
                <div class="modal-content">
                    <span class="close-btn" id="close-form">&times;</span>
                    <form id="passwordUpdateForm">
                        <input type="hidden" name="adminId" value="{{$admin->adminId}}">
                        <div class="form-group">
                            <label>Eski Şifre</label>
                            <div class="row">
                                <div class="col-xs-12 col-md-10">
                                    <input class="form-control" type="password" name="oldPassword">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Şifre</label>
                            <div class="row">
                                <div class="col-xs-12 col-md-10">
                                    <input class="form-control" type="password" name="password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Şifre Tekrar</label>
                            <div class="row">
                                <div class="col-xs-12 col-md-10">
                                    <input class="form-control" type="password" name="repeatPassword">
                                </div>
                            </div>
                        </div>
                        <button type="submit" style="width: 100px; height:40px;" id="submitButton" class="btn btn-primary">Güncelle</button>
                    </form>
                </div>
            </div>

            <form id="profilUpdateForm" enctype="multipart/form-data">
                <input type="hidden" name="adminId" value="{{$admin->adminId}}">
                <div class="form-group">
                    <label>Ad</label>
                    <div class="row">
                        <div class="col-xs-12 col-md-5">
                            <input class="form-control" type="text" name="name" value="{{$admin->name}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Soyad</label>
                    <div class="row">
                        <div class="col-xs-12 col-md-5">
                            <input class="form-control" type="text" name="surname" value="{{$admin->surname}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>E-Posta</label>
                    <div class="row">
                        <div class="col-xs-12 col-md-5">
                            <input class="form-control" type="text" name="email" value="{{$admin->email}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Telefon</label>
                    <div class="row">
                        <div class="col-xs-12 col-md-5">
                            <input class="form-control" type="text" name="phone" value="{{$admin->phone}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Resim</label>
                    <div class="row">
                        <div class="col-xs-12 col-md-5">
                            <input type="file" name="image" width="99" height="128">
                        </div>
                    </div>
                </div>
                @if (!empty($admin->image))
                    <div class="form-group">
                        <img src="/{{$admin->image}}" id="image" width="99" height="128">
                    </div>
                @endif
                <button type="submit" id="submitButton" class="btn btn-primary">Güncelle</button>
            </form>
        </div>
    </div>
</section>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#passwordUpdate').on('click',function() {
                $('#modal').fadeIn();
            });

            $('#close-form').on('click',function() {
                $('#modal').fadeOut();
            });

            $('#passwordUpdateForm').on('submit',function(e) {
                e.preventDefault();
                let formData={
                    adminId:$('input[name="adminId"]').val(),
                    password:$('input[name="password"]').val(),
                    oldPassword:$('input[name="oldPassword"]').val(),
                    repeatPassword:$('input[name="repeatPassword"]').val()
                }

                $.ajax({
                    url:'{{route("admin.passwordUpdate")}}',
                    type:'POST',
                    contentType:'application/json',
                    dataType:'json',
                    data:JSON.stringify(formData),
                    success:function(response) {
                        window.location='{{route("login")}}';
                    },
                    error:function(xhr, status, error) {
                        let errorMsg = xhr.responseJSON ? xhr.responseJSON.msg : error; // JSON mesaj veya genel hata
                        alertify.error(errorMsg);
                    }
                })
            });

            $('#profilUpdateForm').on('submit',function(e) {
                e.preventDefault();
                var formData=new FormData(this);

                $.ajax({
                    url:'{{route("admin.profilUpdate")}}',
                    type:'POST',
                    data:formData,
                    processData:false,
                    contentType:false,
                    success:function(response) {
                        $('#image').attr('src','/'+response.data.image);
                        window.location="/panel/giris";
                        alertify.success(response.msg);
                    },
                    error:function(xhr,status,error) {
                        let errorMsg = xhr.responseJSON ? xhr.responseJSON.msg : error; // JSON mesaj veya genel hata
                        alertify.error(errorMsg);
                    }
                });
            });
        });
    </script>
@endsection

@section('css')

<style>
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    /* Modal İçerik */
    .modal-content {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1100;
        width: 380px; /* İçeriğin genişliğini ayarlayın */
    }

    /* Kapatma Düğmesi */
    .close-btn {
        float: right;
        cursor: pointer;
        font-size: 18px;
    }

        /* Form Grupları */
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

        /* Düğmeler */
    .btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        border-radius: 4px;
        border: none;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }
</style>

@endsection

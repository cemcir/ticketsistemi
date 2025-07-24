@extends('backend.layout')
@section('title','Yönetici Ekle')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Yönetici Ekle</h3>
            </div>
            <div class="box-body">
                <form id="userAddForm">
                    <div class="form-group">
                        <label>Kullanıcı Adı</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="username">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ad</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Soyad</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="surname">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>E-Posta</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="email">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Telefon</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="phone">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Yetki</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select name="role" class="form-control">
                                    <option value="admin">Yönetici</option>
                                    <option value="user">Çalışan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Durum</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select name="isActive" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Pasif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Resim</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="file" name="image" width="99" height="128">
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="submitButton" class="btn btn-success">Ekle</button>
                </form>
            </div>
        </div>
    </section>

@endsection


@section('css')

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $("#userAddForm").submit(function(event) {
                event.preventDefault();
                var formData=new FormData(this);

                $.ajax({
                    url:'{{route('admin.add')}}',
                    type:'POST',
                    data:formData,
                    processData:false,
                    contentType:false,
                    success: function(response) {
                        alertify.success(response.msg);
                    },
                    error: function (xhr, status, error) {
                        let errorMsg = xhr.responseJSON ? xhr.responseJSON.msg : error;
                        alertify.error(errorMsg);
                    }
                });
            })
        });
    </script>

@endsection


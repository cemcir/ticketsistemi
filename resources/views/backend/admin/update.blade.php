@extends('backend.layout')
@section('title','Yönetici Güncelle')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Yönetici Güncelle</h3>
            </div>
            <div class="box-body">
                <form id="adminUpdateForm" enctype="multipart/form-data">
                    <input type="hidden" name="adminId" value="{{$admin->adminId}}">
                    <div class="form-group">
                        <label>Kullanıcı Adı</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="username" value="{{$admin->username}}">
                            </div>
                        </div>
                    </div>
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
                        <label>Yetki</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select name="role" class="form-control">
                                    @foreach ($admin['roles'] as $key=>$value)
                                        @if($key==$admin->role)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Durum</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select name="isActive" class="form-control">
                                    @foreach ($admin['active'] as $active)
                                        @if($admin->isActive==$active)
                                            <option selected value="{{$active}}">{{$active==1 ? 'Aktif':'Pasif'}}</option>
                                        @else
                                            <option value="{{$active}}">{{$active==1 ? 'Aktif':'Pasif'}}</option>
                                        @endif
                                    @endforeach
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
                    @if (!empty($admin->image))
                        <div class="form-group">
                            <label>Resim</label>
                            <div class="row">
                                <div class="col-xs-12 col-md-5">
                                    <img id="image" src="/{{$admin->image}}" width="99" height="128">
                                </div>
                            </div>
                        </div>
                    @endif
                    <button type="submit" id="submitButton" class="btn btn-primary">Güncelle</button>
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
            $("#adminUpdateForm").submit(function(event) {
                event.preventDefault();
                var formData=new FormData(this);

                $.ajax({
                    url:'{{route("admin.update")}}',
                    type:'POST',
                    data:formData,
                    processData:false,
                    contentType:false,
                    success: function(response) {
                        $('#image').attr('src',"/"+response.data.image);
                        alertify.success(response.msg);
                    },
                    error: function (xhr, status, error) {
                        let errorMsg = xhr.responseJSON ? xhr.responseJSON.msg : error;
                        alertify.error(errorMsg);
                    }
                });
            });

        });
    </script>

@endsection


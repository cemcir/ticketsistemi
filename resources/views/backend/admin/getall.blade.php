@extends('backend.layout')
@section('title','Yönetici Listesi')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Yönetici Listesi</h3>
                <button class="btn btn-success" style="float: right;" onclick="window.location.href='{{route('adminAddForm')}}'">Ekle</button>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Yönetici Adı</th>
                            <th>E-Posta</th>
                            <th>Telefon</th>
                            <th>Role</th>
                            <th>Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>{{$admin->username}}</td>
                                <td>{{$admin->email}}</td>
                                <td>{{$admin->phone}}</td>
                                @if ($admin->role=='admin')
                                    <td>Yönetici</td>
                                @else
                                    <td>Çalışan</td>
                                @endif
                                <td>
                                    @if ($admin->isActive==1)
                                        Aktif
                                    @else
                                        Pasif
                                    @endif
                                </td>
                                <td width="5">
                                    <form action="{{route('adminUpdateForm')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="adminId" value="{{$admin->adminId}}">
                                        <button style="border:none" type="submit">
                                            <a href="javascript:void()"><i class="fa fa-pencil-square"></i></a>
                                        </button>
                                    </form>
                                </td>
                                <td width="5">
                                    <a href="javascript:void()"><i id="{{$admin->adminId}}" class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection


@section('css')

@endsection

@section('js')
<script>

    $(document).ready(function () {

        $(".fa-trash-o").click(function () {

            const row=$(this).closest('tr');
            let formData={
                adminId:parseInt($(this).attr('id'))
            };

            $.ajax({
                url: "{{route('admin.delete')}}", // API URL
                type: "POST", // HTTP POST metodu
                dataType: "json", // Dönen veri formatı (JSON bekleniyor)
                contentType: "application/json", // Gönderilen veri formatı
                data: JSON.stringify(formData), // JSON verisini string'e çeviriyoruz
                success: function (response) {
                    row.css('display','none');
                    alertify.success(response.msg);
                },
                error: function (xhr, status, error) {
                    var errorMsg = xhr.responseJSON ? xhr.responseJSON.msg : error; // JSON mesaj veya genel hata
                    alertify.error(errorMsg);
                }
            });
        });
    });

    </script>
@endsection


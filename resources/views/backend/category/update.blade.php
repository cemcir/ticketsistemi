@extends('backend.layout')
@section('title','Kategori Güncelle')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Kategori Güncelle</h3>
            </div>
            <div class="box-body">
                <form id="categoryUpdateForm">
                    <input type="hidden" name="categoryId" value="{{$data->categoryId}}">
                    <div class="form-group">
                        <label>Kategori Adı</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="categoryName" value="{{$data->categoryName}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image">Resim Seçiniz</label>
                        <input class="form-control-file" type="file" name="image" accept="image/*">
                    </div>
                    <div id="image" class="form-group">
                        <label>Resim</label>
                        <div class="row">
                            <div class=" col-xs-12 col-md-5">
                                <img src="/{{$data->image}}" alt="{{$data->categoryName}}" style=" width:260px; height:260px;">
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="submitButton" class="btn btn-success">Güncelle</button>
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
            $("#categoryUpdateForm").submit(function(event) {
                event.preventDefault();
                var formData=new FormData(this);

                $.ajax({
                    url:'{{route('category.update')}}',
                    type:'POST',
                    data:formData,
                    processData:false,
                    contentType:false,
                    success: function(response) {
                        alertify.success(response.msg);
                        $('#image').empty();
                        $('#image').append(`
                            <label>Resim</label>
                            <div class="row">
                                <div class=" col-xs-12 col-md-5">
                                    <img src="/${response.data.image}" alt="${response.data.categoryName}" style=" width:260px; height:260px;">
                                </div>
                            </div>
                        `);
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

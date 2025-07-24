@extends('backend.layout')
@section('title','Kategori Güncelle')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Kategori Güncelle</h3>
            </div>
            <div class="box-body">
                <form id="mainCategoryUpdateForm">
                    <div class="form-group">
                        <input type="hidden" name="mainCategoryId" value="{{$data->mainCategoryId}}">
                        <label>Kategori</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="mainCategoryName" value="{{$data->mainCategoryName}}">
                            </div>
                        </div>
                    </div>
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

            $("#mainCategoryUpdateForm").submit(function(event) {
                event.preventDefault();
                var formData={
                    mainCategoryId:$('input[name="mainCategoryId"]').val(),
                    mainCategoryName:$('input[name="mainCategoryName"]').val()
                }
                $.ajax({
                    url:'{{route('mainCategory.update')}}',
                    type:'POST',
                    contentType:'application/json',
                    data:JSON.stringify(formData),
                    success: function(response) {
                        alertify.success(response.msg);
                    },
                    error: function (xhr,status,error) {
                        let errorMsg = xhr.responseJSON ? xhr.responseJSON.msg : error;
                        alertify.error(errorMsg);
                    }
                });
            });

        });
    </script>

@endsection

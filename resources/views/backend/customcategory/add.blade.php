@extends('backend.layout')
@section('title','Kategori Ekle')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Özel Kategori Ekle</h3>
            </div>
            <div class="box-body">
                <form id="customCategoryAddForm">
                    <div class="form-group">
                        <label>Kategori</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="customCategoryName">
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

            $("#customCategoryAddForm").submit(function(event) {
                event.preventDefault();
                var formData={
                    customCategoryName:$('input[name="customCategoryName"]').val()
                }
                $.ajax({
                    url:'{{route('customCategory.add')}}',
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

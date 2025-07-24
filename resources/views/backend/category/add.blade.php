@extends('backend.layout')
@section('title','Kategori Ekle')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Kategori Ekle</h3>
            </div>
            <div class="box-body">
                <form id="categoryAddForm">
                    <div class="form-group">
                        <label>Kategori Türü</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select  class="form-control" id="category_type">
                                    <option selected value="1">Ana Kategori</option>
                                    <option value="2">Alt Kategori</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="main_category_one" class="form-group">
                        <label>Ana Kategori</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="categoryName">
                            </div>
                        </div>
                    </div>
                    <!--
                    <div id="main_category_two" style="display: none;"  class="form-group">
                        <label>Ana Kategori</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select class="form-control" name="parentCategoryId">
                                    <option selected disabled>Kategori Seçiniz</option
                                </select>
                            </div>
                        </div>
                    </div>
                    -->
                    <div id="sub_category" style="display: none" class="form-group">
                        <label>Alt Kategori</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="categoryName1">
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

            let categoryType;
            $('#category_type').on('change',function (){
                categoryType = $(this).val();
                if(categoryType==="1") {
                    $('#main_category_one').css('display','block');
                    $('#main_category_two').css('display','none');
                    $('#sub_category').css('display','none');
                }
                else {
                    $('#main_category_one').css('display','none');
                    $('#main_category_two').css('display','block');
                    $('#sub_category').css('display','block');
                }
            });

            $("#categoryAddForm").submit(function(event) {
                event.preventDefault();
                /*
                var formData={};
                if(categoryType==="1") {
                    formData={
                        categoryName:$('input[name="categoryName"]').val(),
                        parentCategoryId:0
                    }
                }
                else {
                    formData={
                        categoryName:$('input[name="categoryName1"]').val(),
                        parentCategoryId:parseInt($('select[name="parentCategoryId"]').val())
                    }

                }
                */
                $.ajax({
                    url:'{{route('category.add')}}',
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

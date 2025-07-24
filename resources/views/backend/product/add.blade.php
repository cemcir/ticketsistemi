@extends('backend.layout')
@section('title','Ürün Ekle')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Ürün Ekle</h3>
            </div>
            <div class="box-body">
                <form id="productAddForm">
                    <div class="form-group">
                        <label>Ürün Adı</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="productName">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Fiyat</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="number" name="price" value="0.00" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select class="form-control" id="selectType" name="categoryId">
                                    <option selected disabled>Kategori Seçiniz</option>
                                    @foreach ($data['categories'] as $category)
                                        <option value="{{$category->categoryId}}">
                                            {{$category->categoryName}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image">Resim</label>
                        <input class="form-control-file" type="file" name="image" id="image" accept="image/*">
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
            $("#productAddForm").submit(function(event) {
                event.preventDefault();
                var formData=new FormData(this);

                $.ajax({
                    url:'{{route('product.add')}}',
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


@extends('backend.layout')
@section('title','Ürün Güncelle')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Ürün Güncelle</h3>
            </div>
            <div class="box-body">
                <form id="productUpdateForm">
                    @csrf
                    <input type="hidden" name="productId" value="{{$data['product']->productId}}">
                    <div class="form-group">
                        <label>Ürün Adı</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="productName" value="{{$data['product']->productName}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Fiyat</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="number" name="price" value="{{$data['product']->price}}" step="0.01" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select class="form-control" id="selectType" name="categoryId">
                                    <option selected disabled>Kategori Seçiniz</option>
                                    @foreach ($data['categories'] as $category)
                                        @if($data['product']->categoryId==$category->categoryId)
                                            <option selected value="{{$category->categoryId}}">
                                                {{$category->categoryName}}
                                            </option>
                                        @else
                                            <option value="{{$category->categoryId}}">
                                                {{$category->categoryName}}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
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
                                <img src="/{{$data['product']->image}}" alt="{{$data['product']->productName}}" style="width:260px; height:260px;">
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
            $("#productUpdateForm").submit(function(event) {
                event.preventDefault();
                var formData=new FormData(this);

                $.ajax({
                    url:'{{route('product.update')}}',
                    type:'POST',
                    data:formData,
                    processData:false,
                    contentType:false,
                    success: function(response) {
                        alertify.success(response.msg);
                        $('#image').empty();
                        $('#image').append(`
                            <div id="image" class="form-group">
                               <label>Resim</label>
                               <div class="row">
                               <div class="col-xs-12 col-md-5">
                                    <img src="/${response.data.image}" alt="${response.data.productName}" style="width:260px; height:260px;">
                               </div>
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


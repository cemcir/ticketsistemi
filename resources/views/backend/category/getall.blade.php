@extends('backend.layout')
@section('title','Kategori Listesi')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Kategori Listesi</h3>
                <button class="btn btn-success" style="float:right;" onclick="window.location.href='{{route('categoryAddForm')}}'">Ekle</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Kategori Adı</th>
                        <th>Kategori Türü</th>
                    </tr>
                    </thead>
                    <tbody id="category-list">
                    @if(!@empty($data))
                        @foreach ($data as $category)
                            <tr data-id="{{$category->categoryId}}">
                                <td>{{$category->categoryName}}</td>
                                <td>
                                    @if($category->parentCategoryId==0)
                                        <strong>Ana Kategori</strong>
                                    @else
                                        <strong>Alt Kategori</strong>
                                    @endif
                                </td>
                                <td width="5">
                                    <form action="{{route('categoryUpdateForm')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="categoryId" value="{{$category->categoryId}}">
                                        <button style="border:none" type="submit">
                                            <a href="javascript:void()"><i class="fa fa-pencil-square"></i></a>
                                        </button>
                                    </form>
                                </td>
                                <td width="5">
                                    <a href="javascript:void()"><i id="{{$category->categoryId}}" class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
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
                const row = $(this).closest('tr');
                const requestData = {
                    categoryId: $(this).attr('id')
                };

                $.ajax({
                    url:'{{ route("category.delete") }}',
                    type: "POST",
                    dataType: "json",
                    contentType: "application/json",
                    data: JSON.stringify(requestData),
                    success: function (response) {
                        row.hide();
                        alertify.success(response.msg);
                    },
                    error: function (xhr, status, error) {
                        var errorMsg = xhr.responseJSON ? xhr.responseJSON.msg : error;
                        alertify.error(errorMsg);
                    }
                });
            });
        });

    </script>
@endsection

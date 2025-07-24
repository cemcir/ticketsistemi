@extends('backend.layout')
@section('title','Ana Ekran')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lisans Ana Ekran</h3>
                </div>

                <div class="card-body">
                    {{-- Filtre Alanları --}}
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3 mb-3">
                            <label for="limit">Gösterim Sayısı</label>
                            <select id="limit" class="form-control">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3 mb-3">
                            <label for="search">Arama</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Ürün Adı Kategori...">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>Başlık</th>
                                <th>Açıklama</th>
                                <th>Başlama Tarihi</th>
                                <th>Bitiş Tarihi</th>
                                <th>Lisans Süresi</th>
                                <th>Alınan</th>
                                <th>Kullanılan</th>
                                <th>Seri No</th>
                                <th>Kategori</th>
                            </tr>
                            </thead>
                            <tbody id="product-list">
                            @foreach ($data['licences'] as $licence)
                                <tr>
                                    <td>{{$licence->title}}</td>
                                    <td>{{$licence->description}} TL</td>
                                    <td>{{$licence->startDate}}</td>
                                    <td>{{$licence->endDate}}</td>
                                    <td>{{$licence->time}}</td>
                                    <td>{{$licence->from}}</td>
                                    <td>{{$licence->toWhom}}</td>
                                    <td>{{$licence->serialNo}}</td>
                                    <td>{{$licence->categoryName}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Sayfalama --}}
                    <div id="pagination-controls" class="mt-3">
                        @php $totalPage = ceil($data['totalRecord'] / 10); @endphp
                        @for ($i = 1; $i <= $totalPage; $i++)
                            <button class="btn {{ $i == 1 ? 'btn-primary' : 'btn-secondary' }} pagination-btn" data-page="{{ $i }}">{{ $i }}</button>
                        @endfor
                        @if($totalPage > 1)
                            <button class="btn btn-secondary pagination-btn" data-page="2">Sonraki</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            let pageNumber = 1;
            let limit = 10;
            let search = "";

            function fetchRezervations(limit,pageNumber) {
                search = $('#search').val();

                let formData = {
                    search: search,
                    offset: (pageNumber - 1) * limit,
                    limit: limit
                };

                $.ajax({
                    url: '{{route("licence.search")}}',
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(formData),
                    success: function (response) {
                        populateTable(response.data.licences);
                        renderPagination(response.data.totalRecord, limit, pageNumber);
                    },
                    error:function (xhr,status,error) {
                        $('#product-list').empty();
                    }
                });
            }

            function populateTable(data) {
                const tbody = $('#product-list');
                tbody.empty();
                data.forEach((product) => {
                    const row = `
                    <tr>
                        <td>${product.productName}</td>
                        <td><img src="/${product.image}" alt="${product.productName}" style=" max-width:200px; height:200px;"></td>
                        <td>${product.price} TL</td>
                        <td>${product.categoryName}</td>
                    </tr>`;
                    tbody.append(row);
                });
            }

            function renderPagination(totalRecord, limit, pageNumber) {
                const controls = $('#pagination-controls');
                controls.empty();
                const totalPage = Math.ceil(totalRecord / limit);

                if (pageNumber > 1) {
                    controls.append(`<button class="btn btn-secondary pagination-btn" data-page="${pageNumber - 1}">Önceki</button>`);
                }

                for (let i = 1; i <= totalPage; i++) {
                    controls.append(`<button class="btn ${i === pageNumber ? 'btn-primary' : 'btn-secondary'} pagination-btn" data-page="${i}">${i}</button>`);
                }

                if (pageNumber < totalPage) {
                    controls.append(`<button class="btn btn-secondary pagination-btn" data-page="${pageNumber + 1}">Sonraki</button>`);
                }
            }

            // Event Listeners
            $('#limit, #year-list, #month-list').change(function () {
                limit = $('#limit').val();
                fetchRezervations(limit, pageNumber);
            });

            $('#search').on('input', function () {
                limit = $('#limit').val();
                fetchRezervations(limit, pageNumber);
            });

            $(document).on('click', '.pagination-btn', function () {
                pageNumber = $(this).data('page');
                fetchRezervations(limit, pageNumber);
            });
        });
    </script>
@endsection

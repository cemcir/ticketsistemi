@extends('backend.layout')
@section('title','Lisans Listesi')

@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Lisans Listesi</h3>
            </div>

            <div class="box-header with-border">
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-xs-12 col-sm-4" style="margin-bottom: 10px;">
                        <select id="limit" class="form-control">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-5" style="margin-bottom: 10px;">
                        <input type="text" id="licenceSearch" name="search" class="form-control" placeholder="Arayın...">
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <button class="btn btn-block btn-success ekle-buton" onclick="window.location.href='{{route('licenceAddForm')}}'">
                            <i class="fa fa-plus-circle"></i> Lisans Ekle
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tablo -->
            <div class="box-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Açıklama</th>
                        <th>Başlangıç Tarihi</th>
                        <th>Bitiş Tarihi</th>
                        <th>Süre</th>
                        <th>Kimden</th>
                        <th>Kime</th>
                        <th>Seri No</th>
                        <th>Kategori</th>
                        <th>Özel Kategori</th>
                        <th>Düzenle</th>
                        <th>Sil</th>
                    </tr>
                    </thead>
                    <tbody id="licence-list">
                    @foreach ($data['licences'] as $licence)
                        <tr>
                            <td>{{$licence->title}}</td>
                            <td>{{$licence->description}}</td>
                            <td>{{$licence->startDate}}</td>
                            <td>{{$licence->endDate}}</td>
                            <td>{{$licence->time}}</td>
                            <td>{{$licence->from}}</td>
                            <td>{{$licence->toWhom}}</td>
                            <td>{{$licence->serialNumber}}</td>
                            <td>{{$licence->mainCategoryName}}</td>
                            <td>{{$licence->customCategoryName}}</td>
                            <td width="5">
                                <form action="{{route('licenceUpdateForm')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="productId" value="{{$licence->licenceId}}">
                                    <button style="border:none" type="submit">
                                        <a href="javascript:void()"><i class="fa fa-pencil-square"></i></a>
                                    </button>
                                </form>
                            </td>
                            <td width="5">
                                <a href="javascript:void()"><i id="{{$licence->licenceId}}" class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Sayfalama -->
                <div id="pagination-controls" class="text-center" style="margin-top: 20px;">
                    @php $totalPage = ceil($data['totalRecord'] / 10); @endphp
                    @for ($i = 1; $i <= $totalPage; $i++)
                        <button class="btn btn-xs {{ $i == 1 ? 'btn-primary' : 'btn-default' }} pagination-btn" data-page="{{ $i }}">{{ $i }}</button>
                    @endfor
                    @if ($totalPage > 1)
                        <button class="btn btn-xs btn-default pagination-btn" data-page="2">Sonraki</button>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <style>
        .ekle-buton {
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-radius: 5px;
        }
        .ekle-buton:hover {
            background-color: #449d44;
            transform: scale(1.03);
            box-shadow: 0 6px 10px rgba(0,0,0,0.15);
        }
    </style>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            let pageNumber = 1;
            let limit = 10;

            $("#limit").change(function() {
                limit = $('#limit').val();
                searchLicence(limit,1);
            });

            function renderPagination(totalRecord, limit, pageNumber) {
                const controls = $('#pagination-controls');
                controls.empty();
                let totalPage = Math.ceil(totalRecord / limit);

                if (pageNumber > 1) {
                    controls.append(`<button class="btn btn-xs btn-default pagination-btn" data-page="${pageNumber - 1}">Önceki</button>`);
                }

                for (let i = 1; i <= totalPage; i++) {
                    controls.append(`<button class="btn btn-xs ${i === pageNumber ? 'btn-primary' : 'btn-default'} pagination-btn" data-page="${i}">${i}</button>`);
                }

                if (pageNumber < totalPage) {
                    controls.append(`<button class="btn btn-xs btn-default pagination-btn" data-page="${pageNumber + 1}">Sonraki</button>`);
                }
            }

            $(document).on('click', '.pagination-btn', function () {
                pageNumber = $(this).data('page');
                searchLicence(limit,pageNumber);
            });

            $(document).on('click', '.fa-trash-o', function () {
                let $row = $(this).closest('tr');
                let licenceId = parseInt($(this).attr('id'));

                // Kullanıcıya onay sorusu
                alertify.confirm("Silme işlemi",
                    "Silmek istediğinizden emin misiniz?",
                    function () {
                        // Evet dediyse bu kod çalışır
                        let requestData = { licenceId: licenceId };

                        $.ajax({
                            url: '{{ route("licence.cancel") }}',
                            type: 'POST',
                            dataType: 'json',
                            contentType: 'application/json',
                            data: JSON.stringify(requestData),
                            success: function (response) {
                                $row.hide();
                                alertify.success(response.msg);
                            },
                            error: function (xhr) {
                                let errorMsg = xhr.responseJSON ? xhr.responseJSON.msg : "Bir hata oluştu.";
                                alertify.error(errorMsg);
                            }
                        });
                    },
                    function () {
                        // Hayır derse hiçbir şey yapma
                        alertify.error('Silme işlemi iptal edildi.');
                    }
                ).set('labels', { ok: 'Evet', cancel: 'Hayır' });
            });

            function searchLicence(limit,pageNumber) {
                let search = $('input[name="search"]').val().trim();

                $.ajax({
                    url: '{{ route("licence.search") }}',
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify({
                        search: search,
                        offset: (pageNumber - 1) * limit,
                        limit: limit
                    }),
                    success: function (response) {
                        populateTable(response.data.licences);
                        renderPagination(response.data.totalRecord, limit, pageNumber);
                    },
                    error: function (xhr) {
                        $('#licence-list').empty();
                    }
                });
            }

            function populateTable(data) {
                const tbody = $('#licence-list');
                tbody.empty();

                data.forEach((licence)=> {
                    const row = `
                        <tr>
                            <td>${licence.title}</td>
                            <td>${licence.description}</td>
                            <td>${licence.startDate}</td>
                            <td>${licence.endDate}</td>
                            <td>${licence.time}</td>
                            <td>${licence.from}</td>
                            <td>${licence.toWhom}</td>
                            <td>${licence.serialNumber}</td>
                            <td></td>
                            <td width="5">
                                <form action="{{route('licenceUpdateForm')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="productId" value="${licence.licenceId}">
                                    <button style="border:none" type="submit">
                                        <a href="javascript:void()"><i class="fa fa-pencil-square"></i></a>
                                    </button>
                                </form>
                            </td>
                            <td width="5">
                                <a href="javascript:void()"><i id="${licence.licenceId}" class="fa fa-trash-o"></i></a>
                            </td> `;
                    tbody.append(row);
                })
            }

            $('#licenceSearch').on('input', function () {
                pageNumber = 1;
                limit = $('#limit').val();
                searchLicence(limit,pageNumber);
            });
        });
    </script>
@endsection

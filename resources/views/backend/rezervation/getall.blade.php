@extends('backend.layout')
@section('title','Rezervasyon Listesi')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Rezervasyon Listesi</h3>
            </div>

            <div class="modal-overlay" id="modal">
                <div class="modal-content">
                    <span class="close-btn" id="rezervation-type-close">&times;</span>
                    <form id="menuUpdateForm">
                        <input type="hidden" name="rezervationId" value="">
                        <div class="form-group">
                            <label>Rezervasyon Türleri</label>
                            <div id="menu-price"></div>
                            <div id="menu-list"></div>
                        </div>
                        <div class="form-group">
                            <label>Seçilen Rezervasyon Türleri</label>
                            <div id="selected-menus">

                            </div>
                        </div>
                        <button type="submit" style="width:100px; height:40px;" id="submitButton" class="btn btn-primary">Güncelle</button>
                    </form>
                </div>
            </div>

            <div class="box-header with-border">
                <!-- Row sınıfı eklendi. Grid sisteminin doğru çalışması için. -->
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-1">
                        <select id="limit" style="height: 40px; width:100%;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-2">
                        <select id="year-list" name="year" style="height: 40px; width:100px; border-radius:4px;">
                            <option value="0">Yıl Seçiniz</option>
                            @foreach ($data['years'] as $year)
                                <option value="{{$year}}">{{$year}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-4">
                        <input type="text" id="search" name="search" placeholder="arayın..." style="height:40px; width:100%; border-radius:5px;">
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-5">
                        <button id="rezervation-add" class="btn btn-success" style="height: 40px;" onclick="window.location.href='{{route('rezervationAddForm')}}'">Yeni Rezervasyon</button>
                    </div>
                </div>
            </div>

            <div class="box-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Baslama Saati</th>
                            <th>Bitiş Saati</th>
                            <th>Rezervasyon Tarihi</th>
                            <th>Müşteri Adı</th>
                            <th>Müşteri Soyadı</th>
                            <th>Müşteri Telefon</th>
                            <th>Toplam Tutar</th>
                            <th>Ödenen Tutar</th>
                            <th>Kalan Tutar</th>
                            <th>Ödeme Durumu</th>
                        </tr>
                    </thead>
                    <tbody id="rezervation-list">
                        @foreach ($data['rezervations'] as $rezervation)
                            <tr>
                                <td>{{$rezervation->enterHour}}</td>
                                <td>{{$rezervation->exitHour}}</td>
                                <td>{{$rezervation->rezervationDate}}</td>
                                <td>{{$rezervation->customerName}}</td>
                                <td>{{$rezervation->customerSurName}}</td>
                                <td>{{$rezervation->customerPhone}}</td>
                                <td>{{$rezervation->totalPrice}}</td>
                                <td>{{$rezervation->paymentPrice}}</td>
                                <td>{{$rezervation->remainderPrice}}</td>
                                @if($rezervation->paymentState==1)
                                    <td style="color:green;">Ödendi</td>
                                @else
                                    <td style="color:red;">Ödenmedi</td>
                                @endif
                                <td width="5">
                                    <form action="{{route('rezervationUpdateForm')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="rezervationId" value="{{$rezervation->rezervationId}}">
                                        <button style="border:none" type="submit">
                                            <a href="javascript:void()"><i class="fa fa-pencil-square" data-toggle="tooltip" title="Düzenle"></i></a>
                                        </button>
                                    </form>
                                </td>
                                <td width="5">
                                    <a href="javascript:void()"><i id="{{$rezervation->rezervationId}}" class="fa fa-trash-o" data-toggle="tooltip" title="Sil"></i></a>
                                </td>
                                @if (session()->has('token') && (session()->get('user')['role']=='admin' || session()->get('user')['role']=='user'))
                                    <td width="5">
                                        <form action="{{route('payment.details')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="rezervationId" value="{{$rezervation->rezervationId}}">
                                            <button style="border:none" type="submit">
                                                <a href="javascript:void()"><i class="fa fa-file-text" data-toggle="tooltip" title="Tahsilat Detay"></i></a>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                                <td width="5">
                                    <a href="javascript:void()"><i id="{{$rezervation->rezervationId}}" class="glyphicon glyphicon-scissors" data-toggle="tooltip" title="Rezervasyon Türü"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="pagination-controls" style="margin-top: 20px;">
                    @php
                        $totalPage=1;
                        if($data['totalRecord']>10) {
                            $totalPage=ceil($data['totalRecord']/10);
                        }
                    @endphp
                    @for ($i = 1; $i <= $totalPage; $i++)
                        <button class="btn {{ $i == 1 ? 'btn-primary' : 'btn-secondary' }} pagination-btn" data-page="{{ $i }}">{{ $i }}</button>
                    @endfor
                    @if ($totalPage>1)
                        <button class="btn btn-secondary pagination-btn" data-page="2">Sonraki</button>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection

@section('css')
    <style>
        @media screen and (max-width: 576px) {
            #rezervation-add {
                font-size: 15px;
                text-align: center;
                width: 100%;
                margin-top: 10px;
            }
            #search:focus {
                border-color: blue; /* kenar rengini mavi yap */
                outline: none /* varsayılan odak çerçevesini kaldır */
            }

            #search {
                margin-top: 10px;
            }
        }

        @media screen and (min-width: 577px) {
            #rezervation-add {
                float: right;
            }
        }

        #limit {
            border: 1px solid #ccc; /* Açık gri */
            border-radius: 4px;
        }

        #limit:focus {
            border-color: #007BFF; /* açık mavi renk */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Hafif bir mavi gölge */
            outline: none; /* input kenarlığını varsayılan olarak kaldır */
        }

        #search {
            border: 1px solid #ccc; /* Açık gri */
            border-radius: 4px;     /* Hafif yuvarlatılmış köşeler */
        }

        #search:focus {
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Hafif bir mavi gölge */
            outline: none; /* input kenarlığını kaldır */
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        /* Modal İçerik */
        .modal-content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1100;
            width: 380px; /* İçeriğin genişliğini ayarlayın */
        }

        /* Kapatma Düğmesi */
        .close-btn {
            float: right;
            cursor: pointer;
            font-size: 18px;
        }

        /* Form Grupları */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Düğmeler */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border-radius: 4px;
            border: none;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .item {
            display: flex;
            align-items: center;
            margin: 5px 0;
        }

        .item .delete {
            color: red;
            cursor: pointer;
            margin-right: 10px;
        }
    </style>

@endsection

@section('js')
<script>
    $(document).ready(function () {
        let pageNumber=1;
        let limit=10;

        $(".glyphicon").on('click',function () {
            $('#modal').fadeIn();
            let rezervationId = $(this).attr('id');
            window.alert(rezervationId);
        });

        $("#rezervation-type-close").on('click',function () {
            $('#modal').fadeOut();
        });

        $("#limit").change(function() {
            limit=$(this).val();
            fetchRezervations(limit,pageNumber);
        });

        $('#search').on('input',function() {
            limit=$('#limit').val();
            fetchRezervations(limit,pageNumber);
        });

        function fetchRezervations(limit,pageNumber) {

            let formData={
                search:$('input[name="search"]').val(),
                year:$('select[name="year"]').val(),
                offset:(pageNumber-1)*limit,
                limit:limit
            };

            $.ajax({
                url:'{{route("rezervation.search")}}',
                type:'POST',
                contentType:'application/json',
                dataType:'json',
                data:JSON.stringify(formData),
                success:function(response) {
                    populateTable(response.data.rezervations);
                    renderPagination(response.data.totalRecord,limit,pageNumber);
                },
                error:function(xhr) { }
            });
        }

        function populateTable(data) {
            const tbody = $('#rezervation-list');
            tbody.empty();

            data.forEach((rezervation)=> {
                const row = `
                        <tr>
                            <td>${rezervation.enterHour}</td>
                            <td>${rezervation.exitHour}</td>
                            <td>${rezervation.rezervationDate}</td>
                            <td>
                                ${rezervation.paymentState == 1 ? "Ödendi" : "Ödenmedi"}
                            </td>
                            <td width="5">
                                <form action="{{route('rezervationUpdateForm')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="rezervationId" value="${rezervation.rezervationId}">
                                    <button style="border:none" type="submit">
                                        <a href="javascript:void()"><i class="fa fa-pencil-square"></i></a>
                                    </button>
                                </form>
                            </td>
                            <td width="5">
                                <a href="javascript:void()"><i id="${rezervation.rezervationId}" class="fa fa-trash-o"></i></a>
                            </td>
                            @if (session()->has('token') && session()->get('user')['role']=='admin')
                                <td width="5">
                                    <form action="{{route('payment.details')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="rezervationId" value="${rezervation.rezervationId}">
                                        <button style="border:none" type="submit">
                                            <a href="javascript:void()"><i class="fa fa-file-text"></i></a>
                                        </button>
                                    </form>
                                </td>
                            @endif
                            <td width="5">
                                <a href="javascript:void()"><i id="${rezervation.rezervationId}" class="fa fa-cutlery" data-toggle="tooltip" title="Menü"></i></a>
                            </td>
                        </tr> `;
                tbody.append(row);
            })
        }

        function renderPagination(totalRecord,limit,pageNumber) {
            const controls = $('#pagination-controls');
            controls.empty();
            let totalPage=1;

            if(totalRecord>limit) {
                totalPage=Math.ceil(totalRecord/limit);
            }

            // Önceki sayfa
            if (pageNumber > 1) {
                controls.append(`<button class="btn btn-secondary pagination-btn" data-page="${pageNumber - 1}">Önceki</button>`);
            }

            // Sayfa numaraları
            for (let i = 1; i <=totalPage; i++) {
                controls.append(`<button class="btn ${i === pageNumber ? 'btn-primary' : 'btn-secondary'} pagination-btn" data-page="${i}">${i}</button>`);
            }

            // Sonraki sayfa
            if (pageNumber<totalPage) {
                controls.append(`<button class="btn btn-secondary pagination-btn" data-page="${pageNumber + 1}">Sonraki</button>`);
            }
        }

        $(document).on('click','.pagination-btn', function () {
            pageNumber = $(this).data('page'); // Tıklanan sayfanın numarasını al
            fetchCustomers(limit,pageNumber);
        });

        $(document).on('click','.fa-trash-o',function() {

            let row = $(this).closest('tr');
            const requestData = {
                rezervationId:parseInt($(this).attr('id')) // ID'yi al
            };

            $.ajax({
                url:'{{route("rezervation.delete")}}', // API URL
                type:"POST", // HTTP POST metodu
                dataType:"json", // Dönen veri formatı (JSON bekleniyor)
                contentType:"application/json", // Gönderilen veri formatı
                data:JSON.stringify(requestData), // JSON verisini string'e çeviriyoruz
                success:function (response) {
                    row.css('display','none');
                    alertify.success(response.msg);
                },
                error:function (xhr,status,error) {
                    var errorMsg = xhr.responseJSON ? xhr.responseJSON.msg : error; // JSON mesaj veya genel hata
                    alertify.error(errorMsg);
                }
            });
        });

        $(document).on('click','.fa-cutlery',function() {
            $('#modal').fadeIn();
            let rezervationId=parseInt($(this).attr('id'));

            let requestData={
                rezervationId:rezervationId
            };

            $.ajax({
                url:'',
                type:'POST',
                contentType:'application/json',
                dataType:'json',
                data:JSON.stringify(requestData),
                success:function(response) {
                    $('#menu-price').empty();
                    $('#menu-list').empty();
                    $('#selected-menus').empty();
                    guest=parseInt(response.data.rezervation.guest);

                    $('#menu-price').append(`<strong style="color:red;">Toplam Menü Tutarı: <b>${response.data.rezervation.menuPrice} TL </b></strong>`);
                    $('#menu-list').append(`<br/><input id="guest-number" class="form-control" type="number" name="guest" value="${guest}">`);

                    $('input[name="rezervationId"]').val(rezervationId);

                    response.data.categories.forEach(category=> {
                        let menuOptions='';
                        category.menus.forEach(menu=> {
                            menuOptions=menuOptions+`<option value="${menu.menuId}" data-price="${menu.price}" >${menu.menuName}</option>`
                        });
                        const menus=`<br/><select id="select-menu" class="form-control" name="menus">
                                         <option disabled selected>${category.categoryName}</option>
                                         ${menuOptions}
                                    </select>`;

                        $('#menu-list').append(menus);
                    });

                    menuAdd(response); // menü dizisine ekle
                    menuAppend(response.data.selectedMenus); // menü dizisini ekrana bas
                },
                error:function() { }
            });
        });

        $('#close-form').on('click',function() {
            $('#modal').fadeOut();
        });

        $('#menu-list').on('change','#select-menu',function() { // liste dinamik yazıldığı için dom tekniğini kullandık
            let menuId=parseInt($(this).val());
            let menuName=$(this).find(':selected').text();
            let price=parseFloat($(this).find(':selected').data('price'));
            selectedMenus(menuId,price,menuName); // seçilen menüleri ekle
            menuAppend(menus);
            menuPriceCalculator();
        });

        $(document).on('input','#guest-number',function() {
            menuPriceCalculator();
        });

        $(document).on('click','.delete',function() {
            let menuId=parseInt($(this).parent('.item').data('value'));
            deleteMenu(menuId);
            menuPriceCalculator();
            menuAppend(menus);
        });

        function menuNameDelete() {
            menus.forEach(menu=>delete menu.menuName);
        }

        function menuAdd(response) { // öncelikle en başta gelen menüleri ekle
            menus=[];
            response.data.selectedMenus.forEach(menu=> {
                menus.push(menu);
            });
        }

        function deleteMenu(menuId) { // gönderilen menuId sine sahip menüyü siler
            let data=[];
            menus.forEach(menu=> {
                if(menu.menuId!==menuId) {
                    data.push(menu);
                }
            });
            menus=data;
        }

        function menuPriceCalculator() {
            totalMenuPrice=0;
            $('#menu-price').empty();
            guest=0;
            if($('input[name="guest"]').val().trim()!=='') {
                guest=parseInt($('input[name="guest"]').val());
            }

            menus.forEach(menu=> {
                totalMenuPrice=totalMenuPrice+parseFloat(menu.price);
            });

            totalMenuPrice=guest*totalMenuPrice;
            $('#menu-price').append(`<strong style="color:red;">Toplam Menü Tutarı: <b>${totalMenuPrice.toFixed(2)}</b></strong>`);
        }

        function selectedMenus(menuId,price,menuName) {

            let test=false;
            menus.forEach(menu=> {
                if(menu.menuId==menuId) {
                    test=true;
                }
            });

            if(test==false) {
                menus.push({menuId:menuId,price:price,menuName:menuName});
            }
        }

        function menuAppend(selectedMenus) {

            $('#selected-menus').empty();
            selectedMenus.forEach(menu=> {
                $('#selected-menus').append(
                    `<div class="item" data-value="${menu.menuId}">
                        <span class="delete">❌</span>
                        <span style="color:green;">${menu.menuName} - ${menu.price} TL</span>
                    </div>`);
            });
        }

    });

    </script>
@endsection


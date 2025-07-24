@extends('backend.layout')
@section('title','Lisans Ekle')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Lisans Ekle</h3>
            </div>
            <div class="box-body">
                <form id="licenceAddForm">
                    <div class="form-group">
                        <label>Başlık</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="title">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Açıklama</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="description">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Başlangıç Tarihi</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="date" name="startDate">
                            </div>
                        </div>
                    </div>
                    <div id="time" class="form-group">
                        <label>Süre</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select class="form-control" name="time">
                                    <option disabled selected value="0">Yıl Seçiniz</option>
                                    <option value="1">1 yıl</option>
                                    <option value="2">2 yıl</option>
                                    <option value="3">3 yıl</option>
                                    <option value="5">5 yıl</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Süreyi seçtiğinde bitiş tarihini kendi hesaplayacak -->
                    <div id="endDate" class="form-group">
                        <label>Bitiş Tarihi</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="date" name="endDate">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="forLife" id="forLifeCheckbox">
                            <label class="form-check-label" for="forLifeCheckbox">Ömür Boyu</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Seri No</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="serialNumber">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Kimden</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select class="form-control" name="from" id="from"></select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Birim</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select class="form-control" name="unit" id="unit"></select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Kime</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select class="form-control" name="toWhom" id="toWhom"></select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ana Kategori</label>
                        <div class="row">
                            <div class="col-xs-10 col-md-5">
                                <select class="form-control" id="mainCategoryId" name="mainCategoryId"></select>
                            </div>
                            <div class="col-xs-2 col-md-6">
                                <button type="button" class="btn btn-info fa fa-plus-circle" id="mainCategoryBtn"></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Özel Kategori</label>
                        <div class="row">
                            <div class="col-xs-10 col-md-5">
                                <select class="form-control" id="customCategoryId" name="customCategoryId"></select>
                            </div>
                            <div class="col-xs-2 col-md-6">
                                <button type="button" class="btn btn-info fa fa-plus-circle" id="customCategoryBtn"></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="display: none;" id="mainCategoryName">
                        <label>Ana Kategori</label>
                        <div class="row">
                            <div class="col-md-5">
                                <input type="text" name="mainCategoryName" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="display: none;" id="customCategoryName">
                        <label>Özel Kategori</label>
                        <div class="row">
                            <div class="col-md-5">
                                <input type="text" name="customCategoryName" class="form-control"/>
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
            let forLife=0;

            $('#forLifeCheckbox').change(function() {
                if ($(this).is(':checked')) {
                    forLife = 1;
                    $('#endDate').css('display','none');
                    $('#time').css('display','none');
                } else {
                    forLife = 0;
                    $('#endDate').css('display','block');
                    $('#time').css('display','block');
                }
            });

            $('#startDate').on('change',function () {
                let year = $('select[name="time"]').val();
                window.alert("");
            });

            $('select[name="time"]').on('change', function () {
                let time = parseInt($(this).val()); // Seçilen yıl miktarı (1, 2, 3)
                let startDate = $('input[name="startDate"]').val(); // "2024-07-21" gibi

                if (startDate !== "") {
                    let date = new Date(startDate);
                    date.setFullYear(date.getFullYear() + time);

                    $('input[name="endDate"]').val(date.toISOString().split('T')[0]);
                }
            });

            $('#mainCategoryBtn').on('click',function () {
                if($('#mainCategoryName').css('display')==='none') {
                    $('#mainCategoryName').css('display','block');
                }
                else {
                    $('#mainCategoryName').css('display','none');
                }
            });

            $('#customCategoryBtn').on('click',function () {
                if($('#customCategoryName').css('display')==='none') {
                    $('#customCategoryName').css('display','block');
                }
                else {
                    $('#customCategoryName').css('display','none');
                }
            });

            $('#unit').select2({
                placeholder: "Birim Arayınız...",
                allowClear: true,
                minimumInputLength: 2,
                language: "tr",

                ajax: {
                    url: "https://ikysapi.samsun.bel.tr/api/UnitTree/Select2UnitList",
                    type: "POST",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            Type: 4,
                            Name: params.term
                        };
                    },
                    processResults: function (res) {
                        return {
                            results: res.data.map(function (item) {
                                console.log(item);
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#from').select2({
                placeholder: "Kimden Kısmını Arayınız...",
                allowClear: true,
                minimumInputLength: 2,
                language: "tr",

                ajax: {
                    url: "https://ikysapi.samsun.bel.tr/api/Personel/Select2PersonelList",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            NameSurname: params.term // arama terimi
                        };
                    },
                    processResults: function (res) {
                        // API'nin döndürdüğü veriye göre uyarlayalım
                        return {
                            results: res.data.map(function (item) {
                                return {
                                    id: item.id, // uygun id alanı
                                    text: item.displayName
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#mainCategoryId').select2({
                placeholder: "Ana Kategoriyi Arayınız",
                allowClear: true,
                minimumInputLength: 2,
                language: "tr",

                ajax: {
                    url: "{{route('mainCategory.search')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term // arama terimi
                        };
                    },
                    processResults: function (res) {
                        // API'nin döndürdüğü veriye göre uyarlayalım
                        return {
                            results: res.data.map(function (item) {
                                return {
                                    id: item.mainCategoryId, // uygun id alanı
                                    text: item.mainCategoryName
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#toWhom').select2({
                placeholder: "Kime Kısmını Arayınız",
                allowClear: true,
                minimumInputLength: 2,
                language: "tr",

                ajax: {
                    url: "https://ikysapi.samsun.bel.tr/api/Personel/Select2PersonelList",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            NameSurname: params.term // arama terimi
                        };
                    },
                    processResults: function (res) {
                        // API'nin döndürdüğü veriye göre uyarlayalım
                        return {
                            results: res.data.map(function (item) {
                                console.log(item);
                                return {
                                    id: item.id, // uygun id alanı
                                    text: item.displayName
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#customCategoryId').select2({
                placeholder: "Özel Kategori Arayın",
                allowClear: true,
                minimumInputLength: 2,
                language: "tr",

                ajax: {
                    url: "{{route('customCategory.search')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term // arama terimi
                        };
                    },
                    processResults: function (res) {
                        // API'nin döndürdüğü veriye göre uyarlayalım
                        return {
                            results: res.data.map(function (item) {
                                return {
                                    id: item.customCategoryId, // uygun id alanı
                                    text: item.customCategoryName
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $("#licenceAddForm").submit(function(event) {
                event.preventDefault();

                formData={
                    title:$('input[name="title"]').val(),
                    description:$('input[name="description"]').val(),
                    startDate:$('input[name="startDate"]').val(),
                    endDate:$('input[name="endDate"]').val(),
                    time:$('input[name="time"]').val(),
                    from:$('input[name="from"]').val(),
                    toWhom:$('input[name="toWhom"]').val(),
                    serialNumber:$('input[name="serialNumber"]').val(),
                    mainCategoryId:parseInt($('select[name="mainCategoryId"]').val()),
                    customCategoryId:parseInt($('select[name="customCategoryId"]').val()),
                    mainCategoryName:$('input[name="mainCategoryName"]').val(),
                    customCategoryName:$('input[name="customCategoryName"]').val(),
                    forLife:forLife,
                };

                $.ajax({
                    url:'{{route('licence.add')}}',
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

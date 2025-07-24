@extends('backend.layout')
@section('title','Lisans Güncelle')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Lisans Güncelle</h3>
            </div>
            <div class="box-body">
                <form id="licenceUpdateForm">
                    <input type="hidden" name="licenceId" value="{{$data->licenceId}}">
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
                    <div id="endDate" class="form-group">
                        <label>Bitiş Tarihi</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="date" name="endDate">
                            </div>
                        </div>
                    </div>
                    <div id="time" class="form-group">
                        <label>Süre</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="time">
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
                                <input class="form-control" type="text" name="from">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Kime</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="text" name="toWhom">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ana Kategori</label>
                        <div class="row">
                            <div class="col-xs-10 col-md-5">
                                <select class="form-control" name="mainCategoryId">
                                    @foreach($data['mainCategories'] as $mainCategory)
                                        <option value="{{$mainCategory->mainCategoryId}}">{{$mainCategory->mainCategoryName}}</option>
                                    @endforeach
                                </select>
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
                                <select class="form-control" name="customCategoryId">
                                    @foreach($data['customCategories'] as $customCategory)
                                        <option value="{{$customCategory->customCategoryId}}">{{$customCategory->customCategoryName}}</option>
                                    @endforeach
                                </select>
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

            $('[name="endDate"]').on('change',function () {
                changeDate();
            });

            $('[name="startDate"]').on('change',function () {
                changeDate();
            });

            function changeDate() {
                let startDate = $('input[name="startDate"]').val();
                let endDate = $('input[name="endDate"]').val();

                if(startDate!=="" && endDate!=="") {
                    document.getElementsByName('time')[0].value=calculateDateDifference(startDate,endDate);
                }
            }

            function calculateDateDifference(date1Str,date2Str) {

                let date1 = new Date(date1Str);
                let date2 = new Date(date2Str);

                if (date1 > date2) {
                    [date1, date2] = [date2, date1];
                }

                let yearDiff = date2.getFullYear() - date1.getFullYear();
                let monthDiff = date2.getMonth() - date1.getMonth();
                let dayDiff = date2.getDate() - date1.getDate();

                if (dayDiff < 0) {
                    monthDiff -= 1;

                    let prevMonth = new Date(date2.getFullYear(), date2.getMonth(), 0); // Last day of previous month
                    dayDiff += prevMonth.getDate();
                }

                if (monthDiff < 0) {
                    yearDiff -= 1;
                    monthDiff += 12;
                }

                if(yearDiff===0) {
                    yearDiff = "";
                }
                else {
                    yearDiff = yearDiff + " yıl";
                }
                if(monthDiff===0) {
                    monthDiff = "";
                }
                else {
                    monthDiff = monthDiff + " ay";
                }
                if(dayDiff===0) {
                    dayDiff = "";
                }
                else {
                    dayDiff = dayDiff + " gün";
                }

                return `${yearDiff}  ${monthDiff}  ${dayDiff}`.trim();
            }


            $("#licenceUpdateForm").submit(function(event) {
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
                    url:'{{route('licence.update')}}',
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

@extends('backend.layout')
@section('title','Rezervasyon Ekle')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Rezervasyon Ekle</h3>
            </div>
            <div class="box-body">
                <form id="rezervationAddForm">
                    <div class="form-group">
                        <label>Başlama Saati</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="time" name="enterHour">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bitiş Saati</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="time" name="exitHour">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Rezervasyon Tarihi</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" type="date" name="rezervationDate">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select class="form-control" id="selectType">
                                    <option selected disabled>Rezervasyon Türü Seçiniz</option>
                                    @foreach ($data['types'] as $type)
                                        <option value="{{$type->typeId}}" data-name="{{$type->typeName}}" data-price="{{$type->price}}">
                                            {{$type->typeName}} - {{$type->price}} TL
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Seçilen Rezervasyon Türleri</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <div id="selectedTypes" style="margin-top: 20px; font-size: 15px; color: green;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Müşteriler</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select id="customer-select" class="form-control" name="customer">
                                    @foreach ($data['customers'] as $customer)
                                        <option value="{{$customer->customerId}}">{{$customer->name}} {{$customer->surname}}</option>
                                    @endforeach
                                </select>
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
    <style>
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
        $(document).ready(function() {

            let rezervationTypes=[];
            let selectedTypes=[];
            let totalPrice=0;

            $(document).on('change','#selectType',function () {

                totalPrice=0;
                const selectedOption=$(this).find(':selected'); // seçilen option değerini al
                const typeId=selectedOption.val();
                const typeName=selectedOption.data('name');
                const price=selectedOption.data('price');

                rezervationTypeAdd(rezervationTypes,typeId,price);
                selectedTypeAdd(selectedTypes,typeId,typeName,price);
                totalPrice=totalPriceCalculator(selectedTypes,totalPrice);
                selectedTypeAppend(selectedTypes,totalPrice);
            })

            $('#selectedTypes').on('click','.remove-type',function() {
                totalPrice = 0;
                selectedTypes = selectedTypes.filter(st=>st.typeId!==parseInt($(this).val()));
                rezervationTypes = rezervationTypes.filter(rt=>rt.typeId!==parseInt($(this).val()));
                totalPrice=totalPriceCalculator(selectedTypes,totalPrice);
                selectedTypeAppend(selectedTypes,totalPrice);
            });

            $('#customer-select').chosen({
                no_results_text: "Müşteri Bulunamadı"
            });

            $("#rezervationAddForm").submit(function(event) {
                event.preventDefault();
                var formData={
                    enterHour:$('input[name="enterHour"]').val(),
                    exitHour:$('input[name="exitHour"]').val(),
                    rezervationDate:$('input[name="rezervationDate"]').val(),
                    customerId:parseInt($('select[name="customer"]').val()),
                    rezervationTypes:rezervationTypes
                }

                $.ajax({
                    url:'{{route('rezervation.add')}}',
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

            $("#selectedTypes").on('input','input',function () {
                let price=0;
                if($(this).val().trim()!=='') {
                    price = parseFloat($(this).val());
                }
                let typeId = parseInt($(this).attr('id'));

                for (let i=0; i<rezervationTypes.length; i++) {
                    if(rezervationTypes[i].typeId===typeId) {
                        rezervationTypes[i].typeId=typeId;
                        rezervationTypes[i].price=price;
                    }
                }
            });
        });

        function selectedTypeAdd(selectedTypes,typeId,typeName,price) {
            let t = selectedTypes.find(st=>st.typeId===parseInt(typeId));
            if(!t) {
                selectedTypes.push({
                    typeId:parseInt(typeId),
                    typeName:typeName,
                    price:parseFloat(price)
                });
            }
        }

        function rezervationTypeAdd(rezervationTypes,typeId,price) {
            let rt = rezervationTypes.find(rt=>rt.typeId===typeId);
            if(!rt) {
                rezervationTypes.push({
                    typeId:parseInt(typeId),
                    price:parseFloat(price)
                });
            }
        }

        function rezervationTypeRemove(rezervationTypes,typeId) {
            return rezervationTypes.filter(rt=>rt.typeId!==parseInt(typeId));
        }

        function selectedTypeRemove(selectedTypes) {
            selectedTypes.filter(st=>st.typeId!==parseInt($(this).val()));
        }

        function selectedTypeAppend(selectedTypes,totalPrice) {
            $("#selectedTypes").empty();
            if(selectedTypes.length>0) {
                selectedTypes.forEach(type => {
                    $('#selectedTypes').append(`
                        <div class="form-group">
                            <label>${type.typeName}</label>
                            <div style="display: flex; gap: 10px; align-items: center;">
                            <input id="${type.typeId}" class="form-control" type="number" value="${type.price}" style="flex: 1;">
                                <button type="button" class="btn btn-danger btn-sm remove-type" value="${type.typeId}">
                                    &times;
                                </button>
                            </div>
                        </div>
                    `)
                });

                $('#selectedTypes').append(`
                    <br><strong style="color:red;">Toplam Tutar: </strong>${totalPrice.toFixed(2)} TL
                `);
            }
        }

        function totalPriceCalculator(selectedTypes,totalPrice) {
            selectedTypes.forEach(type=> {
                totalPrice = totalPrice + type.price;
            });
            return totalPrice;
        }

    </script>

@endsection

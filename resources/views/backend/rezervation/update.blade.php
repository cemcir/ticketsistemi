@extends('backend.layout')
@section('title','Rezervasyon Güncelle')
@section('content')
    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border" id="rezervationDetails" style="font-size: 15px; margin-top:10px;">
                <div class="col-md-3">
                    <strong style="color:blue;">Toplam Tutar:</strong><b id="totalPrice" style="color:blue;">{{number_format($data['rezervation']->totalPrice, 2, '.', '') }} TL</b><br/>
                </div>
                <div class="col-md-3">
                    <strong style="color:brown">Ödenen Tutar:</strong><b id="paymentPrice" style="color:brown;">{{number_format($data['rezervation']->paymentPrice,2,'.','')}} TL</b>
                </div>
                <div class="col-md-3">
                    <strong style="color:green;">Kalan Tutar:</strong><b id="remainderPrice" style="color:green;">{{number_format($data['rezervation']->remainderPrice, 2, '.', '') }} TL</b><br/>
                </div>
                <div class="col-md-3">
                    <strong style="color:red;">Ödeme Durumu:
                        @if ($data['rezervation']->paymentState==1)
                            <b id="paymentState" style="color:green;">Ödendi</b>
                        @else
                            <b id="paymentState" style="color:red;">Ödenmedi</b>
                        @endif
                    </strong>
                </div>
            </div>
            <div class="box-header with-border">
                <h3 class="box-title">Rezervasyon Güncelle</h3>
            </div>
            <div class="box-body">
                <form id="rezervationUpdateForm">
                    <input type="hidden" name="rezervationId" value="{{$data['rezervation']->rezervationId}}">
                    <div class="form-group">
                        <label>Başlama Saati</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" value="{{$data['rezervation']->enterHour}}" type="time" name="enterHour">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bitiş Saati</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" value="{{$data['rezervation']->exitHour}}" type="time" name="exitHour">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Rezervasyon Tarihi</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <input class="form-control" value="{{$data['rezervation']->rezervationDate}}" type="date" name="rezervationDate">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Müşteriler</label>
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <select id="customer-select" class="form-control" name="customer">
                                    @foreach($data['customers'] as $customer)
                                        @if($customer->customerId == $data['rezervation']->customerId)
                                            <option selected value="{{ $customer->customerId }}">{{ $customer->name }} {{ $customer->surname }}</option>
                                        @else
                                            <option value="{{ $customer->customerId }}">{{ $customer->name }} {{ $customer->surname }}</option>
                                        @endif
                                    @endforeach
                                </select>
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

            $("#rezervationUpdateForm").submit(function(event) {
                event.preventDefault();
                var formData={
                    rezervationId:parseInt($('input[name="rezervationId"]').val()),
                    enterHour:$('input[name="enterHour"]').val(),
                    exitHour:$('input[name="exitHour"]').val(),
                    rezervationDate:$('input[name="rezervationDate"]').val(),
                    customerId:parseInt($('select[name="customer"]').val())
                }

                $.ajax({
                    url: '{{route("rezervation.update")}}', // Burada formun gönderileceği route'u belirtin
                    type: 'POST',
                    contentType: 'application/json', // Gönderilecek verinin JSON formatında olduğunu belirtiyoruz
                    data: JSON.stringify(formData),  // Verileri JSON formatında gönderiyoruz
                    success: function(response) {
                        alertify.success(response.msg);
                    },
                    error: function (xhr, status, error) {
                        let errorMsg = xhr.responseJSON ? xhr.responseJSON.msg : error; // JSON mesaj veya genel hata
                        alertify.error(errorMsg);
                    }
                })
            })

            $('#customer-select').select2({
                placeholder: "Müşteri Seçiniz",
                allowClear: true
            });
        });
    </script>

@endsection




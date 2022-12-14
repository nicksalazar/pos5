@php
    $establishment = $document->establishment;
    $logo = "storage/uploads/logos/{$company->logo}";
    if($establishment->logo) {
        $logo = "{$establishment->logo}";
    }
    
    $document_number = $establishment->code.''.substr($document->series,1,3).''.str_pad($document->number, 9, '0', STR_PAD_LEFT);
    $url =  public_path("storage/uploads/logos/".$company->logo);
    @endphp

<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Envio de Comprobante de Pago Electrónico</title>
        <style>
            body {
                color: #000;
            }
            ul {
                list-style: none;
            }
            .main {
                display: grid;
                background: #f5f7f9;
                padding: 40px 0px;
                text-align: center;
            }
            .fdiv {
                background: white;
                width: 50%;
                margin: 0 auto;
                border-bottom: 1px solid #e4e8ea;
            }
            .fdiv > h1 {
                font-size: 55px;
				margin: 0;
			}
            #value {
				font-size: 15px;
				margin-bottom: 0;
			}
			#value1 {
				margin: 12px 0;
				font-size: 15px;
			}
			#value2 {
				margin-bottom: 15px;
				font-size: 15px;
			}
			.fdiv > h2 {
                font-size: 30px;
				margin-top: 0;
			}
            #title1 {
				color: gray;
				margin-bottom: 0;
                padding-left: 90px;
			}
            #title {
                color: gray;
            }
            .solid {
                width: 80%;
                border-top: 1px solid #e4e8ea;
            }
            .sdiv {
                background: #e4e8ea;
                width: 50%;
                margin: 0 auto;
            }
            .tdiv {
                background: #dce4e4;
                width: 50%;
                height: 40px;
                margin: 0 auto;
            }
            .btn1 {
				margin-bottom: 25px;
                background: #348eda;
                border: 0;
                color: white;
                padding: 10px 25px;
                border-radius: 20px;
			}
            .btn2 {
                width: 40%;
                height: 40px;
                margin: 0 auto;
                background: white;
                border: 0;
            }
        </style>
    </head>
    <body>
        <!-- Code1
        <p>Estimad@: 
            @if($document->customer)
                {{ $document->customer->name }}
            @else
                {{ $document->supplier->name }}
            @endif
            , informamos que su comprobante electrónico ha sido emitido exitosamente.</p>
        <p>Los datos de su comprobante electrónico son:</p>
        <ul>
            <li>Razon social: {{ $company->name }}</li>
            <li>Teléfono: {{ $document->establishment->telephone }}</li>
        {{--    <li>Tipo de comprobante: {{ $document->document_type->description }}</li>--}}
            <li>Fecha de emisión: {{ $document->date_of_issue->format('d/m/Y') }}</li>
            <li>Nro. de comprobante: {{ $document->series.'-'.$document->number }}</li>
            <li>Total: {{ $document->total }}</li>
        </ul>
        -->


        <!-- JOINSOFTWARE Code2 -->
        <div class="main">
            <div class="fdiv">
                <img alt="logo" src="{{ asset('logo/logo2.png') }}" width="70%" height="100%">
                 </div>
            <div class="fdiv">
                <h3 id="title">{{ $company->name }}</h3>
                <h3 id="title">Has recibido un Documento Electrónico de</h3>
                @if($company->logo)
                <!--<img src="data:{{mime_content_type(public_path("storage/uploads/logos/{$company->logo}"))}};base64, {{base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}")))}}" alt="{{$company->name}}" class="company_logo" style="max-width: 150px;">
                -->
                <img alt="{{$company->name}}" src="{{ $url }}" width="50px" height="50px">
                
                @else
                <img alt="logo" src="{{ asset('logo/logo.jpg') }}" width="50px" height="50px">
                @endif
                <hr class="solid">
                <h3>FAC {{ $document_number }}</h3>
            </div>
            <div class="sdiv">
                <h6 id="value1">Fecha Emisión: {{$document->date_of_issue->format('m-d-Y')}}</h6>
            </div>
            <div class="fdiv">
                <h6 id="value">Por el valor de:</h6>
                <h2>{{ $document->currency_type->symbol }}{{ $document->total }}</h2>
            </div>
            <!--
            <div class="fdiv">
                <h6 id="value2">Consulta el comprobante detallado en línea:</h6>
                <button class="btn1">VER DOCUMENTO</button>
            </div>
            -->
            <!--<button class="btn2">Descargar XML</button>-->
            <p class="btn2">Adjunto encontrará los archivos pdf y xml de su factura</p>
            <div class="tdiv"></div>
        </div>
    </body>
</html>
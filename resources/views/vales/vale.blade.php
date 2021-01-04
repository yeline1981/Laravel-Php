<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vale Venta</title>
    <style type="text/css">
       .grid-cont{
            display:grid;
            grid-gap: 7px 0px;
            font-size:14px;
            font-family: sans-serif;
            font-weight: 300;
            height:14.5cm;
            overflow: hidden;
            grid-template-rows: 0fr 0fr auto auto;
        }
        .grid-scont{
        /* border: solid 1px black;*/
            padding: 10px;
        }
        .grid-item{
            /*border:solid 1px red;*/
            /*display:flex;*/
            object-fit: contain;
            line-height: 1.5em;
        }
        .or-header{
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            padding-bottom:0px;
        }
        .or-header-logo{
            grid-row:1/3;
        }
        .or-header-logo img{
            height: 65px;
            object-fit:contain;
        }
        .or-header-id, .or-header-date{
            margin-left:100px;
        }
        .or-header-idout, .or-header-dateout{
            padding-left: 10px;
        }
        .or-client{
            border: solid 1px #A8A8A8;
            display:grid;
            grid-template-columns: 1fr 1fr;
        }
        .or-aviso{
            border: solid 1px #A8A8A8;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
        }
        .or-aviso-text{
            grid-column: 1/4;
            line-height: 1.2em;
        }
        .or-aviso-cat{
            grid-column: 1/4;
        }
        .or-aviso-dest{
            grid-column: 1/4;
        }
        .or-foot{
            padding-top:0px;
            display:grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
        }
        .or-foot-precio, .or-foot-saf, .or-foot-total {
            grid-column:span 2;
        }
        .or-foot-entrega, .or-foot-saf, .or-foot-total {
            grid-column:span 4;
        }
        .or-foot-conforme, .or-foot-sign {
            grid-column: span 3;
        }
        .or-foot-signtext{
            grid-column:span 3;
        }
        .or-foot-sign, .or-foot-signtext{
            text-align: center;
        }
        .or-foot-conforme  {
            margin-top: 10px;
        }
        .or-foot-sign{
            margin-top:15px;
        }
        .or-foot-small{
            grid-column:span 6;
            font-size:6pt;
            line-height: normal;
        }
        .editor{
            border:0px;
            margin:0px;
            width: auto;
            padding:0;
        }
        .textopub{
            margin-right: 10px;
        }

        .panel-heading {
            display: inline-block;
            width: 100%;
        }
        @media print {
            .wrapper{
                padding-top: 0px;
                margin-top: 0px;
            }
            .panel-body {
                padding-top:0px;
            }
        }

        .dont-print-that{display:none;}
    </style>

</head>
<body>

    <section id="main-content">
        <section class="wrapper">
            <header class="panel-heading hidden-print">
                <div style="float:right;">
                    <a href="#" onclick="printContent('imprimible')">
                    <i class="icon-printer"></i> Imprimir</a>
                </div>
            </header>

            <!-- page start-->
            <div id="imprimible" class="panel" style="width:20cm">
                <div id="original" class="grid-cont">
                    <div class="or-header grid-scont">
                        <div class="or-header-logo grid-item">
                            <img src=" {{ asset('admin/img/brand/logo-ie.svg') }}" >
                        </div>
                        <div class="or-header-id grid-item">
                            Orden Nº:
                        </div>
                        <div class="or-header-idout grid-item" >
                            {{ $nuevo->id }}
                        </div>
                        <div class="or-header-date grid-item">
                            Fecha:
                        </div>
                        <div class="or-header-dateout grid-item" >
                            {{$nuevo->created_at}}
                        </div>
                    </div>

                    <div class="or-client grid-scont">
                        <div class="or-client-client grid-item">
                            Cliente: {{$nuevo->nombre}}
                        </div>
                        <div class="or-client-ci grid-item">
                            Rut/CI: {{$nuevo->idcliente}}
                        </div>
                        <div class="or-client-dir grid-item">
                            Dirección: {{$nuevo->direccion}}
                        </div>
                        <div class="or-client-tel grid-item">
                            Tel: {{$nuevo->telefono}}</td>
                        </div>
                    </div>

                    <div class="or-aviso grid-scont">
                        <div class="or-aviso-text grid-item">
                            Tipo Trabajo: {{$nuevo->grupo}} / {{$nuevo->tipo}}
                        </div>

                        <div class="or-aviso-cat grid-item">
                            Cantidad: {{$nuevo->cantidad}}
                        </div>

                        <div class="or-aviso-cantp grid-item">
                            Papel: {{$nuevo->papel}}
                        </div>
                        <div class="or-aviso-pri grid-item">
                            Formato: {{$nuevo->formato}}
                        </div>

                        <div class="or-aviso-ult grid-item">
                            Sangrado: {{$nuevo->sangrado}}
                        </div>

                        <div class="or-aviso-cantp grid-item">
                            Impresión Frente: {{$nuevo->frente}}
                        </div>

                        <div class="or-aviso-pri grid-item">
                            Impresión Dorso: @if ($nuevo->dorso == '') - @else {{$nuevo->dorso}} @endif
                        </div>

                        <div class="or-aviso-text grid-item">
                            Recubrimiento: {{$nuevo->recubrimiento}}
                        </div>

                        <div class="or-aviso-text grid-item">
                            Contenido: {{$nuevo->contenido}}
                        </div>
                    </div>

                    <div class="or-aviso grid-scont">
                        <div class="or-aviso-text grid-item">
                            Diseño: @if ($nuevo->diseno == 1) Necesito que me resuelvan el diseño @endif
                        </div>

                        <div class="or-aviso-cat grid-item">
                            Observaciones: <br>
                            @if ($nuevo->grupo == 'Imprenta Autorizada' || $nuevo->grupo == 'Talonarios')
                                Encuadernado: {{$nuevo->encuadernado}} <br>
                                Vías: {{$nuevo->vias}}
                            @endif
                        </div>
                    </div>

                    <div class="or-foot grid-scont">
                        <div class="or-foot-precio grid-item" >
                            Precio: ${{ $nuevo->precio}}
                        </div>

                        <div class="or-foot-precio grid-item" >
                            Iva: ${{ $nuevo->iva}}
                        </div>

                        <div class="or-foot-precio grid-item" >
                            Total: ${{ $nuevo->total}}
                        </div>

                        <div class="or-foot-entrega grid-item" >
                            Entrega: ${{ $nuevo->senado}} (mínimo 60%)
                        </div>

                        <div class="or-foot-precio grid-item" >
                            Saldo: ${{ $nuevo->total - $nuevo->senado }}
                        </div>


                        <div class="or-foot-sign grid-item">
                        _______________________________________
                        </div>
                        <div class="or-foot-signtext grid-item">
                        </div>
                        <div class="or-foot-signtext grid-item">
                            Firma Cliente
                        </div>

                    </div>

                </div>

                <div style="margin:10px; clear:both; border-top: dashed 1px #a8a8a8"></div>

                <div id="copia" class="grid-cont">
                <div class="or-header grid-scont">
                        <div class="or-header-logo grid-item">
                            <img src=" {{ asset('admin/img/brand/logo-ie.svg') }}" >
                        </div>
                        <div class="or-header-id grid-item">
                            Orden Nº:
                        </div>
                        <div class="or-header-idout grid-item" >
                            {{ $nuevo->id }}
                        </div>
                        <div class="or-header-date grid-item">
                            Fecha:
                        </div>
                        <div class="or-header-dateout grid-item" >
                            {{$nuevo->created_at}}
                        </div>
                    </div>

                    <div class="or-client grid-scont">
                        <div class="or-client-client grid-item">
                            Cliente: {{$nuevo->nombre}}
                        </div>
                        <div class="or-client-ci grid-item">
                            Rut/CI: {{$nuevo->idcliente}}
                        </div>
                        <div class="or-client-dir grid-item">
                            Dirección: {{$nuevo->direccion}}
                        </div>
                        <div class="or-client-tel grid-item">
                            Tel: {{$nuevo->telefono}}</td>
                        </div>
                    </div>

                    <div class="or-aviso grid-scont">
                        <div class="or-aviso-text grid-item">
                            Tipo Trabajo: {{$nuevo->grupo}} / {{$nuevo->tipo}}
                        </div>

                        <div class="or-aviso-cat grid-item">
                            Cantidad: {{$nuevo->cantidad}}
                        </div>

                        <div class="or-aviso-cantp grid-item">
                            Papel: {{$nuevo->papel}}
                        </div>
                        <div class="or-aviso-pri grid-item">
                            Formato: {{$nuevo->formato}}
                        </div>

                        <div class="or-aviso-ult grid-item">
                            Sangrado: {{$nuevo->sangrado}}
                        </div>

                        <div class="or-aviso-cantp grid-item">
                            Impresión Frente: {{$nuevo->frente}}
                        </div>

                        <div class="or-aviso-pri grid-item">
                                Impresión Dorso: @if ($nuevo->dorso == '') - @else {{$nuevo->dorso}} @endif
                        </div>

                        <div class="or-aviso-text grid-item">
                            Recubrimiento: {{$nuevo->recubrimiento}}
                        </div>
                        <div class="or-aviso-text grid-item">
                            Contenido: {{$nuevo->contenido}}
                        </div>
                    </div>

                    <div class="or-aviso grid-scont">
                        <div class="or-aviso-text grid-item">
                            Diseño: @if ($nuevo->diseno == 1) Necesito que me resuelvan el diseño @endif
                        </div>

                        <div class="or-aviso-cat grid-item">
                            Observaciones: <br>
                            @if ($nuevo->grupo == 'Imprenta Autorizada' || $nuevo->grupo == 'Talonarios')
                                Encuadernado: {{$nuevo->encuadernado}} <br>
                                Vías: {{$nuevo->vias}}
                            @endif
                        </div>
                    </div>

                    <div class="or-foot grid-scont">
                        <div class="or-foot-precio grid-item" >
                            Precio: ${{ $nuevo->precio}}
                        </div>

                        <div class="or-foot-precio grid-item" >
                            Iva: ${{ $nuevo->iva}}
                        </div>

                        <div class="or-foot-precio grid-item" >
                            Total: ${{ $nuevo->total}}
                        </div>

                        <div class="or-foot-entrega grid-item" >
                            Entrega: ${{ $nuevo->senado}} (mínimo 60%)
                        </div>

                        <div class="or-foot-precio grid-item" >
                            Saldo: ${{ $nuevo->total - $nuevo->senado }}
                        </div>


                        <div class="or-foot-sign grid-item">
                        _______________________________________
                        </div>
                        <div class="or-foot-signtext grid-item">
                        </div>
                        <div class="or-foot-signtext grid-item">
                            Firma Cliente
                        </div>

                    </div>
                </div>
            </div>
            <!-- page end -->
        </section>
    </section>

    <script type="text/javascript">
	    function printContent(el){
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
         }
    </script>

</body>
</html>

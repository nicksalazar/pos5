<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Importaciones</title>
    </head>
    <body>
        <div>
            <h3 align="center" class="title"><strong>Reporte liquidación de importacion</strong></h3>

        </div>
        <br>
        @if(!empty($records))
            <div class="">
                <div class=" ">
                    <table class="">
                        <thead>
                            <tr>
                                <th>Serie</th>
                                <th>Número</th>
                                <th>Importacion</th>
                                <th>Numero línea</th>
                                <th>Código artículo</th>
                                <th>Referencia</th>
                                <th>Descripción</th>
                                <th>Partida arancelaria</th>
                                <th>Porcentaje Advaloren</th>
                                <th>Unidades total</th>
                                <th>FOB</th>
                                <th>FOB total</th>
                                <th>Flete</th>
                                <th>Flete total</th>
                                <th>Seguro</th>
                                <th>Seguro total</th>
                                <th>CIF</th>
                                <th>Valor ADVALOREN</th>
                                <th>FODINFA</th>
                                <th>IVA</th>
                                <th>Gastos</th>
                                <th>Gastos Total</th>
                                <th>Costo</th>
                                <th>Total linea</th>
                                <th>Factor</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $key => $value)
                            <tr>
                                <td class="celda">{{$value['serie']}}</td>
                                <td class="celda">{{$value['numero']}}</td>
                                <td class="celda">{{$value['importacion']}}</td>
                                <td class="celda">{{$value['numLinea']}}</td>
                                <td class="celda">{{$value['codArticulo']}}</td>
                                <td class="celda">{{$value['referencia'] }}</td>
                                <td class="celda">{{$value['descripcion'] }}</td>
                                <td class="celda">{{$value['partidaArancelaria'] }}</td>
                                <td class="celda">{{$value['porcentajeAdvaloren'] }}</td>
                                <td class="celda">{{$value['unidadestotal'] }}</td>
                                <td class="celda">{{$value['fob'] }}</td>
                                <td class="celda">{{$value['fobTotal'] }}</td>
                                <td class="celda">{{$value['flete'] }}</td>
                                <td class="celda">{{$value['fleteTotal'] }}</td>
                                <td class="celda">{{$value['seguro'] }}</td>
                                <td class="celda">{{$value['seguroTotal'] }}</td>
                                <td class="celda">{{$value['cif'] }}</td>
                                <td class="celda">{{$value['advaloren'] }}</td>
                                <td class="celda">{{$value['fodinfa'] }}</td>
                                <td class="celda">{{$value['iva'] }}</td>
                                <td class="celda">{{$value['gastos'] }}</td>
                                <td class="celda">{{$value['gastosTotal'] }}</td>
                                <td class="celda">{{$value['costo'] }}</td>
                                <td class="celda">{{$value['totalLinea'] }}</td>
                                <td class="celda">{{$value['factor'] }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div>
                <p>No se encontraron registros.</p>
            </div>
        @endif
    </body>
</html>

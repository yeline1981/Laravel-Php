@extends('principal')
@section('contenido')

    @if(Auth::check())
        @if (Auth::user()->role == 'System')
            <template v-if="menu==1">
                <crearusuario-component :ruta="ruta"></crearusuario-component>
            </template>

            <template v-if="menu==3">
                <listarusuario-component :ruta="ruta"></listarusuario-component>
            </template>

        @elseif (Auth::user()->role == 'Administrador')

            <template v-if="menu==1">
                <crearusuario-component :ruta="ruta"></crearusuario-component>
            </template>

            <template v-if="menu==3">
                <listarusuario-component :ruta="ruta"></listarusuario-component>
            </template>

            <template v-if="menu==9">
                <crearcliente-component :ruta="ruta"></crearcliente-component>
            </template>

            <template v-if="menu==11">
                <listarclientes-component :ruta="ruta"></listarclientes-component>
            </template>

            <template v-if="menu==6">
                <deudores-component :ruta="ruta"></deudores-component>
            </template>

            <template v-if="menu==4">
                <cajageneral-component :ruta="ruta"></cajageneral-component>
            </template>

            <template v-if="menu==5">
                <facturacion-component :ruta="ruta"></facturacion-component>
            </template>

            <template v-if="menu==7">
                <cajadiaria-component :ruta="ruta"></cajadiaria-component>
            </template>

            <template v-if="menu==12">
                <listarpendientes-component :ruta="ruta"></listarpendientes-component>
            </template>

            <template v-if="menu==10">
                <listartrabajos-component :ruta="ruta" ></listartrabajos-component>
            </template>

            <template v-if="menu==13">
                <nuevo-component :ruta="ruta" :tipo="3"></nuevo-component>
            </template>

            <template v-if="menu==24">
                <reporte-component :ruta="ruta"></reporte-component>
            </template>

            <template v-if="menu==25">
                <tendencia-component :ruta="ruta"></tendencia-component>
            </template>

            <template v-if="menu==15">
                <mockup-component :ruta="ruta"></mockup-component>
            </template>

        @elseif (Auth::user()->role == 'Diseñador')

            <template v-if="menu==10">
                <listartrabajos-component :ruta="ruta"></listartrabajos-component>
            </template>

        @else (Auth::user()->role == 'Vendedor')

            <template v-if="menu==9">
                <crearcliente-component :ruta="ruta"></crearcliente-component>
            </template>

            <template v-if="menu==11">
                <listarclientes-component :ruta="ruta"></listarclientes-component>
            </template>

            <template v-if="menu==12">
                <listarpendientes-component :ruta="ruta"></listarpendientes-component>
            </template>

            <template v-if="menu==10">
                <listartrabajos-component :ruta="ruta" ></listartrabajos-component>
            </template>

            <template v-if="menu==13">
                <nuevo-component :ruta="ruta" :tipo="3"></nuevo-component>
            </template>

            <template v-if="menu==6">
                <deudores-component :ruta="ruta"></deudores-component>
            </template>

            <template v-if="menu==4">
                <cajageneral-component :ruta="ruta"></cajageneral-component>
            </template>

            <template v-if="menu==5">
                <facturacion-component :ruta="ruta"></facturacion-component>
            </template>

            <template v-if="menu==7">
                <cajadiaria-component :ruta="ruta"></cajadiaria-component>
            </template>

        @endif

    @endif

@endsection

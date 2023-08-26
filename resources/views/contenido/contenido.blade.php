@extends('principal')
@section('contenido')

<template v-if="menu==0">
    <facturacion></facturacion>
</template>

<template v-if="menu==1">
    <empresa></empresa>
</template>

<template v-if="menu==2">
    <usuarios></usuarios>
</template>

<template v-if="menu==3">
    <clientes></clientes>
</template>

<template v-if="menu==4">
    <ciudades></ciudades>
</template>

<template v-if="menu==5">
    <empleados></empleados>
</template>

<template v-if="menu==6">
    <control></control>
</template>

<template v-if="menu==7">
    <proveedores></proveedores>
</template>

<template v-if="menu==8">
    <asientos></asientos>
</template>

<template v-if="menu==9">
    <cobros></cobros>
</template>

<template v-if="menu==10">
    <departamentos></departamentos>
</template>

<template v-if="menu==11">
    <tipofactura></tipofactura>
</template>

<template v-if="menu==12">
    <pagos></pagos>
</template>

<template v-if="menu==13">
    <pedidos></pedidos>
</template>

<template v-if="menu==14">
    <productos></productos>
</template>

<template v-if="menu==15">
    <grupos></grupos>
</template>

<template v-if="menu==16">
    <impuesto></impuesto>
</template>

<template v-if="menu==17">
    <medida></medida>
</template>

<template v-if="menu==18">
    <empleados></empleados>
</template>

<template v-if="menu==19">
    <reservas></reservas>
</template>

<template v-if="menu==20">
    <habitacion></habitacion>
</template>

<template v-if="menu==21">
    <ocupacion></ocupacion>
</template>

<template v-if="menu==22">
    <tipo></tipo>
</template>

<template v-if="menu==23">
    <areas></areas>
</template>

<template v-if="menu==24">
    <procesos></procesos>
</template>

<template v-if="menu==25">
    <perfiles></perfiles>
</template>

<template v-if="menu==26">
    <unidades></unidades>
</template>

<template v-if="menu==27">
    <materias></materias>
</template>

<template v-if="menu==28">
    <gestionmaterias></gestionmaterias>
</template>

<template v-if="menu==29">
    <colecciones></coleciones>
</template>

<template v-if="menu==30">
    <hojas></hojas>
</template>

<template v-if="menu==31">
    <conceptos></conceptos>
</template>

<template v-if="menu==32">
    <maquinarias></maquinarias>
</template>

<template v-if="menu==33">
    <roles></roles>
</template>

<template v-if="menu==34">
    <admin></admin>
</template>

<template v-if="menu==35">
    <ninguno></ninguno>
</template>

<template v-if="menu==36">
    <configuracion></configuracion>
</template>

<template v-if="menu==37">
    <simulador></simulador>
</template>

<template v-if="menu==38">
    <cotizacion></cotizacion>
</template>

<template v-if="menu==39">
    <ordendepedido></ordendepedido>
</template>

<template v-if="menu==40">
    <kardexalmacen></kardexalmacen>
</template>

<template v-if="menu==41">
    <kardexproducto></kardexproducto>
</template>

<template v-if="menu==42">
    <tomainventarios></tomainventarios>
</template>

<template v-if="menu==43">
    <manual></manual>
</template>

<template v-if="menu==44">
    <cartilla></cartilla>
</template>

<template v-if="menu==45">
    <cartilladigital></cartilladigital>
</template>

<template v-if="menu==46">
    <videotutoriales></videotutoriales>
</template>

<template v-if="menu==47">
    <tiempoestandar></tiempoestandar>
</template>

<template v-if="menu==48">
    <vinculacion></vinculacion>
</template>

<template v-if="menu==49">
    <cierrenomina></cierrenomina>
</template>

<template v-if="menu==50">
    <precioventa></precioventa>
</template>

<template v-if="menu==51">
    <puntoequilibrio></puntoequilibrio>
</template>

<template v-if="menu==52">
    <endeudamiento></endeudamiento>
</template>

<template v-if="menu==53">
    <liquidez></liquidez>
</template>

<template v-if="menu==54">
    <rotacioninventario></rotacioninventario>
</template>

<template v-if="menu==55">
    <rotacioncartera></rotacioncartera>
</template>

<template v-if="menu==56">
    <simuladorfinanciero></simuladorfinanciero>
</template>

<template v-if="menu==57">
    <rentabilidad></rentabilidad>
</template>

<template v-if="menu==58">
    <vistapersonalizada></vistapersonalizada>
</template>

<template v-if="menu==59">
    <pruebas></pruebas>
</template>

@endsection

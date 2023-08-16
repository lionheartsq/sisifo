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
    <facturas></facturas>
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
    <tipofactura></tipofactura>
</template>
@endsection

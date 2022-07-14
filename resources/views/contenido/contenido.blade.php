@extends('principal')
@section('contenido')

<template v-if="menu==0">
    <bienvenida></bienvenida>
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
@endsection

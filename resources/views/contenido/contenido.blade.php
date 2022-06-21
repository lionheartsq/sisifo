@extends('principal')
@section('contenido')

<template v-if="menu==0">
    <bienvenida></bienvenida>
</template>
<template v-if="menu==1">
    <usuarios></usuarios>
</template>

@endsection

@extends('principal')
@section('contenido')
    <template v-if="menu==11">
        <categoria></categoria>
    </template>
    <template v-if="menu==1">
        <ciudad></ciudad>
    </template>
    <template v-if="menu==2">
        <cliente></cliente>
    </template>
    <template v-if="menu==3">
        <departamento></departamento>
    </template>
    <template v-if="menu==4">
        <usuario></usuario>
    </template>
    <template v-if="menu==5">
        <entrada></entrada>
    </template>
    <template v-if="menu==6">
        <factura></factura>
    </template>
    <template v-if="menu==7">
        <marca></marca>
    </template>
    <template v-if="menu==8">
        <producto></producto>
    </template>
    <template v-if="menu==9">
        <proveedor></proveedor>
    </template>
    <template v-if="menu==10">
        <salida></salida>
    </template>
@endsection
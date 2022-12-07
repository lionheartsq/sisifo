<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Facturación</li>
                </ol>
                      <!-- Listado -->
                <template v-if="listado">
                    <!-- Ejemplo de tabla Listado -->
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">Cliente <span v-if="selecteduserCustom"></span></label>
                                                    <vue-typeahead-bootstrap
                                                    class="col-md-9"
                                                    v-model="cedula"
                                                    :data="clientesFiltro"
                                                    :showOnFocus="true"
                                                    :ieCloseFix="false"
                                                    :serializer="item => item.cedula"
                                                    @hit="selecteduserCustom = $event"
                                                    :disabledValues="(selecteduserCustom ? [selecteduserCustom.nombres] : [])"
                                                    placeholder="Ingrese cédula del cliente"
                                                    @input="lookupUserCustom"
                                                    :background-variant-resolver="(user) => ((user.cedula % 2) == 0) ? 'light':'dark'"
                                                    />
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">Nombres Cliente</label>
                                                    <div class="col-md-9">
                                                        <input type="text" v-model="nombres" class="form-control" placeholder="Nombres del cliente">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">Apellidos Cliente</label>
                                                    <div class="col-md-9">
                                                        <input type="text" v-model="apellidos" class="form-control" placeholder="Apellidos del cliente">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                                    <div class="col-md-9">
                                                        <input type="text" v-model="direccion" class="form-control" placeholder="Direccion del cliente">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                                    <div class="col-md-9">
                                                        <input type="text" v-model="telefono" class="form-control" placeholder="Telefono del cliente">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">Correo</label>
                                                    <div class="col-md-9">
                                                        <input type="text" v-model="correo" class="form-control" placeholder="Correo del cliente">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">Tipo Factura</label>
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="radio" v-model="tipoFactura" value="1"> Contado
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="radio" v-model="tipoFactura" value="2"> Crédito
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">Consecutivo</label>
                                                    <div class="col-md-9">
                                                        <input type="text" v-model="consecutivo" class="form-control" placeholder="Consecutivo" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">Fecha</label>
                                                    <div class="col-md-9">
                                                        <input type="date" v-model="fecha" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">Valor antes de iva</label>
                                                    <div class="col-md-9">
                                                        <input type="text" v-model="valor" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">Iva</label>
                                                    <div class="col-md-9">
                                                        <input type="text" v-model="impuesto" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">Total</label>
                                                    <div class="col-md-9">
                                                        <input type="text" v-model="total" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label" for="text-input">Obervaciones</label>
                                                    <div class="col-md-9">
                                                        <input type="text" v-model="observaciones" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                            <button type="button" class="btn btn-primary" @click="crearFacturas()">Guardar</button>
                        </div>
                    </div>

                </template>
                    <!-- Fin Listado -->

                    <!-- Detalle -->
                    <template v-else>
                        <div class="container-fluid">
                            <div class="card">
                                <vs-tabs :color="colorx">

                                <vs-tab label="Materia Prima" icon="open_with" @click="colorx = '#8B0000'">

                                    <div class="card-header">
                                        <i class="fa fa-align-justify"></i> Producto: {{this.productoNombre}} &nbsp;
                                        <button type="button" @click="abrirModal('gestionMateria','crear','arrayGestionMaterias')" class="btn btn-secondary">
                                            <i class="icon-plus"></i>&nbsp;Nueva materia prima
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        <materiaprima v-bind:identificador="identificador" :key="componentKey" @abrirmodal="abrirModal" @eliminarMateriaPrimaProducto="eliminarMateriaPrimaProducto"></materiaprima>
                                    </div>

                                </vs-tab>

                                <vs-tab label="Detallado" icon="format_list_numbered" @click="colorx = '#9B59B6'">

                                    <div class="card-header">
                                        <i class="fa fa-align-justify"></i> Producto: {{this.productoNombre}} &nbsp;
                                    </div>

                                    <div class="card-body">
                                        <hojadecostosdetalle v-bind:identificador="identificador" :key="componentKey"></hojadecostosdetalle>
                                    </div>

                                </vs-tab>

                                <vs-tab label="Cerrar" icon="cancel_schedule_send" @click="ocultarDetalle()">
                                </vs-tab>

                                </vs-tabs>
                            </div>
                        </div>
                    </template>
                    <!-- Fin Detalle -->
        </main>
</template>

<script>
    import {debounce} from 'lodash';
    import moment from 'moment';
import Swal from 'sweetalert2';
    import detallefacturas from '../components/Detallefacturas';
    export default {
        components: {
            detallefacturas
        },
        data(){
            return{
                selecteduser: null,
                clientesFiltro: [],
                selecteduserCustom: [],
                correo: '',
                cedula: '',
                nombres: '',
                apellidos: '',
                direccion: '',
                telefono: '',
                consecutivo: '',
                idClientes: 0,
                colorx: '#8B0000',
                listado: 1,
                idProducto:0,
                fecha : '',
                id:'',
                observaciones:'Ninguna',
                total:0,
                impuesto:0,
                valor:0,
                tipoFactura : 1,
                flag : 0,
                errorFacturas:0,
                errorMensaje:[],
                identificador: 0,
                componentKey:0
            }
        },
        computed:{
        },
        methods : {
            lookupUserCustom: debounce(function(){
            // in practice this action should be debounced
            fetch('/clientes/listadofiltrado/'+this.cedula)
              .then(response => {
                return response.json();
              })
              .then(data => {
                this.clientesFiltro = data.clientes;

                if(this.clientesFiltro[0].id === undefined || (typeof this.clientesFiltro[0].id === 'undefined') || this.clientesFiltro[0].id === null){
                console.log("Salida indefinida de clientes");
                }else{
                console.log("Salida de clientes");
                console.log(this.clientesFiltro[0].id);

                }

                if(this.clientesFiltro[0].id > 0){
                    this.idClientes = this.clientesFiltro[0].id;
                    this.nombres = this.clientesFiltro[0].nombres;
                    this.apellidos = this.clientesFiltro[0].apellidos;
                    this.direccion = this.clientesFiltro[0].direccion;
                    this.telefono = this.clientesFiltro[0].telefono;
                    this.correo = this.clientesFiltro[0].correo;
                }else{
                    this.idClientes = 0;
                }

                console.log("Salida de clientes id asignado");
                console.log(this.idClientes);
              })
            }, 300),
            onChange(event) {
            //console.log(event.target.value);
            this.flag=event.target.value;
            },
            cargarFechaActual(){
                this.fecha=moment().format('YYYY-MM-DD');
            },
            crearFacturas(){
                //valido con el metodo de validacion creado
                /*
                if(this.validarFacturas()){
                    return;
                }
                */
                let me=this;
                axios.post('/facturas/store',{
                    'cedula': this.cedula,
                    'consecutivo': this.consecutivo,
                    'fecha': this.fecha,
                    'valor': this.valor,
                    'impuesto': this.impuesto,
                    'total': this.total,
                    'observaciones': this.observaciones,
                    'idClientes': this.idClientes,
                    'nombres': this.nombres,
                    'apellidos': this.apellidos,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'correo': this.correo
                }).then(function (response) {
                Swal.fire(
                    'Factura creada!'
                    )
                me.listarFacturas(1,'','Facturas');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validarFacturas(){
                this.errorFacturas=0;
                this.errorMensaje=[];

                if (!this.cedula) this.errorMensaje.push("La cédula del cliente no puede estar vacia");
                if (!this.cedula) this.errorMensaje.push("La cédula del cliente no puede estar vacia");
                if (!this.cedula) this.errorMensaje.push("La cédula del cliente no puede estar vacia");
                if (!this.cedula) this.errorMensaje.push("La cédula del cliente no puede estar vacia");
                if (!this.cedula) this.errorMensaje.push("La cédula del cliente no puede estar vacia");
                if (!this.cedula) this.errorMensaje.push("La cédula del cliente no puede estar vacia");
                if (!this.cedula) this.errorMensaje.push("La cédula del cliente no puede estar vacia");
                if (this.errorMensaje.length) this.errorFacturas=1;

                return this.errorFacturas;
            },
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            forceRerender() {
                this.componentKey += 1;
               },
            mostrarDetalle(id,producto,area){
                this.listado=0;
                this.identificador=id;
                this.identificadorArea=area;
                this.productoNombre=producto;
            },
            ocultarDetalle(){
                this.listado=1;
                this.identificador=0;
                this.identificadorArea=0;
                this.productoNombre='';
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.materiaprimaproducto='';
                this.manodeobraproducto='';
                this.precioBase=0;
                this.unidadBase='';
                this.tipoModal=0;
                this.flag=0;
                this.seleccion=0;
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){

                case "gestionMateria":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.tipoModal=1; //carga tipos de campos y footers
                            this.materiaprimaproducto='';
                            this.idMateriaPrima=this.idMateriaPrima;
                            this.cantidad='1';
                            this.precio=data['precioBase'];
                            this.idHoja=this.identificador;
                            this.tituloModal='Asignar nueva materia';
                            this.tipoAccion= 1; //carga tipos de botón en el footer
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tipoModal=3;
                            this.id=data['id'];
                            this.idMateriaPrima=data['idGestionMateria'];
                            this.gestionMateria=data['gestionMateria'];
                            this.cantidad=data['cantidad'];
                            this.precio=data['precioBase'];
                            this.tipoDeCosto=data['tipoDeCosto'];
                            this.idHoja=this.identificador;
                            this.tituloModal='Editar materia prima';
                            this.tipoAccion= 2;
                            break;
                        }
                    }
                    this.selectGestionMateria();
                    break;
                }
            }

            },
            listarMateriaPrimaProducto(page,buscar,criterio,identificador){
                let me=this;
                var url='/materiaprimaproducto?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&identificador=' + identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayMateriaPrimaProductos=respuesta.materiaprimaproductos.data;
                me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            crearMateriaPrimaProducto(){
                //valido con el metodo de validacion creado
                if(this.validarMateriaPrimaProducto()){
                    return;
                }

                let me=this;
                axios.post('/materiaprimaproducto/store',{
                    'idMateriaPrima': this.idMateriaPrima,
                    'cantidad': this.cantidad,
                    'precio': this.precioBase,
                    'tipoDeCosto': this.tipoDeCosto,
                    'idHoja': this.idHoja

                }).then(function (response) {
                me.cerrarModal();
                me.forceRerender();
                me.listarMateriaPrimaProducto(1,'','gestionMateria');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarMateriaPrimaProducto(){
                if(this.validarMateriaPrimaProducto()){
                    return;
                }

                let me=this;
                axios.put('/materiaprimaproducto/update',{
                    'id': this.id,
                    'cantidad': this.cantidad,
                    'precio': this.precio,
                    'tipoDeCosto': this.tipoDeCosto

                }).then(function (response) {
                me.cerrarModal();
                me.forceRerender();
                me.listarMateriaPrimaProducto(1,'','materiaprima');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            eliminarMateriaPrimaProducto(data=[]){
                let me=this;
                this.id=data['id'];
                axios.put('/materiaprimaproducto/deactivate',{
                    'id': this.id
                }).then(function (response) {
                me.forceRerender();
                me.listarMateriaPrimaProducto(1,'','materiaprima');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarConsecutivo(){
                let me=this;
                var url='/facturas/ultimo';
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.consecutivo=respuesta.consecutivoEsperado;
                console.log('consecutivo: '+me.consecutivo);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
        },
        mounted() {
            this.cargarFechaActual(),
            this.listarConsecutivo()
        }
    }
</script>
<style>
    #content {
        background: transparent;
        border: solid 3px transparent;
        padding: 10px;
    }
    .cursor{
        cursor: pointer;
    }
</style>

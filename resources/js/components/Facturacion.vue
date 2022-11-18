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

                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="text-input">Materia Prima</label>
                                            <div class="col-md-9">
                                                <select class="form-control" v-model="idMateriaPrima" @change='nuevoValorMateria($event)'>
                                                    <option value="0" disabled>Seleccione una materia</option>
                                                    <option v-for="gestionmateria in arrayGestionMaterias" :key="gestionmateria.idGestionMateria" :value="gestionmateria.idGestionMateria" v-text="gestionmateria.gestionMateria"></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="text-input">Cantidad <br>
                                                <span style="color:red;"><sub><b><i>( Cantidad medida en: {{unidadBase}} )</i></b></sub></span>
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" step="0.01" v-model="cantidad" class="form-control" placeholder="Cantidad de material">
                                                <span class="help-block"><b>(*) Ingrese la cantidad de material en: <span style="color:red;">{{unidadBase}}</span></b></span>
                                            </div>
                                        </div>

                                    </form>
                            </div>
                            <button type="button" class="btn btn-primary" @click="crearManoDeObraProducto()">Guardar</button>
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
    import detallefacturas from '../components/Detallefacturas';
    export default {
        components: {
            detallefacturas
        },
        data(){
            return{
                colorx: '#8B0000',
                listado: 1,
                idHojaDeCosto:0,
                idProducto:0,
                id:'',
                producto:'',
                referencia:'',
                foto:'',
                descripcion:'',
                estado:'',
                idColeccion:0,
                coleccion:'',
                referencia:'',
                idArea:0,
                area:'',
                arrayProducto : [],
                cantidad:0,
                precio:0,
                tipoDeCosto:'Directo',
                idProceso:0,
                tiempo:1,
                valor:0,
                valorPrecioBase:0,
                preciom:0,
                liquidacion:3,
                parafiscales:4,
                liqui:'',
                paraf:'',
                proceso:'',
                relacion:'',
                perfilrelacion:'',
                arrayRelacion:[],
                idPerfil:0,
                perfil:'',
                valorMinuto:0,
                arrayPerfilRelacion:[],
                idMateriaPrima:0,
                gestionmateria:'',
                precioBase:0,
                unidadBase:'',
                arrayGestionMaterias:[],
                modal : 0,
                seleccion:0,
                tipoPago : 0,
                flag : 0,
                tipoAccion : 0,
                fotoCarga:'',
                materiaprimaproducto:'',
                errorMateriaPrimaProducto : 0,
                errorMensaje : [],
                identificador: 0,
                identificadorArea: 0,
                productoNombre:'',
                componentKey:0
            }
        },
        computed:{
        },
        methods : {
            onChange(event) {
            //console.log(event.target.value);
            this.flag=event.target.value;
            },
            crearFacturas(){
                //valido con el metodo de validacion creado
                if(this.validarFacturas()){
                    return;
                }

                let me=this;
                axios.post('/facturas/store',{
                    'consecutivo': this.consecutivo,
                    'fecha': this.fecha,
                    'valor': this.valor,
                    'impuesto': this.impuesto,
                    'total': this.total,
                    'vendedor': this.vendedor,
                    'idVendedor': this.idVendedor,
                    'tipoFactura': this.tipoFactura,
                    'idClientes': this.idClientes,
                    'idEmpresa': this.idEmpresa,
                    'estado': this.estado
                }).then(function (response) {
                me.cerrarModal();
                me.listarFacturas(1,'','Facturas');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            nuevoValorMateria(event){
                console.log(event.target.value);
                this.identificadorMateria=event.target.value;
                let me=this;
                var url='/materiaprimaproducto/valorPrecioBase/'+this.identificadorMateria;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.valorPrecioBase=respuesta.valorPrecioBase;
                me.precioBase=respuesta.valorPrecioBase;
                me.unidadBase=respuesta.unidadBase;
                console.log(me.valorPrecioBase);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            listarVariab(){
                let me=this;
                var url='/financiera';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.liqui=respuesta.liqui;
                me.paraf=respuesta.paraf;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            forceRerender() {
                this.componentKey += 1;
               },
            listarProducto(page,buscar,criterio){
                let me=this;
                var url='/producto?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayProducto=respuesta.productos.data;
                me.pagination=respuesta.pagination;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
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

                case "gestionManoDeObra":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.tipoModal=2;
                            this.manodeobraproducto='';
                            this.idPerfil=data['idPerfil'];
                            this.idHoja=this.identificador;
                            this.idArea=this.identificadorArea;
                            this.tituloModal='Asignar nueva mano de obra';
                            this.tipoAccion= 1;
                            this.selectRelacion(this.idArea);
                            break;
                        }
                        case 'actualizar':{
                            console.log(data);
                            this.modal=1;
                            this.tipoModal=2;
                            this.idManoDeObraProducto=data['id'];
                            this.idPerfil=data['idPerfil'];
                            this.idProceso=data['idProceso'];
                            this.tiempo=data['tiempo'];
                            this.precio=data['precio'];
                            this.idHoja=this.identificador;
                            this.idArea=this.identificadorArea;
                            this.tituloModal='Editar mano de obra';
                            this.tipoAccion= 2;
                            this.selectRelacion(this.idArea);
                            this.selectRelacionPerfil(this.idProceso);
                            break;
                        }
                    }
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
            validarMateriaPrimaProducto(){
                this.errorMateriaPrimaProducto=0;
                this.errorMensaje=[];
                if (!this.cantidad) this.errorMensaje.push("La cantidad no puede estar vacia");
                if (this.errorMensaje.length) this.errorMateriaPrimaProducto=1;

                return this.errorMateriaPrimaProducto;
            },
        },
        mounted() {
            this.listarProducto(1,this.buscar,this.criterio)
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

<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Pedidos</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Pedidos &nbsp;
                            <button type="button" @click="abrirModal('pedidos','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="consecutivo">Consecutivo</option>
                                        <option value="fecha">Fecha</option>
                                        <option value="empleados.nombres">Nombres Vendedor</option>
                                        <option value="empleados.apellidos">Apellidos Vendedor</option>
                                        <option value="razonSocial">Proveedor</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarPedidos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarPedidos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Consecutivo</th>
                                        <th>Fecha</th>
                                        <th>Valor</th>
                                        <th>Impuesto</th>
                                        <th>Total</th>
                                        <th>Vendedor</th>
                                        <th>Tipo Factura</th>
                                        <th>Proveedor</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="pedidos in arrayPedidos" :key="pedidos.id">
                                        <td>

                                            <button type="button" @click="abrirModal('pedidos','actualizar',pedidos)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil" title="Editar datos"></i>
                                            </button> &nbsp;

                                        <template v-if="pedidos.estado == '1'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarPedidos(pedidos.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>

                                        <template v-if="pedidos.estado == '2'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarPedidos(pedidos.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="pedidos.consecutivo"></td>
                                        <td v-text="pedidos.fecha"></td>
                                        <td>{{pedidos.valor | currency}}</td>
                                        <td>{{pedidos.impuesto | currency}}</td>
                                        <td>{{pedidos.total | currency}}</td>
                                        <td>{{pedidos.nombresVendedor}} {{pedidos.apellidosVendedor}}</td>
                                        <td v-text="pedidos.tipoFactura"></td>
                                        <td v-text="pedidos.razonSocial"></td>
                                        <td>
                                            <div v-if="pedidos.estado == '1'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="pedidos.estado == '2'">
                                            <span class="badge badge-danger">Desactivado</span>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            </div>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                    </li>
                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- Fin ejemplo de tabla Listado -->
                </div>
                <!--Inicio del modal agregar/actualizar-->
                <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-primary modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-text="tituloModal"></h4>
                                <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <div class="ow">
                                 <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Consecutivo</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="consecutivo" class="form-control" placeholder="Consecutivo de los pedidos">
                                            <span class="help-block">(*) Ingrese el consecutivo de los pedidos</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Fecha</label>
                                        <div class="col-md-9">
                                            <input type="date" v-model="fecha" class="form-control" placeholder="Fechas de los pedidos">
                                            <span class="help-block">(*) Ingrese la fecha de los pedidos</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Valor</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="valor" class="form-control" placeholder="Valor de los pedidos">
                                            <span class="help-block">(*) Ingrese el valor de los pedidos</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Impuesto</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="impuesto" class="form-control" placeholder="Valor del impuesto">
                                            <span class="help-block">(*) Ingrese el valor del impuesto</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Total</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="total" class="form-control" placeholder="Total de los pedidos">
                                            <span class="help-block">(*) Ingrese el total de los pedidos</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Vendedor</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idEmpleados">
                                                <option value="0" disabled>Seleccione un empleados</option>
                                                <option v-for="relacion in arrayEmpleados" :key="relacion.id" :value="relacion.id" v-text="relacion.nombres+' '+relacion.apellidos+' - '+relacion.documento"></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Tipo Factura</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idTipofactura">
                                                <option value="0" disabled>Seleccione un tipo factura</option>
                                                <option v-for="relacion in arrayTipofactura" :key="relacion.id" :value="relacion.id" v-text="relacion.detalle"></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Proveedor</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idProveedores">
                                                <option value="0" disabled>Seleccione un proveedor</option>
                                                <option v-for="relacion in arrayProveedores" :key="relacion.id" :value="relacion.id" v-text="relacion.razonSocial"></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                                    <div class="form-group row div-error" v-show="errorPedidos">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearPedidos()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarPedidos()">Editar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        data(){
            return{
                idPedidos:0,
                id:'',
                pedidos:'',
                estado:'',
                consecutivo:'',
                fecha:'',
                valor:0,
                total:0,
                arrayPedidos : [],
                arrayImpuesto : [],
                arrayEmpleados : [],
                arrayTipofactura : [],
                arrayProveedores : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                impuesto : 0,
                idEmpleados : 0,
                idTipofactura : 0,
                idProveedores : 0,
                errorPedidos : 0,
                errorMensaje : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'pedidos',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginacion
            pagesNumber: function(){
                if (!this.pagination.to) {
                    return[];
                }

                var from=this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;
            }
        },
        methods : {
            listarPedidos(page,buscar,criterio){
                let me=this;
                var url='/pedidos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayPedidos=respuesta.pedidos.data;
                me.pagination=respuesta.pagination;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para ver los valores asociados a esa pagina
                me.listarPedidos(page,buscar,criterio);
            },
            limpiarmodal(){
                this.consecutivo='';
                this.fecha='';
                this.valor='';
                this.impuesto='';
                this.total='';
                this.idEmpleados='';
                this.idTipofactura='';
                this.idProveedores='';
            },
            crearPedidos(){
                //valido con el metodo de validacion creado
                if(this.validarPedidos()){
                    return;
                }

                let me=this;
                axios.post('/pedidos/store',{
                    'consecutivo': this.consecutivo,
                    'fecha': this.fecha,
                    'valor': this.valor,
                    'impuesto': this.impuesto,
                    'total': this.total,
                    'idEmpleados': this.idEmpleados,
                    'idTipofactura': this.idTipofactura,
                    'idProveedores': this.idProveedores
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarPedidos(1,'','Pedidos');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarPedidos(){
                if(this.validarPedidos()){
                    return;
                }

                let me=this;
                axios.put('/pedidos/update',{
                    'pedidos': this.pedidos,
                    'consecutivo': this.consecutivo,
                    'fecha': this.fecha,
                    'valor': this.valor,
                    'impuesto': this.impuesto,
                    'total': this.total,
                    'idEmpleados': this.idEmpleados,
                    'id': this.idPedidos,
                    'idTipofactura': this.idTipofactura,
                    'idProveedores': this.idProveedores
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarPedidos(1,'','pedidos');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarPedidos(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Está seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Desactivar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/pedidos/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarPedidos(1,'','pedidos');
                    swalWithBootstrapButtons.fire(
                    'Pedidos desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarPedidos();
                }
                })
            },
            activarPedidos(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Quiere activar este registro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Activar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/pedidos/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarPedidos(1,'','pedidos');
                    swalWithBootstrapButtons.fire(
                    'Pedidos activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarPedidos();
                }
                })
            },
            validarPedidos(){
                this.errorPedidos=0;
                this.errorMensaje=[];

            if (!this.consecutivo) this.errorMensaje.push("-El consecutivo de los pedidos no puede estar vacio ");
            if (!this.fecha) this.errorMensaje.push("-La fecha de los pedidos no puede estar vacio ");
            if (!this.valor) this.errorMensaje.push("-El valor de los pedidos no puede estar vacio ");
            if (!this.impuesto) this.errorMensaje.push("-El impuesto de los pedidos no puede estar vacio ");
            if (!this.total) this.errorMensaje.push("-El total de los pedidos no puede estar vacio ");
            if (!this.idEmpleados) this.errorMensaje.push("-El vendedor de los pedidos no puede estar vacio ");
            if (!this.idTipofactura) this.errorMensaje.push("-El tipo factura de los pedidos no puede estar vacio ");
            if (!this.idProveedores) this.errorMensaje.push("-El proveedor de los pedidos no puede estar vacio ");

                if (this.errorMensaje.length) this.errorPedidos=1;

                return this.errorPedidos;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Pedidos='';
            },
            listarImpuesto(){
                let me=this;
                var url='/impuesto/listado';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayImpuesto=respuesta.impuesto;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            listarTipofactura(){
                let me=this;
                var url='/tipofactura/listado';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayTipofactura=respuesta.tipofactura;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            listarProveedores(){
                let me=this;
                var url='/proveedores/listado';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayProveedores=respuesta.proveedores;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            listarempleados(){
                let me=this;
                var url='/empleados/listado';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayEmpleados=respuesta.empleados;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "pedidos":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.Pedidos='';
                            this.tituloModal='Crear nuevo pedidos';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar pedidos';
                            this.tipoAccion= 2;
                            this.idPedidos=data['id'];
                            this.consecutivo=data['consecutivo'];
                            this.fecha=data['fecha'];
                            this.valor=data['valor'];
                            this.impuesto=data['impuesto'];
                            this.total=data['total'];
                            this.idEmpleados=data['idEmpleados'];
                            this.Pedidos=data['pedidos'];
                            this.idTipofactura=data['idTipofactura'];
                            this.idProveedores=data['idProveedores'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarPedidos(1,this.buscar,this.criterio);
            this.listarImpuesto();
            this.listarTipofactura();
            this.listarempleados();
            this.listarProveedores();
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>

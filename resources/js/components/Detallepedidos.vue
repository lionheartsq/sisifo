<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Detallepedidos</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Detallepedidos &nbsp;
                            <button type="button" @click="abrirModal('detallepedidos','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="cantidad">Cantidad</option>
                                        <option value="valor">Valor</option>
                                        <option value="valorImpuesto">ValorImpuesto</option>
                                        <option value="total">Total</option>
                                        <option value="idPedidos">idPedidos</option>
                                        <option value="idProductos">idProductos</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarDetallepedidos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarDetallepedidos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Cantidad</th>
                                        <th>Valor</th>
                                        <th>Valor Impuesto</th>
                                        <th>Total</th>
                                        <th>idPedidos</th>
                                        <th>idProductos</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="detallepedidos in arrayDetallepedidos" :key="detallepedidos.id">
                                        <td>
                                            <button type="button" @click="abrirModal('detallepedidos','actualizar',detallepedidos)" class="btn btn-info btn-sm">
                                            <i class="icon-eye" title="Ver detalles"></i>
                                            </button> &nbsp;

                                            <button type="button" @click="abrirModal('detallepedidos','actualizar',detallepedidos)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil" title="Editar datos"></i>
                                            </button> &nbsp;

                                        <template v-if="detallepedidos.estado == 'A'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarDetallepedidos(detallepedidos.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="detallepedidos.estado == 'E'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarDetallepedidos(detallepedidos.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="detallepedidos.estado == 'I'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarDetallepedidos(detallepedidos.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="detallepedidos.cantidad"></td>
                                        <td v-text="detallepedidos.valor"></td>
                                        <td v-text="detallepedidos.valorImpuesto"></td>
                                        <td v-text="detallepedidos.total"></td>
                                        <td v-text="detallepedidos.idPedidos"></td>
                                        <td v-text="detallepedidos.idProductos"></td>
                                        <td>
                                            <div v-if="detallepedidos.estado == '1'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="detallepedidos.estado == '2'">
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
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Cantidad</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="cantidad" class="form-control" placeholder="Cantidad del detalle factura">
                                            <span class="help-block">(*) Ingrese la cantidad del detalle factura</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Valor</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="valor" class="form-control" placeholder="Valor del detalle factura">
                                            <span class="help-block">(*) Ingrese el valor del detalle factura</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Valor Impuesto</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="valorImpuesto" class="form-control" placeholder="Valor Impuesto del detalle factura">
                                            <span class="help-block">(*) Ingrese el valor impuesto del detalle factura</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Total</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="total" class="form-control" placeholder="Total del detalle factura">
                                            <span class="help-block">(*) Ingrese el total del detalle factura</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Pedidos</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="idPedidos" class="form-control" placeholder="Pedidos del detalle factura">
                                            <span class="help-block">(*) Ingrese las pedidos del detalle factura</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Productos</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="idProductos" class="form-control" placeholder="Productos del detalle factura">
                                            <span class="help-block">(*) Ingrese los productos del detalle factura</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Empresas</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="idEmpresas" class="form-control" placeholder="Empresas del detalle factura">
                                            <span class="help-block">(*) Ingrese las empresas del detalle factura</span>
                                        </div>
                                    </div>
                                    <div class="form-group row div-error" v-show="errorUsuario">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearDetallepedidos()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarDetallepedidos()">Editar</button>
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
                idDetallepedidos:0,
                id:'',
                detallepedidos:'',
                estado:'',
                arrayDetallepedidos : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorDetallepedidos : 0,
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
                criterio : 'detallepedidos',
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
            listarDetallepedidos(page,buscar,criterio){
                let me=this;
                var url='/detallepedidos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayDetallepedidos=respuesta.detallepedidos.data;
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
                me.listarDetallepedidos(page,buscar,criterio);
            },
            crearDetallepedidos(){
                //valido con el metodo de validacion creado
                if(this.validarDetallepedidos()){
                    return;
                }

                let me=this;
                axios.post('/detallepedidos/store',{
                    'usuario': this.detallepedidos
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarDetallepedidos(1,'','Detallepedidos');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarDetallepedidos(){
                if(this.validarDetallepedidos()){
                    return;
                }

                let me=this;
                axios.put('/detallepedidos/update',{
                    'Detallepedidos': this.detallepedidos,
                    'id': this.idDetallepedidos
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarDetallepedidos(1,'','detallepedidos');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarDetallepedidos(id){
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
                    axios.put('/detallepedidos/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarDetallepedidos(1,'','detallepedidos');
                    swalWithBootstrapButtons.fire(
                    'Detallepedidos desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarDetallepedidos();
                }
                })
            },
            activarDetallepedidos(id){
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
                    axios.put('/detallepedidos/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarDetallepedidos(1,'','detallepedidos');
                    swalWithBootstrapButtons.fire(
                    'Detallepedidos activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarDetallepedidos();
                }
                })
            },
            validarDetallepedidos(){
                this.errorDetallepedidos=0;
                this.errorMensaje=[];

                if (!this.cantidad) this.errorMensaje.push("La cantidad del detalle facturas no puede estar vacio");
                if (!this.valor) this.errorMensaje.push("El valor del detalle facturas no puede estar vacio");
                if (!this.valorImpuesto) this.errorMensaje.push("El valor impuesto del detalle facturas no puede estar vacio");
                if (!this.total) this.errorMensaje.push("El total del detalle facturas no puede estar vacio");
                if (!this.idPedidos) this.errorMensaje.push("Los pedidos del detalle facturas no puede estar vacio");
                if (!this.idProductos) this.errorMensaje.push("El productos del detalle facturas no puede estar vacio");
                if (!this.idEmpresas) this.errorMensaje.push("El empresas del detalle facturas no puede estar vacio");
                if (this.errorMensaje.length) this.errorDetallefacturas=1;

                return this.errorDetallepedidos;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Detallepedidos='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "detallepedidos":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.Detallepedidos='';
                            this.tituloModal='Crear nuevo detallepedidos';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar detallepedidos';
                            this.tipoAccion= 2;
                            this.idDetallepedidos=data['id'];
                            this.Detallepedidos=data['detallepedidos'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarDetallepedidos(1,this.buscar,this.criterio);
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

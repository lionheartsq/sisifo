<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Pagos</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Pagos &nbsp;
                            <button type="button" @click="abrirModal('pagos','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="fechaAbono">FechaAbono</option>
                                        <option value="valorPago">ValorPago</option>
                                        <option value="abono">Abono</option>
                                        <option value="idPedidos">idPedidos</option>
                                        <option value="idEmpresa">idEmpresa</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarPagos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarPagos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Fecha abono</th>
                                        <th>Valor Pago</th>
                                        <th>Abono</th>
                                        <th>Pedidos</th>
                                        <th>Empresa</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="pagos in arrayPagos" :key="pagos.id">
                                        <td>
                                            <button type="button" @click="abrirModal('pagos','actualizar',pagos)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil" title="Editar datos"></i>
                                            </button> &nbsp;

                                        <template v-if="pagos.estado == '1'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarPagos(pagos.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>

                                        <template v-if="pagos.estado == '2'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarPagos(pagos.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="pagos.fechaAbono"></td>
                                        <td v-text="pagos.valorPago"></td>
                                        <td v-text="pagos.abono"></td>
                                        <td v-text="pagos.idPedidos"></td>
                                        <td v-text="pagos.idEmpresa"></td>
                                        <td>
                                            <div v-if="pagos.estado == '1'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="pagos.estado == '2'">
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
                                        <label class="col-md-2 form-control-label" for="text-input">Fecha abono</label>
                                        <div class="col-md-10">
                                            <input type="date" v-model="fechaAbono" class="form-control" placeholder="Fecha de abono del pago">
                                            <span class="help-block">(*) Ingrese la fecha de abono del pago</span>
                                        </div>
                                    </div>

                             <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Valor pago</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="valorPago" class="form-control" placeholder="Valor del Pago">
                                            <span class="help-block">(*) Ingrese el valor del pago</span>
                                        </div>
                                    </div>
                                </div>

                                    <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Abono</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="abono" class="form-control" placeholder="Abono de los pagos">
                                            <span class="help-block">(*) Ingrese el abono de los pagos</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Numero de pedido</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="idPedidos" class="form-control" placeholder="Pedidos de los pagos">
                                            <span class="help-block">(*) Ingrese los pedidos de los pagos</span>
                                        </div>
                                    </div>
                                </div>

                                    <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Empresa</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="idEmpresa" class="form-control" placeholder="Empresa de los pagos">
                                            <span class="help-block">(*) Ingrese la empresa  de los pagos</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                    <div class="form-group row div-error" v-show="errorPagos">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearPagos()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarPagos()">Editar</button>
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
                idPagos:0,
                id:'',
                pagos:'',
                estado:'',
                arrayPagos : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorPagos : 0,
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
                criterio : 'pagos',
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
            listarPagos(page,buscar,criterio){
                let me=this;
                var url='/pagos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayPagos=respuesta.pagos.data;
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
                me.listarPagos(page,buscar,criterio);
            },
            crearPagos(){
                //valido con el metodo de validacion creado
                if(this.validarPagos()){
                    return;
                }

                let me=this;
                axios.post('/pagos/store',{
                    'usuario': this.pagos
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarPagos(1,'','Pagos');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarPagos(){
                if(this.validarPagos()){
                    return;
                }

                let me=this;
                axios.put('/pagos/update',{
                    'Pagos': this.pagos,
                    'id': this.idPagos
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarPagos(1,'','pagos');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarPagos(id){
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
                    axios.put('/pagos/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarPagos(1,'','pagos');
                    swalWithBootstrapButtons.fire(
                    'Pagos desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarPagos();
                }
                })
            },
            activarPagos(id){
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
                    axios.put('/pagos/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarpagos(1,'','pagos');
                    swalWithBootstrapButtons.fire(
                    'Pagos activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarPagos();
                }
                })
            },
            validarPagos(){
                this.errorPagos=0;
                this.errorMensaje=[];

                if (!this.fechaAbono) this.errorMensaje.push("-La fecha abono de los pagos no puede estar vacio ");
                if (!this.valorPago) this.errorMensaje.push("-El valor pago de los pagos no puede estar vacio ");
                if (!this.abono) this.errorMensaje.push("-El abono de los pagos no puede estar vacio ");
                if (!this.idPedidos) this.errorMensaje.push("-Los pedidos de los pagos no puede estar vacio ");
                if (!this.idEmpresa) this.errorMensaje.push("-La empresa de los pagos no puede estar vacio ");

                if (this.errorMensaje.length) this.errorPagos=1;

                return this.errorPagos;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Pagos='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "pagos":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.Pagos='';
                            this.tituloModal='Crear nuevo pago';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar pagos';
                            this.tipoAccion= 2;
                            this.idPagos=data['id'];
                            this.Pagos=data['pagos'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarPagos(1,this.buscar,this.criterio);
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

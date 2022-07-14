<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Pagosasientos</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Pagosasientos &nbsp;
                            <button type="button" @click="abrirModal('pagosasientos','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="idPagos">idPagos</option>
                                        <option value="idAsientos">idAsientos</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarPagosasientos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarPagosasientos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>idPagos</th>
                                        <th>idAsientos</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="pagosasientos in arrayPagosasientos" :key="pagosasientos.id">
                                        <td>
                                            <button type="button" @click="abrirModal('pagosasientos','actualizar',pagosasientos)" class="btn btn-info btn-sm">
                                            <i class="icon-eye" title="Ver detalles"></i>
                                            </button> &nbsp;

                                            <button type="button" @click="abrirModal('pagosasientos','actualizar',pagosasientos)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil" title="Editar datos"></i>
                                            </button> &nbsp;

                                        <template v-if="pagosasientos.estado == 'A'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarPagosasientos(pagosasientos.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="pagosasientos.estado == 'E'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarPagosasientos(pagosasientos.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="pagosasientos.estado == 'I'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarPagosasientos(pagosasientos.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="pagosasientos.idPagos"></td>
                                        <td v-text="pagosasientos.idAsientos"></td>
                                        <td>
                                            <div v-if="pagosasientos.estado == '1'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="pagosasientos.estado == '2'">
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
                                        <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="pagosasientos" class="form-control" placeholder="Nombre de pagosasientos">
                                            <span class="help-block">(*) Ingrese el nombre del pagosasientos</span>
                                        </div>
                                    </div>

                                    <!--
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                        <div class="col-md-9">
                                            <input type="email" v-model="estado" class="form-control" placeholder="Enter Email">
                                        </div>
                                    </div>
                                    -->

                                    <div class="form-group row div-error" v-show="errorPagosasientos">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearPagosasientos()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarPagosasientos()">Editar</button>
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
                idPagosasientos:0,
                id:'',
                pagosasientos:'',
                estado:'',
                arrayPagosasientos : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorPagosasientos : 0,
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
                criterio : 'pagosasientos',
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
            listarPagosasientos(page,buscar,criterio){
                let me=this;
                var url='/pagosasientos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayPagosasientos=respuesta.pagosasientos.data;
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
                me.listarPagosasientos(page,buscar,criterio);
            },
            crearPagosasientos(){
                //valido con el metodo de validacion creado
                if(this.validarPagosasientos()){
                    return;
                }

                let me=this;
                axios.post('/pagosasientos/store',{
                    'usuario': this.pagosasientos
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarPagosasientos(1,'','Pagosasientos');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarPagosasientos(){
                if(this.validarPagosasientos()){
                    return;
                }

                let me=this;
                axios.put('/pagosasientos/update',{
                    'Pagosasientos': this.pagosasientos,
                    'id': this.idPagosasientos
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarPagosasientos(1,'','pagosasientos');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarPagosasientos(id){
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
                    axios.put('/pagosasientos/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarPagosasientos(1,'','pagosasientos');
                    swalWithBootstrapButtons.fire(
                    'Pagosasientos desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarPagosasientos();
                }
                })
            },
            activarPagosasientos(id){
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
                    axios.put('/pagosasientos/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarpagosasientos(1,'','pagosasientos');
                    swalWithBootstrapButtons.fire(
                    'Pagosasientos activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarPagosasientos();
                }
                })
            },
            validarPagosasientos(){
                this.errorPagosasientos=0;
                this.errorMensaje=[];

                if (!this.Pagosasientos) this.errorMensaje.push("El nombre del pagosasientos no puede estar vacio");
                if (this.errorMensaje.length) this.errorPagosasientos=1;

                return this.errorPagosasientos;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Pagosasientos='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "Pagosasientos":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.Pagosasientos='';
                            this.tituloModal='Crear nuevo pagosasientos';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar pagosasientos';
                            this.tipoAccion= 2;
                            this.idPagosasientos=data['id'];
                            this.Pagosasientos=data['pagosasientos'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarPagosasientos(1,this.buscar,this.criterio);
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

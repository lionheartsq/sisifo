<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Usuarios</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Usuario &nbsp;
                            <button type="button" @click="abrirModal('residente','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="documentor">Documento</option>
                                        <option value="nombresr">Nombre</option>
                                        <option value="apellidosr">Apellido</option>
                                        <option value="apellidosr">Rol</option>
                                        <option value="estado">Estado</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarResidente(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarResidente(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Documento</th>
                                        <th>Nombre usuario</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="residente in arrayResidentes" :key="residente.id">
                                        <td>
                                            <button type="button" @click="abrirModal('residente','actualizar',residente)" class="btn btn-info btn-sm">
                                            <i class="icon-eye" title="Ver detalles"></i>
                                            </button> &nbsp;

                                            <button type="button" @click="abrirModal('residente','actualizar',residente)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil" title="Editar datos"></i>
                                            </button> &nbsp;

                                        <template v-if="residente.estado == 'A'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarResidente(residente.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="residente.estado == 'E'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarResidente(residente.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="residente.estado == 'I'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarResidente(residente.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="residente.documento"></td>
                                        <td v-text="residente.acudiente"></td>
                                        <td v-text="residente.email"></td>
                                        <td v-text="residente.telefono"></td>
                                        <td>
                                            <div v-if="residente.rol == 'Bda'">
                                            Gestor base de datos
                                            </div>
                                            <div v-if="residente.rol == 'Superadmin'">
                                            Super Administrador
                                            </div>
                                            <div v-if="residente.rol == 'Administrador'">
                                            Administrador
                                            </div>
                                            <div v-if="residente.rol == 'Psicologo'">
                                            Psicólogo
                                            </div>
                                            <div v-if="residente.rol == 'Terapeuta general'">
                                            Terapeuta general
                                            </div>
                                            <div v-if="residente.rol == 'Practicante'">
                                            Practicante
                                            </div>
                                            <div v-if="residente.rol == 'Minutas'">
                                            Minutas
                                            </div>
                                            <div v-if="residente.rol == 'Cajero'">
                                            Cajero
                                            </div>
                                        </td>
                                        <td>
                                            <div v-if="residente.estado == 'A'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="residente.estado == 'E'">
                                            <span class="badge badge-warning">Activo</span>
                                            </div>
                                            <div v-if="residente.estado == 'I'">
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
                                            <input type="text" v-model="residente" class="form-control" placeholder="Nombre de residente">
                                            <span class="help-block">(*) Ingrese el nombre del usuario</span>
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

                                    <div class="form-group row div-error" v-show="errorResidente">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearResidente()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarResidente()">Editar</button>
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
                idResidente:0,
                id:'',
                residente:'',
                estado:'',
                arrayResidentes : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorResidente : 0,
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
                criterio : 'nombresr',
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
            listarResidente(page,buscar,criterio){
                let me=this;
                var url='/usuarios?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayResidentes=respuesta.usuarios.data;
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
                me.listarResidente(page,buscar,criterio);
            },
            crearResidente(){
                //valido con el metodo de validacion creado
                if(this.validarResidente()){
                    return;
                }

                let me=this;
                axios.post('/usarios/store',{
                    'usuario': this.usuario
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarResidente(1,'','residente');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarResidente(){
                if(this.validarResidente()){
                    return;
                }

                let me=this;
                axios.put('/usuarios/update',{
                    'residente': this.residente,
                    'id': this.idResidente
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarResidente(1,'','residente');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarResidente(id){
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
                    axios.put('/usuarios/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarResidente(1,'','usuarios');
                    swalWithBootstrapButtons.fire(
                    'Usuario desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarResidente();
                }
                })
            },
            activarResidente(id){
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
                    axios.put('/usuarios/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarResidente(1,'','residente');
                    swalWithBootstrapButtons.fire(
                    'Usuario activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarResidente();
                }
                })
            },
            validarResidente(){
                this.errorResidente=0;
                this.errorMensaje=[];

                if (!this.residente) this.errorMensaje.push("El nombre del usuario no puede estar vacio");
                if (this.errorMensaje.length) this.errorResidente=1;

                return this.errorResidente;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.residente='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "residente":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.residente='';
                            this.tituloModal='Crear nuevo usuario';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar usuario';
                            this.tipoAccion= 2;
                            this.idResidente=data['id'];
                            this.residente=data['residente'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarResidente(1,this.buscar,this.criterio);
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

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
                            <button type="button" @click="abrirModal('usuario','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="documento">Documento</option>
                                        <option value="email">Email</option>
                                        <option value="nombres">Nombres</option>
                                        <option value="apellidos">Apellidos</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarUsuario(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarUsuario(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Documento</th>
                                        <th>Email</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>idRol</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="usuario in arrayUsuarios" :key="usuario.id">
                                        <td>
                                        <button type="button" @click="abrirModal('clientes','actualizar',clientes)" class="btn btn-info btn-sm">
                                        <i class="icon-eye" title="Ver detalles"></i>
                                        </button> &nbsp;

                                        <button type="button" @click="abrirModal('usuario','actualizar',usuario)" class="btn btn-warning btn-sm">
                                        <i class="icon-pencil" title="Editar datos"></i>
                                        </button> &nbsp;

                                        <template v-if="usuario.estado == '1'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarUsuario(usuario.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="usuario.estado == '2'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarUsuario(usuario.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="usuario.documento"></td>
                                        <td v-text="usuario.email"></td>
                                        <td v-text="usuario.nombres"></td>
                                        <td v-text="usuario.apellidos"></td>
                                        <td v-if="usuario.idRol==1">Superadministrador</td>
                                        <td v-if="usuario.idRol==2">Administrador</td>
                                        <td v-if="usuario.idRol==3">Gestor</td>
                                        <td>
                                            <div v-if="usuario.estado == '1'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="usuario.estado == '2'">
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
                                        <label class="col-md-3 form-control-label" for="text-input">Documento</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="documento" class="form-control" placeholder="Documento del usuario">
                                            <span class="help-block">(*) Ingrese el documento del usuario</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Nombres</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="nombres" class="form-control" placeholder="Nombres del usuario">
                                            <span class="help-block">(*) Ingrese los nombres del usuario</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Apellidos</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="apellidos" class="form-control" placeholder="Apellidos del usuario">
                                            <span class="help-block">(*) Ingrese los apellidos del usuario</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">E-mail</label>
                                        <div class="col-md-9">
                                            <input type="email" v-model="email" class="form-control" placeholder="E-mail del usuario">
                                            <span class="help-block">(*) Ingrese el e-mail del usuario</span>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="tipoAccion==1">
                                        <label class="col-md-3 form-control-label" for="text-input">Password</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="password" class="form-control" placeholder="Password del usuario">
                                            <span class="help-block">(*) Ingrese password para el usuario</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Rol</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <select class="form-control col-md-3" v-model="idRol">
                                                <option value="2">Administrador</option>
                                                <option value="3">Gestor</option>
                                                </select>
                                            </div>
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
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearUsuario()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarUsuario()">Editar</button>
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
                idUsuario:0,
                id:'',
                nombres:'',
                apellidos:'',
                documento:'',
                email:'',
                password:'',
                idEmpresa:1,
                idRol:2,
                estado:'',
                arrayUsuarios : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorUsuario : 0,
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
                criterio : 'usuario',
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
            listarUsuario(page,buscar,criterio){
                let me=this;
                var url='/usuarios?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayUsuarios=respuesta.usuarios.data;
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
                me.listarUsuario(page,buscar,criterio);
            },
            crearUsuario(){
                //valido con el metodo de validacion creado
                if(this.validarUsuario()){
                    return;
                }

                let me=this;
                axios.post('/usuarios/store',{
                    'nombres': this.nombres,
                    'apellidos': this.apellidos,
                    'documento': this.documento,
                    'email': this.email,
                    'idRol': this.idRol,
                    'password': this.password
                }).then(function (response) {
                me.cerrarModal();
                me.listarUsuario(1,'','nombres');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarUsuario(){
                if(this.validarUsuario()){
                    return;
                }

                let me=this;
                axios.put('/usuarios/update',{
                    'id': this.id,
                    'nombres': this.nombres,
                    'apellidos': this.apellidos,
                    'documento': this.documento,
                    'email': this.email,
                    'idRol': this.idRol,
                    'password': this.password
                }).then(function (response) {
                me.cerrarModal();
                me.listarUsuario(1,'','nombres');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarUsuario(id){
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
                    me.listarUsuario(1,'','nombres');
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
                    me.listarUsuario();
                }
                })
            },
            activarUsuario(id){
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
                    me.listarUsuario(1,'','usuario');
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
                    me.listarUsuario();
                }
                })
            },
            validarUsuario(){
                this.errorUsuario=0;
                this.errorMensaje=[];

                if (!this.documento) this.errorMensaje.push("El documento del usuario no puede estar vacio");
                if (!this.email) this.errorMensaje.push("El email del usuario no puede estar vacio");
                if (!this.nombres) this.errorMensaje.push("El nombre del usuario no puede estar vacio");
                if (!this.apellidos) this.errorMensaje.push("Los apellidos del usuario no puede estar vacio");
                if (!this.idRol) this.errorMensaje.push("El rol del usuario no puede estar vacio");
                if (this.errorMensaje.length) this.errorUsuario=1;

                return this.errorUsuario;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Usuario='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "usuario":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.documento='';
                            this.email='';
                            this.nombres='';
                            this.apellidos='';
                            this.password='';
                            this.idRol=2;
                            this.tituloModal='Crear nuevo usuario';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar usuario';
                            this.tipoAccion= 2;
                            this.id=data['id'];
                            this.documento=data['documento'];
                            this.email=data['email'];
                            this.nombres=data['nombres'];
                            this.apellidos=data['apellidos'];
                            this.idRol=data['idRol'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarUsuario(1,this.buscar,this.criterio);
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

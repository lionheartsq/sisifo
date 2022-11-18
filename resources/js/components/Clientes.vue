<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Clientes</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Clientes &nbsp;
                            <button type="button" @click="abrirModal('clientes','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="cedula">Cedula</option>
                                        <option value="nombres">Nombres</option>
                                        <option value="apellidos">Apellidos</option>
                                        <option value="direccion">Direccion</option>
                                        <option value="telefono">Telefono</option>
                                        <option value="correo">Correo</option>
                                        <option value="estado">Estado</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarClientes(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarClientes(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Cedula</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Direccion</th>
                                        <th>Telefono</th>
                                        <th>Correo</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="clientes in arrayClientes" :key="clientes.id">
                                        <td>
                                            <button type="button" @click="abrirModal('clientes','actualizar',clientes)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil" title="Editar datos"></i>
                                            </button> &nbsp;

                                        <template v-if="clientes.estado == 'A'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarClientes(clientes.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="clientes.estado == 'E'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarClientes(clientes.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="clientes.estado == 'I'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarClientes(clientes.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="clientes.cedula"></td>
                                        <td v-text="clientes.nombres"></td>
                                        <td v-text="clientes.apellidos"></td>
                                        <td v-text="clientes.direccion"></td>
                                        <td v-text="clientes.telefono"></td>
                                        <td v-text="clientes.correo"></td>
                                        <td>
                                            <div v-if="clientes.estado == '1'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="clientes.estado == '2'">
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
                                        <label class="col-md-3 form-control-label" for="text-input">Cedula</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="cedula" class="form-control" placeholder="Cedula del cliente">
                                            <span class="help-block">(*) Ingrese la cedula del cliente</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="nombres" class="form-control" placeholder="Nombres del cliente">
                                            <span class="help-block">(*) Ingrese los nombres del cliente</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Apellidos</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="apellidos" class="form-control" placeholder="Apellidos del cliente">
                                            <span class="help-block">(*) Ingrese los apellidos del cliente</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="direccion" class="form-control" placeholder="Direccion del cliente">
                                            <span class="help-block">(*) Ingrese la direccion del cliente</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="telefono" class="form-control" placeholder="Telefono del cliente">
                                            <span class="help-block">(*) Ingrese el telefono del cliente</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Correo</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="correo" class="form-control" placeholder="Correo del cliente">
                                            <span class="help-block">(*) Ingrese el correo del cliente</span>
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
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearClientes()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarClientes()">Editar</button>
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
                idClientes:0,
                id:'',
                clientes:'',
                estado:'',
                arrayClientes : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorClientes : 0,
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
                criterio : 'clientes',
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
            listarClientes(page,buscar,criterio){
                let me=this;
                var url='/clientes?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayClientes=respuesta.clientes.data;
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
                me.listarClientes(page,buscar,criterio);
            },
            crearClientes(){
                //valido con el metodo de validacion creado
                if(this.validarClientes()){
                    return;
                }

                let me=this;
                axios.post('/clientes/store',{
                    'cedula': this.cedula,
                    'nombres': this.nombres,
                    'apellidos': this.apellidos,
                    'direccion': this.direccion,
                    'correo': this.correo,
                    'telefono': this.telefono
                }).then(function (response) {
                me.cerrarModal();
                me.listarClientes(1,'','Clientes');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarClientes(){
                if(this.validarClientes()){
                    return;
                }

                let me=this;
                axios.put('/clientes/update',{
                    'id': this.id,
                    'cedula': this.cedula,
                    'nombres': this.nombres,
                    'apellidos': this.apellidos,
                    'direccion': this.direccion,
                    'correo': this.correo,
                    'telefono': this.telefono
                }).then(function (response) {
                me.cerrarModal();
                me.listarClientes(1,'','clientes');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarClientes(id){
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
                    axios.put('/clientes/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarClientes(1,'','clientes');
                    swalWithBootstrapButtons.fire(
                    'Clientes desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarClientes();
                }
                })
            },
            activarClientes(id){
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
                    axios.put('/clientes/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarClientes(1,'','clientes');
                    swalWithBootstrapButtons.fire(
                    'Clientes activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarClientes();
                }
                })
            },
            validarClientes(){
                this.errorClientes=0;
                this.errorMensaje=[];

                if (!this.cedula) this.errorMensaje.push("La cedula del cliente no puede estar vacio");
                if (!this.nombres) this.errorMensaje.push("Los nombres del cliente no puede estar vacio");
                if (!this.apellidos) this.errorMensaje.push("Los apellidos del cliente no puede estar vacio");
                if (!this.direccion) this.errorMensaje.push("La direccion del cliente no puede estar vacio");
                if (!this.telefono) this.errorMensaje.push("El telefono del cliente no puede estar vacio");
                if (!this.correo) this.errorMensaje.push("El correo del cliente no puede estar vacio");
                if (this.errorMensaje.length) this.errorClientes=1;

                return this.errorClientes;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Clientes='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "clientes":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.Clientes='';
                            this.tituloModal='Crear nuevo clientes';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar clientes';
                            this.tipoAccion= 2;
                            this.id=data['id'];
                            this.cedula=data['cedula'];
                            this.nombres=data['nombres'];
                            this.apellidos=data['apellidos'];
                            this.direccion=data['direccion'];
                            this.telefono=data['telefono'];
                            this.correo=data['correo'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarClientes(1,this.buscar,this.criterio);
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

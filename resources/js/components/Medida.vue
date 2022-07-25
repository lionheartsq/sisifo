<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Medida</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Medida &nbsp;
                            <button type="button" @click="abrirModal('medida','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="nombre">Nombre</option>
                                        <option value="estado">Estado</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarMedida(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarMedida(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="medida in arrayMedida" :key="medida.id">
                                        <td>
                                            <button type="button" @click="abrirModal('medida','actualizar',medida)" class="btn btn-info btn-sm">
                                            <i class="icon-eye" title="Ver detalles"></i>
                                            </button> &nbsp;

                                            <button type="button" @click="abrirModal('medida','actualizar',medida)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil" title="Editar datos"></i>
                                            </button> &nbsp;

                                        <template v-if="medida.estado == 'A'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarMedida(medida.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="medida.estado == 'E'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarMedida(medida.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="medida.estado == 'I'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarMedida(medida.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="medida.nombre"></td>
                                        <td v-text="medida.estado"></td>
                                        <td>
                                            <div v-if="medida.estado == '1'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="medida.estado == '2'">
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
                                            <input type="number" v-model="nombre" class="form-control" placeholder="Nombre de la medida">
                                            <span class="help-block">(*) Ingrese el nombre de la medida</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Estado</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="estado" class="form-control" placeholder="Estado de la medida">
                                            <span class="help-block">(*) Ingrese el estado de la medida</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Empresa</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="idEmpresa" class="form-control" placeholder="Empresa de la medida">
                                            <span class="help-block">(*) Ingrese la empresa de la medida</span>
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
                idMedida:0,
                id:'',
                medida:'',
                estado:'',
                arrayMedida : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorMedida : 0,
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
                criterio : 'medida',
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
            listarMedida(page,buscar,criterio){
                let me=this;
                var url='/medida?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayMedida=respuesta.medida.data;
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
                me.listarMedida(page,buscar,criterio);
            },
            crearMedida(){
                //valido con el metodo de validacion creado
                if(this.validarMedida()){
                    return;
                }

                let me=this;
                axios.post('/medida/store',{
                    'usuario': this.medida
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarMedida(1,'','Medida');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarMedida(){
                if(this.validarMedida()){
                    return;
                }

                let me=this;
                axios.put('/medida/update',{
                    'Medida': this.medida,
                    'id': this.idMedida
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarMedida(1,'','medida');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarMedida(id){
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
                    axios.put('/medida/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarMedida(1,'','medida');
                    swalWithBootstrapButtons.fire(
                    'Medida desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarMedida();
                }
                })
            },
            activarMedida(id){
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
                    axios.put('/medida/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarmedida(1,'','medida');
                    swalWithBootstrapButtons.fire(
                    'Medida activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarMedida();
                }
                })
            },
            validarMedida(){
                this.errorMedida=0;
                this.errorMensaje=[];

                if (!this.nombre) this.errorMensaje.push("El nombre de la medida no puede estar vacio");
                if (!this.estado) this.errorMensaje.push("El estado de la medida no puede estar vacio");
                if (!this.idEmpresas) this.errorMensaje.push("La empresa de la medida no puede estar vacio");
                if (this.errorMensaje.length) this.errorMedida=1;

                return this.errorMedida;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Medida='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "Medida":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.Medida='';
                            this.tituloModal='Crear nuevo medida';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar medida';
                            this.tipoAccion= 2;
                            this.idMedida=data['id'];
                            this.Medida=data['medida'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarMedida(1,this.buscar,this.criterio);
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

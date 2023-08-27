<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Habitacion</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Habitación &nbsp;
                            <button type="button" @click="abrirModal('habitacion','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="detalle">Detalle</option>
                                        <option value="estado">Estado</option>
                                        <option value="fecha">Fecha</option>
                                        <option value="idTipo">idTipo</option>
                                        <option value="idEmpresas">idEmpresas</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarHabitacion(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarHabitacion(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Detalle</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>idTipo</th>
                                        <th>idEmpresas</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="habitacion in arrayHabitacion" :key="habitacion.id">
                                        <td>
                                            <button type="button" @click="abrirModal('habitacion','actualizar',habitacion)" class="btn btn-info btn-sm">
                                            <i class="icon-eye" title="Ver detalles"></i>
                                            </button> &nbsp;

                                            <button type="button" @click="abrirModal('habitacion','actualizar',habitacion)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil" title="Editar datos"></i>
                                            </button> &nbsp;

                                        <template v-if="habitacion.estado == 'A'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarHabitacion(habitacion.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="habitacion.estado == 'E'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarHabitacion(habitacion.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="habitacion.estado == 'I'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarHabitacion(habitacion.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="habitacion.detalle"></td>
                                        <td v-text="habitacion.estado"></td>
                                        <td v-text="habitacion.fecha"></td>
                                        <td v-text="habitacion.idTipo"></td>
                                        <td v-text="habitacion.idEmpresas"></td>
                                        <td>
                                            <div v-if="habitacion.estado == '1'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="habitacion.estado == '2'">
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
                                        <label class="col-md-3 form-control-label" for="text-input">Detalle</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="detalle" class="form-control" placeholder="Detalle de la habitación">
                                            <span class="help-block">(*) Ingrese el detalle de la habitación</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Estado</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="estado" class="form-control" placeholder="Estado de la habitación">
                                            <span class="help-block">(*) Ingrese el estado de la habitación</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Fecha</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="fecha" class="form-control" placeholder="Fecha de la habitación">
                                            <span class="help-block">(*) Ingrese la fecha de la habitación</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Tipo</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="idTipo" class="form-control" placeholder="Tipo de la habitación">
                                            <span class="help-block">(*) Ingrese el tipo de la habitación</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Empresa</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="idEmpresas" class="form-control" placeholder="Empresa de la habitación">
                                            <span class="help-block">(*) Ingrese la empresa de la habitación</span>
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
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearHabitacion()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarHabitacion()">Editar</button>
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
                idHabitacion:0,
                id:'',
                habitacion:'',
                estado:'',
                arrayHabitacion : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorHabitacion : 0,
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
                criterio : 'habitacion',
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
            listarHabitacion(page,buscar,criterio){
                let me=this;
                var url='/habitacion?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayHabitacion=respuesta.habitacion.data;
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
                me.listarHabitacion(page,buscar,criterio);
            },
            crearHabitacion(){
                //valido con el metodo de validacion creado
                if(this.validarHabitacion()){
                    return;
                }

                let me=this;
                axios.post('/habitacion/store',{
                    'usuario': this.habitacion
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarHabitacion(1,'','Habitacion');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarHabitacion(){
                if(this.validarHabitacion()){
                    return;
                }

                let me=this;
                axios.put('/habitacion/update',{
                    'Habitacion': this.habitacion,
                    'id': this.idHabitacion
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarHabitacion(1,'','habitacion');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarHabitacion(id){
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
                    axios.put('/habitacion/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarHabitacion(1,'','habitacion');
                    swalWithBootstrapButtons.fire(
                    'Habitacion desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarHabitacion();
                }
                })
            },
            activarHabitacion(id){
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
                    axios.put('/habitacion/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarhabitacion(1,'','habitacion');
                    swalWithBootstrapButtons.fire(
                    'Habitacion activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarHabitacion();
                }
                })
            },
            validarHabitacion(){
                this.errorHabitacion=0;
                this.errorMensaje=[];

                if (!this.detalle) this.errorMensaje.push("El detalle de la habitacion no puede estar vacio");
                if (!this.estado) this.errorMensaje.push("El estado de la habitacion no puede estar vacio");
                if (!this.fecha) this.errorMensaje.push("La fecha de la habitacion no puede estar vacio");
                if (!this.idTipo) this.errorMensaje.push("El tipo de la habitacion no puede estar vacio");
                if (!this.idEmpresas) this.errorMensaje.push("La empresa de la habitacion no puede estar vacio");
                if (this.errorMensaje.length) this.errorHabitacion=1;

                return this.errorHabitacion;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Habitacion='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "habitacion":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.Habitacion='';
                            this.tituloModal='Crear nueva habitación';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar habitacion';
                            this.tipoAccion= 2;
                            this.idHabitacion=data['id'];
                            this.Habitacion=data['habitacion'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarHabitacion(1,this.buscar,this.criterio);
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

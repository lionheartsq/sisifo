<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Ocupacion</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Ocupacion &nbsp;
                            <button type="button" @click="abrirModal('ocupacion','crear')" class="btn btn-secondary">
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
                                        <option value="fechaIngreso">fecha de ingreso</option>
                                        <option value="fechaSalida">fecha de salida</option>
                                        <option value="horaIngreso">hora de ingreso</option>
                                        <option value="horaSalida">hora de salida</option>
                                        <option value="idCliente">idCliente</option>
                                        <option value="idHabitacion">idHabitación</option>
                                        <option value="idEmpresas">idEmpresas</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarOcupacion(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarOcupacion(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                                        <th>Fecha Ingreso</th>
                                        <th>Fecha Salida</th>
                                        <th>Hora Ingreso</th>
                                        <th>Hora Salida</th>
                                        <th>idCliente</th>
                                        <th>idHabitación</th>
                                        <th>idEmpresas</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="ocupacion in arrayOcupacion" :key="ocupacion.id">
                                        <td>
                                            <button type="button" @click="abrirModal('ocupacion','actualizar',ocupacion)" class="btn btn-info btn-sm">
                                            <i class="icon-eye" title="Ver detalles"></i>
                                            </button> &nbsp;

                                            <button type="button" @click="abrirModal('ocupacion','actualizar',ocupacion)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil" title="Editar datos"></i>
                                            </button> &nbsp;

                                        <template v-if="ocupacion.estado == 'A'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarOcupacion(ocupacion.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="ocupacion.estado == 'E'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarOcupacion(ocupacion.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="ocupacion.estado == 'I'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarOcupacion(ocupacion.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="ocupacion.detalle"></td>
                                        <td v-text="ocupacion.estado"></td>
                                        <td v-text="ocupacion.fechaIngreso"></td>
                                        <td v-text="ocupacion.fechaSalida"></td>
                                        <td v-text="ocupacion.horaIngreso"></td>
                                        <td v-text="ocupacion.horaSalida"></td>
                                        <td v-text="ocupacion.idCliente"></td>
                                        <td v-text="ocupacion.idHabitacion"></td>
                                        <td v-text="ocupacion.idEmpresas"></td>
                                        <td>
                                            <div v-if="ocupacion.estado == '1'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="ocupacion.estado == '2'">
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
                                            <input type="number" v-model="detalle" class="form-control" placeholder="Detalle de la ocupación">
                                            <span class="help-block">(*) Ingrese el detalle de la ocupación</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Estado</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="estado" class="form-control" placeholder="Estado de la ocupación">
                                            <span class="help-block">(*) Ingrese el estado de la ocupación</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Fecha de Ingreso</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="fechaIngreso" class="form-control" placeholder="Fecha Ingreso de la ocupación">
                                            <span class="help-block">(*) Ingrese la fecha ingreso de la ocupación</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Fecha de Salida</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="fechaSalida" class="form-control" placeholder="Fecha Salida de la ocupación">
                                            <span class="help-block">(*) Ingrese la fecha salida de la ocupación</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Hora de Ingreso</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="horaIngreso" class="form-control" placeholder="Hora Ingreso de la ocupación">
                                            <span class="help-block">(*) Ingrese la hora ingreso de la ocupación</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Hora de Salida</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="horaSalida" class="form-control" placeholder="Hora Salida de la ocupación">
                                            <span class="help-block">(*) Ingrese la hora salida de la ocupación</span>
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
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearOcupacion()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarOcupacion()">Editar</button>
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
                idOcupacion:0,
                id:'',
                ocupacion:'',
                estado:'',
                arrayOcupacion : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorOcupacion : 0,
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
                criterio : 'ocupacion',
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
            listarOcupacion(page,buscar,criterio){
                let me=this;
                var url='/ocupacion?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayOcupacion=respuesta.ocupacion.data;
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
                me.listarOcupacion(page,buscar,criterio);
            },
            crearOcupacion(){
                //valido con el metodo de validacion creado
                if(this.validarOcupacion()){
                    return;
                }

                let me=this;
                axios.post('/ocupacion/store',{
                    'usuario': this.ocupacion
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarOcupacion(1,'','Ocupacion');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarOcupacion(){
                if(this.validarOcupacion()){
                    return;
                }

                let me=this;
                axios.put('/ocupacion/update',{
                    'Ocupacion': this.ocupacion,
                    'id': this.idOcupacion
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarOcupacion(1,'','ocupacion');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarOcupacion(id){
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
                    axios.put('/ocupacion/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarOcupacion(1,'','ocupacion');
                    swalWithBootstrapButtons.fire(
                    'Ocupacion desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarOcupacion();
                }
                })
            },
            activarOcupacion(id){
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
                    axios.put('/ocupacion/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarocupacion(1,'','ocupacion');
                    swalWithBootstrapButtons.fire(
                    'Ocupacion activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarOcupacion();
                }
                })
            },
            validarOcupacion(){
                this.errorOcupacion=0;
                this.errorMensaje=[];

                if (!this.detalle) this.errorMensaje.push("El detalle de la ocupacion no puede estar vacio");
                if (!this.estado) this.errorMensaje.push("El estado de la ocupacion no puede estar vacio");
                if (!this.fechaIngreso) this.errorMensaje.push("La fecha ingreso de la ocupacion no puede estar vacio");
                if (!this.fechaSalida) this.errorMensaje.push("La fecha salida de la ocupacion no puede estar vacio");
                if (!this.horaIngreso) this.errorMensaje.push("La hora ingreso de la ocupacion no puede estar vacio");
                if (!this.horaSalida) this.errorMensaje.push("La hora salida de la ocupacion no puede estar vacio");
                if (this.errorMensaje.length) this.errorOcupacion=1;

                return this.errorOcupacion;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Ocupacion='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "ocupacion":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.Ocupacion='';
                            this.tituloModal='Crear nuevo ocupacion';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar ocupacion';
                            this.tipoAccion= 2;
                            this.idOcupacion=data['id'];
                            this.Ocupacion=data['ocupacion'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarOcupacion(1,this.buscar,this.criterio);
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

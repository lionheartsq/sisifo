<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Registros</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Registros &nbsp;
                            <button type="button" @click="abrirModal('registros','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="fecha">Fecha</option>
                                        <option value="concepto">Concepto</option>
                                        <option value="detalle">Detalle</option>
                                        <option value="idAsientos">idAsientos</option>
                                        <option value="entrada">Entrada</option>
                                        <option value="salida">Salida</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarRegistros(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarRegistros(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Fecha</th>
                                        <th>Concepto</th>
                                        <th>Detalle</th>
                                        <th>idAsientos</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="registros in arrayRegistros" :key="registros.id">
                                        <td>
                                            <button type="button" @click="abrirModal('registros','actualizar',registros)" class="btn btn-info btn-sm">
                                            <i class="icon-eye" title="Ver detalles"></i>
                                            </button> &nbsp;

                                            <button type="button" @click="abrirModal('registros','actualizar',registros)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil" title="Editar datos"></i>
                                            </button> &nbsp;

                                        <template v-if="registros.estado == 'A'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarRegistros(registros.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="registros.estado == 'E'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarRegistros(registros.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="registros.estado == 'I'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarRegistros(registros.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="registros.fecha"></td>
                                        <td v-text="registros.concepto"></td>
                                        <td v-text="registros.detalle"></td>
                                        <td v-text="registros.idAsientos"></td>
                                        <td v-text="registros.entrada"></td>
                                        <td v-text="registros.salida"></td>
                                        <td>
                                            <div v-if="registros.estado == '1'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="registros.estado == '2'">
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
                                        <label class="col-md-3 form-control-label" for="text-input">Fecha</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="fecha" class="form-control" placeholder="Fecha de los registros">
                                            <span class="help-block">(*) Ingrese la fecha de los registros</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Concepto</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="concepto" class="form-control" placeholder="Conceptos de los registros">
                                            <span class="help-block">(*) Ingrese el concepto de los registros</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Detalle</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="detalle" class="form-control" placeholder="Detalle de los registros">
                                            <span class="help-block">(*) Ingrese el detalle de los registros</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Asientos</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="idAsientos" class="form-control" placeholder="Asientos de los registros">
                                            <span class="help-block">(*) Ingrese los asientos de los registros</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Entrada</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="entrada" class="form-control" placeholder="Entrada de los registros">
                                            <span class="help-block">(*) Ingrese la entrada de los registros</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Salida</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="salida" class="form-control" placeholder="Salida de los registros">
                                            <span class="help-block">(*) Ingrese la salida de los registros</span>
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
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearRegistros()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarRegistros()">Editar</button>
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
                idRegistros:0,
                id:'',
                registros:'',
                estado:'',
                arrayRegistros : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorRegistros : 0,
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
                criterio : 'registros',
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
            listarRegistros(page,buscar,criterio){
                let me=this;
                var url='/registros?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayRegistros=respuesta.registros.data;
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
                me.listarRegistros(page,buscar,criterio);
            },
            crearRegistros(){
                //valido con el metodo de validacion creado
                if(this.validarRegistros()){
                    return;
                }

                let me=this;
                axios.post('/registros/store',{
                    'usuario': this.registros
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarRegistros(1,'','Registros');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarRegistros(){
                if(this.validarRegistros()){
                    return;
                }

                let me=this;
                axios.put('/registros/update',{
                    'Registros': this.registros,
                    'id': this.idRegistros
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarRegistros(1,'','registros');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarRegistros(id){
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
                    axios.put('/registros/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarRegistros(1,'','registros');
                    swalWithBootstrapButtons.fire(
                    'Registros desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarRegistros();
                }
                })
            },
            activarRegistros(id){
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
                    axios.put('/registros/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarregistros(1,'','registros');
                    swalWithBootstrapButtons.fire(
                    'Registros activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarRegistros();
                }
                })
            },
            validarRegistros(){
                this.errorRegistros=0;
                this.errorMensaje=[];

                if (!this.fecha) this.errorMensaje.push("La fecha de los registros no puede estar vacio");
                if (!this.concepto) this.errorMensaje.push("El concepto de los registros no puede estar vacio");
                if (!this.detalle) this.errorMensaje.push("El detalle de los registros no puede estar vacio");
                if (!this.idAsientos) this.errorMensaje.push("Los asientos de los registros no puede estar vacio");
                if (!this.entrada) this.errorMensaje.push("La entrada de los registros no puede estar vacio");
                if (!this.salida) this.errorMensaje.push("La salida de los registros no puede estar vacio");
                if (this.errorMensaje.length) this.errorRegistros=1;

                return this.errorRegistros;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Registros='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "registros":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.Registros='';
                            this.tituloModal='Crear nuevo registros';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar registros';
                            this.tipoAccion= 2;
                            this.idRegistros=data['id'];
                            this.Registros=data['registros'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarRegistros(1,this.buscar,this.criterio);
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

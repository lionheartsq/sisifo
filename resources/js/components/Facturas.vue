<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Facturas</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Facturas &nbsp;
                            <button type="button" @click="abrirModal('facturas','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="consecutivo">Consecutivo</option>
                                        <option value="fecha">Fecha</option>
                                        <option value="valor">Valor</option>
                                        <option value="impuesto">Impuesto</option>
                                        <option value="total">Total</option>
                                        <option value="vendedor">Vendedor</option>
                                        <option value="idVendedor">idVendedor</option>
                                        <option value="tipoFactura">tipoFactura</option>
                                        <option value="idClientes">idClientes</option>
                                        <option value="idEmpresa">idEmpresa</option>
                                        <option value="estado">Estado</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarFacturas(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarFacturas(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Consecutivo</th>
                                        <th>Fecha</th>
                                        <th>Valor</th>
                                        <th>Impuesto</th>
                                        <th>Total</th>
                                        <th>Vendedor</th>
                                        <th>idVendedor</th>
                                        <th>Tipo Factura</th>
                                        <th>idClientes</th>
                                        <th>idEmpresa</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="facturas in arrayFacturas" :key="facturas.id">
                                        <td>
                                            <button type="button" @click="abrirModal('facturas','actualizar',facturas)" class="btn btn-info btn-sm">
                                            <i class="icon-eye" title="Ver detalles"></i>
                                            </button> &nbsp;

                                            <button type="button" @click="abrirModal('facturas','actualizar',facturas)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil" title="Editar datos"></i>
                                            </button> &nbsp;

                                        <template v-if="facturas.estado == 'A'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarFacturas(facturas.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="facturas.estado == 'E'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarFacturas(facturas.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="facturas.estado == 'I'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarFacturas(facturas.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="facturas.consecutivo"></td>
                                        <td v-text="facturas.fecha"></td>
                                        <td v-text="facturas.valor"></td>
                                        <td v-text="facturas.impuesto"></td>
                                        <td v-text="facturas.total"></td>
                                        <td v-text="facturas.vendedor"></td>
                                        <td v-text="facturas.idVendedor"></td>
                                        <td v-text="facturas.tipoFactura"></td>
                                        <td v-text="facturas.idClientes"></td>
                                        <td v-text="facturas.idEmpresa"></td>
                                        <td v-text="facturas.estado"></td>
                                        <td>
                                            <div v-if="facturas.estado == '1'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="facturas.estado == '2'">
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
                                        <label class="col-md-3 form-control-label" for="text-input">Consecutivo</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="consecutivo" class="form-control" placeholder="Consecutivo de las facturas">
                                            <span class="help-block">(*) Ingrese el consecutivo de las facturas</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Fecha</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="fecha" class="form-control" placeholder="Fecha de las facturas">
                                            <span class="help-block">(*) Ingrese la fecha de las facturas</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Valor</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="valor" class="form-control" placeholder="Valor de las facturas">
                                            <span class="help-block">(*) Ingrese el valor de las facturas</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Impuesto</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="impuesto" class="form-control" placeholder="Impuesto de las facturas">
                                            <span class="help-block">(*) Ingrese el impuesto de las facturas</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Total</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="total" class="form-control" placeholder="Total de las facturas">
                                            <span class="help-block">(*) Ingrese el total de las facturas</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Vendedor</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="vendedor" class="form-control" placeholder="Vendedor de las facturas">
                                            <span class="help-block">(*) Ingrese el vendedor de las facturas</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Tipo Factura</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="tipoFactura" class="form-control" placeholder="Tipo Factura de las facturas">
                                            <span class="help-block">(*) Ingrese el Tipo Factura de las facturas</span>
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
                idFacturas:0,
                id:'',
                facturas:'',
                estado:'',
                arrayFacturas : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorFacturas : 0,
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
                criterio : 'facturas',
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
            listarFacturas(page,buscar,criterio){
                let me=this;
                var url='/facturas?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayFacturas=respuesta.facturas.data;
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
                me.listarFacturas(page,buscar,criterio);
            },
            crearFacturas(){
                //valido con el metodo de validacion creado
                if(this.validarFacturas()){
                    return;
                }

                let me=this;
                axios.post('/facturas/store',{
                    'usuario': this.facturas
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarFacturas(1,'','Facturas');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarFacturas(){
                if(this.validarFacturas()){
                    return;
                }

                let me=this;
                axios.put('/facturas/update',{
                    'Facturas': this.facturas,
                    'id': this.idFacturas
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarFacturas(1,'','facturas');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarFacturas(id){
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
                    axios.put('/facturas/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarFacturas(1,'','facturas');
                    swalWithBootstrapButtons.fire(
                    'Facturas desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarFacturas();
                }
                })
            },
            activarFacturas(id){
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
                    axios.put('/facturas/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarfacturas(1,'','facturas');
                    swalWithBootstrapButtons.fire(
                    'Facturas activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarFacturas();
                }
                })
            },
            validarFacturas(){
                this.errorFacturas=0;
                this.errorMensaje=[];

                if (!this.consecutivo) this.errorMensaje.push("El consecutivo de las facturas no puede estar vacio");
                if (!this.fecha) this.errorMensaje.push("La fecha de las facturas no puede estar vacio");
                if (!this.valor) this.errorMensaje.push("El valor de las facturas no puede estar vacio");
                if (!this.impuesto) this.errorMensaje.push("El impuesto de las facturas no puede estar vacio");
                if (!this.total) this.errorMensaje.push("El total de las facturas no puede estar vacio");
                if (!this.vendedor) this.errorMensaje.push("El vendedor de las facturas no puede estar vacio");

                return this.errorFacturas;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Facturas='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "facturas":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.Facturas='';
                            this.tituloModal='Crear nuevo facturas';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar facturas';
                            this.tipoAccion= 2;
                            this.idFacturas=data['id'];
                            this.Facturas=data['facturas'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarFacturas(1,this.buscar,this.criterio);
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

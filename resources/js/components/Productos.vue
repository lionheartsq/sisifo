<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Productos</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Productos &nbsp;
                            <button type="button" @click="abrirModal('productos','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="plu">Plu</option>
                                        <option value="detalle">Detalle</option>
                                        <option value="idMedida">idMedida</option>
                                        <option value="valorCompra">ValorCompra</option>
                                        <option value="pvp">Pvp</option>
                                        <option value="idImpuesto">idImpuesto</option>
                                        <option value="idGrupos">idGrupos</option>
                                        <option value="idEmpresa">idEmpresa</option>
                                        <option value="estado">Estado</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarProductos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarProductos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Plu</th>
                                        <th>Detalle</th>
                                        <th>Medida</th>
                                        <th>Valor Compra</th>
                                        <th>Pvp</th>
                                        <th>Impuesto</th>
                                        <th>Grupo</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="productos in arrayProductos" :key="productos.id">
                                        <td>
                                            <button type="button" @click="abrirModal('productos','actualizar',productos)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil" title="Editar datos"></i>
                                            </button> &nbsp;

                                        <template v-if="productos.estado == '1'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarProductos(productos.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="productos.estado == '2'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarProductos(productos.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="productos.plu"></td>
                                        <td v-text="productos.detalle"></td>
                                        <td v-text="productos.idMedida"></td>
                                        <td v-text="productos.valorCompra"></td>
                                        <td v-text="productos.pvp"></td>
                                        <td v-text="productos.idImpuesto"></td>
                                        <td v-text="productos.idGrupos"></td>
                                        <td>
                                            <div v-if="productos.estado == '1'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="productos.estado == '2'">
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
                                        <label class="col-md-3 form-control-label" for="text-input">plu</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="plu" class="form-control" placeholder="plu de los productos">
                                            <span class="help-block">(*) Ingrese el plu de los productos</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Detalle</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="detalle" class="form-control" placeholder="Detalles de los productos">
                                            <span class="help-block">(*) Ingrese el detalle de los productos</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Medida</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idMedida">
                                                <option value="0" disabled>Seleccione una medida</option>
                                                <option v-for="relacion in arrayMedidas" :key="relacion.id" :value="relacion.id" v-text="relacion.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Valor Compra</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="valorCompra" class="form-control" placeholder="Valor Compra de los productos">
                                            <span class="help-block">(*) Ingrese el valor compra de los productos</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">pvp</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="pvp" class="form-control" placeholder="pvp de los productos">
                                            <span class="help-block">(*) Ingrese el pvp de los productos</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Impuesto</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idImpuesto">
                                                <option value="0" disabled>Seleccione un impuesto</option>
                                                <option v-for="relacion in arrayImpuestos" :key="relacion.id" :value="relacion.id" v-text="relacion.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Grupo</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idGrupos">
                                                <option value="0" disabled>Seleccione un grupo</option>
                                                <option v-for="relacion in arrayGrupos" :key="relacion.id" :value="relacion.id" v-text="relacion.detalleGrupos"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row div-error" v-show="errorProductos">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearProductos()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarProductos()">Editar</button>
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
                idProductos:0,
                id:'',
                productos:'',
                estado:'',
                arrayProductos : [],
                arrayMedidas : [],
                arrayImpuestos : [],
                arrayGrupos : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                idGrupos : 0,
                idMedida : 0,
                idImpuesto : 0,
                errorProductos : 0,
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
                criterio : 'productos',
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
            listarProductos(page,buscar,criterio){
                let me=this;
                var url='/productos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayProductos=respuesta.productos.data;
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
                me.listarProductos(page,buscar,criterio);
            },
            crearProductos(){
                //valido con el metodo de validacion creado
                if(this.validarProductos()){
                    return;
                }

                let me=this;
                axios.post('/productos/store',{
                    'plu': this.plu,
                    'detalle': this.detalle,
                    'idMedida': this.idMedida,
                    'valorCompra': this.valorCompra,
                    'pvp': this.pvp,
                    'idImpuesto': this.idImpuesto,
                    'idGrupos': this.idGrupos
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarProductos(1,'','Productos');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarProductos(){
                if(this.validarProductos()){
                    return;
                }

                let me=this;
                axios.put('/productos/update',{
                    'id': this.idProductos,
                    'plu': this.plu,
                    'detalle': this.detalle,
                    'idMedida': this.idMedida,
                    'idImpuesto': this.idImpuesto,
                    'idGrupos': this.idMedida,
                    'valorCompra': this.valorCompra,
                    'pvp': this.pvp
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarProductos(1,'','productos');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarProductos(id){
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
                    axios.put('/productos/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarProductos(1,'','productos');
                    swalWithBootstrapButtons.fire(
                    'Productos desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarProductos();
                }
                })
            },
            activarProductos(id){
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
                    axios.put('/productos/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarproductos(1,'','productos');
                    swalWithBootstrapButtons.fire(
                    'Productos activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarProductos();
                }
                })
            },
            validarProductos(){
                this.errorProductos=0;
                this.errorMensaje=[];

                if (!this.plu) this.errorMensaje.push("El plu de los productos no puede estar vacio");
                if (!this.detalle) this.errorMensaje.push("El detalle de los productos no puede estar vacio");
                if (!this.idMedida) this.errorMensaje.push("La medida de los productos no puede estar vacio");
                if (!this.valorCompra) this.errorMensaje.push("El valor compra de los productos no puede estar vacio");
                if (!this.pvp) this.errorMensaje.push("El pvp de los productos no puede estar vacio");
                if (this.errorMensaje.length) this.errorProductos=1;

                return this.errorProductos;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Productos='';
            },
            listarGrupos(){
                let me=this;
                var url='/grupos/listado';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayGrupos=respuesta.grupos;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            listarMedidas(){
                let me=this;
                var url='/medida/listado';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayMedidas=respuesta.medida;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            listarImpuestos(){
                let me=this;
                var url='/impuesto/listado';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayImpuestos=respuesta.impuesto;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "productos":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.Productos='';
                            this.tituloModal='Crear nuevo productos';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar productos';
                            this.tipoAccion= 2;
                            this.idProductos=data['id'];
                            this.plu=data['plu'];
                            this.detalle=data['detalle'];
                            this.idMedida=data['idMedida'];
                            this.idImpuesto=data['idImpuesto'];
                            this.idGrupos=data['idGrupos'];
                            this.valorCompra=data['valorCompra'];
                            this.pvp=data['pvp'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarProductos(1,this.buscar,this.criterio);
            this.listarMedidas();
            this.listarImpuestos();
            this.listarGrupos();
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

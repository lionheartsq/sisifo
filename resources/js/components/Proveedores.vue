<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Proveedores</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Proveedores &nbsp;
                            <button type="button" @click="abrirModal('proveedores','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="nit">Nit</option>
                                        <option value="razonSocial" >Razón Social</option>
                                        <option value="telefono">Teléfono</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarProveedores(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarProveedores(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nit</th>
                                        <th>Razón Social</th>
                                        <th>Contacto</th>
                                        <th>Teléfono</th>
                                        <th>Dirección</th>
                                        <th>Correo</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="proveedores in arrayProveedores" :key="proveedores.id">
                                        <td>
                                            <button type="button" @click="abrirModal('proveedores','actualizar',proveedores)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil" title="Editar datos"></i>
                                            </button> &nbsp;

                                        <template v-if="proveedores.estado == '1'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarProveedores(proveedores.id)">
                                                <i class="icon-trash" title="Desactivar"></i>
                                            </button>
                                        </template>
                                        <template v-if="proveedores.estado == '2'">
                                            <button type="button" class="btn btn-success btn-sm" @click="activarProveedores(proveedores.id)">
                                                <i class="icon-check" title="Reactivar"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="proveedores.nit"></td>
                                        <td v-text="proveedores.razonSocial"></td>
                                        <td v-text="proveedores.contacto"></td>
                                        <td v-text="proveedores.telefono"></td>
                                        <td v-text="proveedores.direccion"></td>
                                        <td v-text="proveedores.correo"></td>
                                        <td>
                                            <div v-if="proveedores.estado == '1'">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-if="proveedores.estado == '2'">
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

                             <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Nit</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="nit" class="form-control" placeholder="Nit del proveedor">
                                            <span class="help-block">(*) Ingrese el Nit del proveedor</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Razón Social</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="razonSocial" class="form-control" placeholder="Razón Social del proveedor">
                                            <span class="help-block">(*) Ingrese la razón Social del proveedor</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Contacto</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="contacto" class="form-control" placeholder="Contacto del proveedor">
                                            <span class="help-block">(*) Ingrese el contacto del proveedor</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Teléfono</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="telefono" class="form-control" placeholder="Teléfono del proveedor">
                                            <span class="help-block">(*) Ingrese el teléfono del proveedor</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Dirección</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="direccion" class="form-control" placeholder="Dirección del proveedor">
                                            <span class="help-block">(*) Ingrese la dirección del proveedor</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Correo</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="correo" class="form-control" placeholder="Correo del proveedor">
                                            <span class="help-block">(*) Ingrese el correo del proveedor</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                    <div class="form-group row div-error" v-show="errorProveedores">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearProveedores()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarProveedores()">Editar</button>
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
                idProveedores:0,
                id:'',
                proveedores:'',
                estado:'',
                arrayProveedores : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorProveedores : 0,
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
                criterio : 'proveedores',
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
            listarProveedores(page,buscar,criterio){
                let me=this;
                var url='/proveedores?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayProveedores=respuesta.proveedores.data;
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
                me.listarProveedores(page,buscar,criterio);
            },
            crearProveedores(){
                //valido con el metodo de validacion creado
                if(this.validarProveedores()){
                    return;
                }

                let me=this;
                axios.post('/proveedores/store',{
                    'proveedores': this.proveedores,
                    'nit': this.nit,
                    'razonSocial': this.razonSocial,
                    'contacto': this.contacto,
                    'telefono': this.telefono,
                    'direccion': this.direccion,
                    'correo': this.correo
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarProveedores(1,'','Proveedores');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarProveedores(){
                if(this.validarProveedores()){
                    return;
                }

                let me=this;
                axios.put('/proveedores/update',{
                    'id': this.idProveedores,
                    'proveedores': this.proveedores,
                    'nit': this.nit,
                    'razonSocial': this.razonSocial,
                    'contacto': this.contacto,
                    'telefono': this.telefono,
                    'direccion': this.direccion,
                    'correo': this.correo
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarProveedores(1,'','proveedores');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarProveedores(id){
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
                    axios.put('/proveedores/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarProveedores(1,'','proveedores');
                    swalWithBootstrapButtons.fire(
                    'Proveedores desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarProveedores();
                }
                })
            },
            activarProveedores(id){
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
                    axios.put('/proveedores/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarProveedores(1,'','proveedores');
                    swalWithBootstrapButtons.fire(
                    'Proveedores activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarProveedores();
                }
                })
            },
            functionMail(mail) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(mail);
            },
            validarProveedores(){
                this.errorProveedores=0;
                this.errorMensaje=[];

            if (!this.nit) this.errorMensaje.push("-El Nit del proveedor no puede estar vacio ");
            if (!this.razonSocial) this.errorMensaje.push("-La razón Social del proveedor no puede estar vacio ");
            if (!this.contacto) this.errorMensaje.push("-El contacto del proveedor no puede estar vacio ");
            if (!this.telefono) this.errorMensaje.push("-El teléfono del proveedor no puede estar vacio ");
            if (!this.direccion) this.errorMensaje.push("-La dirección del proveedor no puede estar vacio ")
            if (!this.correo){
                    this.errorMensaje.push("-El correo del provedores no puede estar vacio ");
                }else{
                    if (this.functionMail(this.correo)==false) this.errorMensaje.push("-El formato de correo no es válido ");
                };

                if (this.errorMensaje.length) this.errorProveedores=1;

                return this.errorProveedores;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Proveedores='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "proveedores":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.Proveedores='';
                            this.tituloModal='Crear nuevo proveedor';
                            this.tipoAccion= 1;
                            this.idProveedores="";
                            this.nit="";
                            this.razonSocial="";
                            this.contacto="";
                            this.telefono="";
                            this.direccion="";
                            this.correo="";
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar proveedores';
                            this.tipoAccion= 2;
                            this.idProveedores=data['id'];
                            this.nit=data['nit'];
                            this.razonSocial=data['razonSocial'];
                            this.contacto=data['contacto'];
                            this.telefono=data['telefono'];
                            this.direccion=data['direccion'];
                            this.correo=data['correo'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarProveedores(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        min-width: 1040px;
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

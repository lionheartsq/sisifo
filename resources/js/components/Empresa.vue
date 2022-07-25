<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Empresa</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Configuración Basica Empresa &nbsp;
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <table class="table table-bordered table-striped table-sm">
                                <tbody>
                                    <tr>
                                        <td>
                                            Nombre Empresa
                                        </td>
                                        <td>
                                            <input type="text" v-model="razonSocial" class="form-control" placeholder="Nombre Empresa">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Dirección Empresa
                                        </td>
                                        <td>
                                            <input type="text" v-model="direccion" class="form-control" placeholder="Dirección Empresa">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Telefono Empresa
                                        </td>
                                        <td>
                                            <input type="number" v-model="telefonos" step="0.01" class="form-control" placeholder="Telefono Empresa">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Representante
                                        </td>
                                        <td>
                                            <input type="text" v-model="representante" class="form-control" placeholder="Dirección Empresa">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Nit
                                        </td>
                                        <td>
                                            <input type="text" v-model="nit" class="form-control" placeholder="Dirección Empresa">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Régimen
                                        </td>
                                        <td>
                                        <select class="form-control" v-model="regimen">
                                        <option value="0" disabled>Seleccione el régimen</option>
                                        <option value="Simplificado">Simplificado</option>
                                        <option value="Común">Común</option>
                                        </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                <input type="hidden" v-model="id"/>
                                <input type="hidden" v-model="tipo"/>
                                <!-- <button type="button" class="btn btn-success" @click="guardarDatos()">Guardar</button> -->
                                <button type="button" class="btn btn-primary" @click="actualizarDatos()">Actualizar</button>
                            </form>
                            </div>
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
                                        <label class="col-md-3 form-control-label" for="text-input">Razon Social</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="razonSocial" class="form-control" placeholder="Razon Social de la empresa">
                                            <span class="help-block">(*) Ingrese la razon social de la empresa</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Representante</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="representante" class="form-control" placeholder="Representante de la empresa">
                                            <span class="help-block">(*) Ingrese el representante de la empresa</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Nit</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="nit" class="form-control" placeholder="Nit de la empresa">
                                            <span class="help-block">(*) Ingrese el nit de la empresa</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Regimen</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="regimen" class="form-control" placeholder="Regimen de la empresa">
                                            <span class="help-block">(*) Ingrese el regimen de la empresa</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="direccion" class="form-control" placeholder="Direccion de la empresa">
                                            <span class="help-block">(*) Ingrese la direccion de la empresa</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="telefonos" class="form-control" placeholder="Telefono de la empresa">
                                            <span class="help-block">(*) Ingrese el telefono de la empresa</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Tipo</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="tipo" class="form-control" placeholder="Tipo de la empresa">
                                            <span class="help-block">(*) Ingrese el tipo de la empresa</span>
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
                idEmpresa:0,
                id:'',
                razonSocial:'',
                representante:'',
                nit:'',
                regimen:'',
                direccion:'',
                telefonos:'',
                tipo:'',
                estado:'',
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorEmpresa : 0,
                errorMensaje : []
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
            listarEmpresa(page,buscar,criterio){
                let me=this;
                var url='/empresa?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.id=respuesta.id;
                me.razonSocial=respuesta.razonSocial;
                me.direccion=respuesta.direccion;
                me.telefonos=respuesta.telefonos;
                me.representante=respuesta.representante;
                me.nit=respuesta.nit;
                me.regimen=respuesta.regimen;
                me.tipo=respuesta.tipo;
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
                me.listarEmpresa(page,buscar,criterio);
            },
            actualizarDatos(){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success'
                },
                buttonsStyling: false
                })
                let me=this;
                axios.post('/empresa/update',{
                    'id': this.id,
                    'razonSocial' : this.razonSocial,
                    'representante' : this.representante,
                    'nit' : this.nit,
                    'regimen' : this.regimen,
                    'direccion' : this.direccion,
                    'telefonos' : this.telefonos,
                    'tipo' : this.tipo
                }).then(function (response) {
                swalWithBootstrapButtons.fire('Registro actualizado');
                me.listarConfiguracionBasica();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validarEmpresa(){
                this.errorEmpresa=0;
                this.errorMensaje=[];

                if (!this.razonSocial) this.errorMensaje.push("La razon social de la empresa no puede estar vacio");
                if (!this.representante) this.errorMensaje.push("El representante de la empresa no puede estar vacio");
                if (!this.nit) this.errorMensaje.push("El nit de la empresa no puede estar vacio");
                if (!this.regimen) this.errorMensaje.push("El regimen de la empresa no puede estar vacio");
                if (!this.direccion) this.errorMensaje.push("La direccion de la empresa no puede estar vacio");
                if (!this.telefonos) this.errorMensaje.push("El telefono de la empresa no puede estar vacio");
                if (!this.tipo) this.errorMensaje.push("El tipo de la empresa no puede estar vacio");
                if (this.errorMensaje.length) this.errorEmpresa=1;

                return this.errorEmpresa;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.Empresa='';
            },
        },
        mounted() {
            this.listarEmpresa(1,this.buscar,this.criterio);
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

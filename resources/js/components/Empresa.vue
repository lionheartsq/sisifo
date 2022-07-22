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
                                            <input type="text" v-model="nombre" class="form-control" placeholder="Nombre Empresa">
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
                                            <input type="number" v-model="telefono" step="0.01" class="form-control" placeholder="Telefono Empresa">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Caja de Compensación Empresa
                                        </td>
                                        <td>
                                        <select class="form-control" v-model="cajaCompensacion">
                                        <option value="0" disabled>Seleccione la caja de compensación</option>
                                        <option v-for="caja in arrayCajas" :key="caja.id" :value="caja.id" v-text="caja.NombreCajaCompensacion">
                                        </option>
                                       </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Arl Empresa
                                        </td>
                                        <td>
                                        <select class="form-control" v-model="arl">
                                        <option value="0" disabled>Seleccione la arl</option>
                                        <option v-for="arl in arrayArl" :key="arl.id" :value="arl.id" v-text="arl.nombreArl">
                                        </option>
                                       </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Nivel de Riesgo Empresa
                                        </td>
                                        <td>
                                        <select class="form-control" v-model="nivelRiesgo">
                                        <option value="0" disabled>Seleccione el nivel de riesgo</option>
                                        <option v-for="nivel in arrayNivel" :key="nivel.id" :value="nivel.id" v-text="nivel.nivelArl">
                                        </option>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Tipo Nomina Empresa
                                        </td>
                                        <td>
                                        <select class="form-control" v-model="idTipoNomina">
                                        <option value="0" disabled>Seleccione el tipo de nomina</option>
                                        <option v-for="tiponomina in arrayTipoNomina" :key="tiponomina.id" :value="tiponomina.id" v-text="tiponomina.tipoNomina">
                                        </option>
                                       </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                <input type="hidden" v-model="id">
                                <!-- <button type="button" class="btn btn-success" @click="guardarDatos()">Guardar</button> -->
                                <button type="button" class="btn btn-primary" @click="actualizarDatos(id,nombre,direccion,telefono,cajaCompensacion,arl,nivelRiesgo,idTipoNomina)">Actualizar</button>
                            </form>
                            </div>
                        </div>
                    </div>
                    <!-- Fin ejemplo de tabla Listado -->
                </div>
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
                arrayEmpresa : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorEmpresa : 0,
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
                criterio : 'empresa',
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
            listarEmpresa(page,buscar,criterio){
                let me=this;
                var url='/empresa?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayEmpresa=respuesta.empresa.data;
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
                me.listarEmpresa(page,buscar,criterio);
            },
            actualizarDatos(id,razonSocial,representante,nit,regimen,direccion,telefonos,tipo){
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

                if (!this.Empresa) this.errorMensaje.push("El nombre del empresa no puede estar vacio");
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

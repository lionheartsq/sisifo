<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Reserva</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->

                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Reserva de Salas &nbsp;
                        <button type="button" @click="abrirModal('reserva','crear')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <input type="datetime-local" v-model="fechainicio" class="btn btn-secondary" placeholder="Fecha inicial" >
                        <input type="datetime-local" v-model="fechafin" class="btn btn-secondary" placeholder="Fecha final" >
                        <button type="button" @click="filtrar(1, fechainicio, fechafin)" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Filtrar
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                    <option value="idSala">Sala</option>
                                    <option value="reservaNombre">A nombre de</option>
                                    <option value="fecha">Fecha</option>
                                    <option value="observaciones">observaciones</option>
                                    <option value="estado">estado</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarReserva(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarReserva(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Sala</th>
                                    <th>A nombre de</th>
                                    <th>Fecha</th>
                                    <th>observaciones</th>
                                    <th>estado</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="reserva in arrayReserva" :key="reserva.id">
                                    <td>
                                        <!-- <button type="button" @click="abrirModal('reserva','actualizar',reserva)" class="btn btn-info btn-sm">
                                        <i class="icon-eye" title="Ver detalles"></i>
                                        </button> &nbsp; -->

                                        <button type="button" @click="abrirModal('reserva','actualizar',reserva)" class="btn btn-warning btn-sm">
                                        <i class="icon-pencil" title="Editar datos"></i>
                                        </button> &nbsp;

                                    <template v-if="reserva.estado == '1'">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarReserva(reserva.id)">
                                            <i class="icon-trash" title="Desactivar"></i>
                                        </button>
                                    </template>
                                    
                                    <template v-if="reserva.estado == '2'">
                                        <button type="button" class="btn btn-success btn-sm" @click="activarReserva(reserva.id)">
                                            <i class="icon-check" title="Reactivar"></i>
                                        </button>
                                    </template>

                                    </td>
                                    <td v-text="reserva.idSala"></td>
                                    <td v-text="reserva.reservaNombre"></td>
                                    <td v-text="reserva.fecha"></td>
                                    <td v-text="reserva.observaciones"></td>
                                    
                                    <td>
                                        <div v-if="reserva.estado == '1'">
                                        <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-if="reserva.estado == '2'">
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
                                        <label class="col-md-3 form-control-label" for="text-input">Sala</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idSala">
                                                <option value="0" disabled>Seleccione una sala</option>
                                                <option v-for="relacion in arraySalas" :key="relacion.id" :value="relacion.id" v-text="relacion.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">A nombre de</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="reservaNombre" class="form-control" placeholder="Nombre de quien reserva">
                                        <span class="help-block">(*) Ingrese el nombre de quien reserva</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha</label>
                                    <div class="col-md-9">
                                        <input type="datetime-local" v-model="fecha" class="form-control" placeholder="Fecha de las reserva"
                                        name="fechaReserva" id="fechaReserva" @click="diade()">
                                        <span class="help-block">(*) Ingrese la fecha de la reserva</span>
                                    </div>
                                </div>
                                <tr>
                                        <td>
                                            Arl Empresa
                                        </td>
                                        <td>
                                        <select class="form-control" v-model="hora">
                                        <option value="0" disabled>Seleccione la hora</option>
                                        <option v-for="arl in arrayHora" :key="arl.id" :value="arl.id" v-text="arl.hora">
                                        </option>
                                       </select>
                                        </td>
                                    </tr>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha</label>
                                    <div class="col-md-9">
                                        <input type="time" v-model="hora" class="form-control" placeholder="Hora de la reserva"
                                        name="fechaReserva" id="fechaReserva" @click="diade()">
                                        <span class="help-block">(*) Ingrese la Hora</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input"> Observaciones </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="observaciones" class="form-control" placeholder="Observaciones acerca de la reserva">
                                        <span class="help-block">(*) Observaciones de la reserva</span>
                                    </div>
                                </div>
                                <div class="form-group row div-error" v-show="errorReserva">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearReserva()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarReserva()">Editar</button>
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
            fechainicio:'',
            fechafin:'',
            observaciones:'',
            fecha:'',
            reservaNombre:'',
            idReserva:0,
            id:'',
            idSala: 0,
            reserva:'',
            estado:'',
            arrayReserva : [],
            arraySalas : [],
            arrayHora:[],
            modal : 0,
            tituloModal : '',
            tipoAccion : 0,
            errorReserva : 0,
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
            criterio : 'reserva',
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

        diade(){
            let fechaReserva = document.getElementById('fechaReserva');
            fechaReserva.min = (new Date()).toISOString().substring(0, 19);
        },
        listarHora(){
                let me=this;
                var url='/reserva/hora';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayHora=respuesta.hora;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
        filtrar(page,fechainicio,fechafin){
                let me=this;
                var url='/reserva?page=' + page + '&reserva.fecha>' + fechainicio + '&reserva.fecha<' + fechafin;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta=response.data;
                    me.arrayReserva=respuesta.reserva.data;
                    me.pagination=respuesta.pagination;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
        listarSalas(){
                let me=this;
                var url='/salas/listado';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arraySalas=respuesta.salas;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
        listarReserva(page,buscar,criterio){
            let me=this;
            var url='/reserva?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            // Make a request for a user with a given ID
            axios.get(url).then(function (response) {
                // handle success
            var respuesta=response.data;
            me.arrayReserva=respuesta.reserva.data;
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
            me.listarReserva(page,buscar,criterio);
        },
        crearReserva(){
            //valido con el metodo de validacion creado
            if(this.validarReserva()){
                return;
            }

            let me=this;
            axios.post('/reserva/store',{
                'idSala': this.idSala,
                'reservaNombre': this.reservaNombre,
                'fecha': this.fecha,
                'observaciones': this.observaciones,

            }).then(function (response) {
            me.cerrarModal();
            me.listarReserva(1,'','Reserva');
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        editarReserva(){
            if(this.validarReserva()){
                return;
            }

            let me=this;
            axios.put('/reserva/update',{
                'id': this.idReserva,
                'idSala': this.idSala,
                'reservaNombre': this.reservaNombre,
                'fecha': this.fecha,
                'observaciones': this.observaciones

                //'estado': this.estado,
                //'dato': this.dato
            }).then(function (response) {
            me.cerrarModal();
            me.listarReserva(1,'','reserva');
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        desactivarReserva(id){
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
                axios.put('/reserva/deactivate',{
                    'id': id
                }).then(function (response) {
                me.listarReserva(1,'','reserva');
                swalWithBootstrapButtons.fire(
                'Reserva desactivada!'
                )
                }).catch(function (error) {
                    console.log(error);
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                me.listarReserva();
            }
            })
        },
        activarReserva(id){
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
            title: 'Quiere activar esta reserva?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Activar!',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                let me=this;
                axios.put('/reserva/activate',{
                    'id': id
                }).then(function (response) {
                me.listarreserva(1,'','reserva');
                swalWithBootstrapButtons.fire(
                'Reserva activada!'
                )
                }).catch(function (error) {
                    console.log(error);
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                me.listarReserva();
            }
            })
        },
        validarReserva(){
            this.errorReserva=0;
            this.errorMensaje=[];

            if (!this.idSala) this.errorMensaje.push("El nombre de la sala no puede estar vacio");
            if (!this.reservaNombre) this.errorMensaje.push("El nombre de quien reserva no puede estar vacio");
            if (!this.fecha) this.errorMensaje.push("La fecha de la reserva no puede estar vacia");
            if (!this.observaciones) this.errorMensaje.push("Las observaciones de la reserva no pueden estar vacias");
            if (this.errorMensaje.length) this.errorReserva=1;

            return this.errorReserva;
        },
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.Reserva='';
        },
        abrirModal(modelo, accion, data=[]){
        //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
        switch(modelo){
            case "reserva":
            {
                switch (accion) {
                    case 'crear':{
                        this.modal=1;
                        this.Reserva='';
                        this.tituloModal='Crear nueva reserva';
                        this.tipoAccion= 1;
                        break;
                    }
                    case 'actualizar':{
                        //console.log(data);
                        this.modal=1;
                        this.tituloModal='Editar reserva';
                        this.tipoAccion= 2;
                        this.idReserva=data['id'];
                        this.idSala=data['idSala'];
                        this.reservaNombre=data['reservaNombre'];
                        this.fecha=data['fecha'];
                        this.observaciones=data['observaciones'];
                        break;
                    }
                }
            }
        }
        }
    },
    mounted() {
        this.listarReserva(1,this.buscar,this.criterio);
        this.listarSalas();
        this.listarHora();
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

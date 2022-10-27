<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Historico</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->

                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Reporte historico de Ingreso &nbsp;
                    </div>
                    
                        <div id="fechas" class="card-header">
                            
                            <div id="fecha" class="col-md-9">
                                <input id="fecha" type="date" value="ingreso" class="form-control" placeholder="Fecha">
                                <span class="help-block">(*) Fecha inicio</span>
                            </div>
                            <div id="fecha" class="col-md-9">
                                <input id="fecha" type="date" value="salida" class="form-control" placeholder="Fecha">
                                <span class="help-block">(*) Fecha fin</span>
                            </div>
                            <button id="bfecha" type="submit" @click="listarhistoricof()" class="btn btn-primary"><i class="fa fa-search"></i> Filtrar por Fecha</button>
                        </div>
                  
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                    <option value="documento">Documento</option>
                                    <option value="nombres">Nombres</option>
                                    <option value="apellidos">Apellidos</option>
                                    <option value="ingreso">ingreso</option>
                                    <option value="salida">salida</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarhistorico(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarhistorico(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Documento</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Ingreso</th>
                                    <th>Salida</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="historico in arrayhistorico" :key="historico.id">
                                    <td v-text="historico.id"></td>
                                    <td v-text="historico.documento"></td>
                                    <td v-text="historico.nombres"></td>
                                    <td v-text="historico.apellidos"></td>
                                    <td v-text="historico.ingreso"></td>
                                    <td v-text="historico.salida"></td>
                                    
                                    <td>
                                        <div id="estado" v-if="historico.estado">
                                        <span class="badge badge-success">Ingreso</span>
                                        </div>
                                        <div v-else>
                                        <span class="badge badge-danger">Salida</span>
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
                                    <label class="col-md-3 form-control-label" for="text-input">Documento</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="documento" class="form-control" placeholder="Documento del control">
                                        <span class="help-block">(*) Ingrese el documento del control</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombres</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombres" class="form-control" placeholder="Nombres del control">
                                        <span class="help-block">(*) Ingrese los nombres del control</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Apellidos</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellidos" class="form-control" placeholder="Apellidos del control">
                                        <span class="help-block">(*) Ingrese los apellidos del control</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">E-mail</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="E-mail del control">
                                        <span class="help-block">(*) Ingrese el e-mail del control</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="direccion del empleado">
                                        <span class="help-block">(*) Ingrese los direccion del control</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Cargo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="cargo" class="form-control" placeholder="cargo del control">
                                        <span class="help-block">(*) Ingrese los cargo del control</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="telefono" class="form-control" placeholder="telefono del control">
                                        <span class="help-block">(*) Ingrese los telefono del control</span>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group row div-error" v-show="errorcontrol">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearcontrol(),crearhistorico1()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarcontrol(),crearhistorico2()">Editar</button>
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
            telefono:'',
            id:'',
            nombres:'',
            apellidos:'',
            documento:'',
            email:'',
            direccion:'',
            cargo:'',
            fecha:'',
            idEmpresa:1,
            idRol:2,
            estado:'',
            arraycontrol : [],
            arrayhistorico : [],
            arrayfecha : [],
            modal : 0,
            tituloModal : '',
            tipoAccion : 0,
            errorcontrol : 0,
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
            criterio : 'control',
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
        // este es nuevo
        listarhistoricof(){

            let me=this;
            axios.get('/historico/listarfecha',{
                'id': this.id,
                'nombres': this.nombres,
                'apellidos': this.apellidos,
                'ingreso': this.ingreso,
                'salida': this.salida,
                'estado': this.estado,
            
            }).then(function (response) {
            me.cerrarModal();
            me.listarhistorico(1,'','idEmpleado');
            })
            .catch(function (error) {
                console.log(error);
            });
            },
        listarhistoricof2(fecha1,fecha2){
            let me=this;
            var url='/historico/listarfecha?fecha1>=' + fecha1 + '&&' + '&fecha2<=' + fecha2;
            // Make a request for a user with a given ID
            axios.get(url).then(function (response) {
                // handle success
            var respuesta=response.data;
            me.arrayfecha=respuesta.fecha.data;
            me.pagination=respuesta.pagination;
                //console.log(response);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        },
        listarhistorico(page,buscar,criterio){
            let me=this;
            var url='/historico?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            // Make a request for a user with a given ID
            axios.get(url).then(function (response) {
                // handle success
            var respuesta=response.data;
            me.arrayhistorico=respuesta.historico.data;
            me.pagination=respuesta.pagination;
                //console.log(response);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        },
        listarcontrol(page,buscar,criterio){
            let me=this;
            var url='/control?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            // Make a request for a user with a given ID
            axios.get(url).then(function (response) {
                // handle success
            var respuesta=response.data;
            me.arraycontrol=respuesta.control.data;
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
            me.listarhistorico(page,buscar,criterio);
        },

        mostrarIngresos(){

            let me=this;
            axios.get('/historico/mostrarIngresos',{
                'idEmpleado': this.idEmpleado,
                'nombres': this.nombres,
                'apellidos': this.apellidos,
                'ingreso': this.ingreso,
                'salida': this.salida,
                'estado': this.estado,
              
            }).then(function (response) {
            me.cerrarModal();
            me.listarhistorico(1,'','idEmpleado');
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        mostrarSalidas(){
           
            let me=this;
            axios.get('/historico/mostrarSalidas',{
                'idEmpleado': this.idEmpleado,
                'nombres': this.nombres,
                'apellidos': this.apellidos,
                'ingreso': this.ingreso,
                'salida': this.salida,
                'estado': this.estado,
              
            }).then(function (response) {
            me.cerrarModal();
            me.listarhistorico(1,'','idEmpleado');
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        crearcontrol(){
            //valido con el metodo de validacion creado
            if(this.validarcontrol()){
                return;
            }

            let me=this;
            axios.post('/control/store',{
                'nombres': this.nombres,
                'apellidos': this.apellidos,
                'documento': this.documento,
                'email': this.email,
                'direccion': this.direccion,
                'cargo': this.cargo,
                'telefono': this.telefono
            }).then(function (response) {
            me.cerrarModal();
            me.listarcontrol(1,'','nombres');
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        editarcontrol(){
            if(this.validarcontrol()){
                return;
            }

            let me=this;
            axios.put('/control/update',{
                'id': this.id,
                'documento': this.documento,
                'nombres': this.nombres,
                'apellidos': this.apellidos,
                'documento': this.documento,
                'email': this.email,
                'direccion': this.direccion,
                'cargo': this.cargo,
                'telefono': this.telefono

            }).then(function (response) {
            me.cerrarModal();
            me.listarcontrol(1,'','nombres');
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        desactivarcontrol1(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Quiere registrar la salida?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check fa-2x"></i> Si!',
                cancelButtonText:  '<i class="fa fa-times fa-2x"></i> No',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('control/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarcontrol(1,'','control');
                    swalWithBootstrapButtons.fire(
                    'Salida realizada!'
                    )
                    me.desactivarcontrol(id);
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarcontrol();
                }
                })
            },

            desactivarcontrol(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Quiere registrar la salida?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check fa-2x"></i> Si!',
                cancelButtonText:  '<i class="fa fa-times fa-2x"></i> No',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.post('historico/store2',{
                        'idEmpleado': id
                    }).then(function (response) {
                    me.listarhistorico(1,'','control');
                    swalWithBootstrapButtons.fire(
                    'Salida realizada!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarhistorico();
                }
                })
            },
            activarcontrol(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Quiere registra el ingreso?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check fa-2x"></i> Si!',
                cancelButtonText:  '<i class="fa fa-times fa-2x"></i> No',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.post('historico/store',{
                        'idEmpleado': id
                    }).then(function (response) {
                    me.listarhistorico(1,'','control');
                    
                                            
                  swalWithBootstrapButtons.fire(
                    'Ingreso realizado!'
                    )
                    
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarhistorico();
                }
                })
            },
            activarcontrol1(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Quiere registra el ingreso?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check fa-2x"></i> Si!',
                cancelButtonText:  '<i class="fa fa-times fa-2x"></i> No',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('control/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarcontrol(1,'','control');
                    
                                            
                  swalWithBootstrapButtons.fire(
                    'Ingreso realizado!'
                    )
                    me.activarcontrol(id);
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarcontrol();
                }
                })
            },
        validarcontrol(){
            this.errorcontrol=0;
            this.errorMensaje=[];
            
            if (!this.documento) this.errorMensaje.push("El documento del control no puede estar vacio");
            if (!this.email) this.errorMensaje.push("El email del control no puede estar vacio");
            if (!this.nombres) this.errorMensaje.push("El nombre del control no puede estar vacio");
            if (!this.apellidos) this.errorMensaje.push("Los apellidos del control no puede estar vacio");
            if (!this.direccion) this.errorMensaje.push("El direccion del empleado no puede estar vacio");
            if (!this.cargo) this.errorMensaje.push("el cargo del empleado no puede estar vacio");
            if (!this.telefono) this.errorMensaje.push("El telefono del empleado no puede estar vacio");
            if (this.errorMensaje.length) this.errorcontrol=1;

            return this.errorcontrol;
        },
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.control='';
        },
        abrirModal(modelo, accion, data=[]){
        //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
        switch(modelo){
            case "control":
            {
                switch (accion) {
                    case 'crear':{
                        this.modal=1;
                        this.documento='';
                        this.email='';
                        this.nombres='';
                        this.apellidos='';
                        this.direccion='';
                        this.cargo='';
                        this.telefono='';
                        this.tituloModal='Crear nuevo control';
                        this.tipoAccion= 1;
                        break;
                    }
                    case 'actualizar':{
                        //console.log(data);
                        this.modal=1;
                        this.tituloModal='Editar control';
                        this.tipoAccion= 2;
                        this.id=data['id'];
                        this.documento=data['documento'];
                        this.email=data['email'];
                        this.nombres=data['nombres'];
                        this.apellidos=data['apellidos'];
                        this.direccion=data['direccion'];
                        this.telefono=data['telefono'];
                        this.cargo=data['cargo'];
                        break;
                    }
                }
            }
        }
        }
    },
    mounted() {
        this.listarcontrol(1,this.buscar,this.criterio);
        this.listarhistorico(1,this.buscar,this.criterio);
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
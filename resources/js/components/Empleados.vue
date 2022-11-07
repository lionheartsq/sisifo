<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Empleados</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->

                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Empleados &nbsp;
                        <button type="button" @click="abrirModal('empleados','crear')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                    <option value="documento">Documento</option>
                                    <option value="email">Email</option>
                                    <option value="nombres">Nombres</option>
                                    <option value="apellidos">Apellidos</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarempleados(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarempleados(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Documento</th>
                                    <th>Email</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Direccion</th>
                                    <th>Cargo</th>
                                    <th>Telefono</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="empleados in arrayempleados" :key="empleados.id">
                                    <td>
                                    <button type="button" @click="abrirModal('empleados','actualizar',empleados)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil" title="Editar datos"></i>
                                    </button> &nbsp;

                                    <template v-if="empleados.estado == '1'">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarempleados(empleados.id)">
                                            <i class="icon-trash" title="Desactivar"></i>
                                        </button>
                                    </template>
                                    <template v-if="empleados.estado == '2'">
                                        <button type="button" class="btn btn-success btn-sm" @click="activarempleados(empleados.id)">
                                            <i class="icon-check" title="Reactivar"></i>
                                        </button>
                                    </template>

                                    </td>
                                    <td v-text="empleados.documento"></td>
                                    <td v-text="empleados.email"></td>
                                    <td v-text="empleados.nombres"></td>
                                    <td v-text="empleados.apellidos"></td>
                                    <td v-text="empleados.direccion"></td>
                                    <td v-text="empleados.cargo"></td>
                                    <td v-text="empleados.telefono"></td>
                                    
                                    <td>
                                        <div v-if="empleados.estado == '1'">
                                        <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-if="empleados.estado == '2'">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Documento</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="documento" class="form-control" placeholder="Documento del empleado">
                                        <span class="help-block">(*) Ingrese el documento del empleado</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombres</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombres" class="form-control" placeholder="Nombres del empleado">
                                        <span class="help-block">(*) Ingrese los nombres del empleado</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Apellidos</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellidos" class="form-control" placeholder="Apellidos del empleado">
                                        <span class="help-block">(*) Ingrese los apellidos del empleado</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">E-mail</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="E-mail del empleado">
                                        <span class="help-block">(*) Ingrese el e-mail del empleado</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="direccion del empleado">
                                        <span class="help-block">(*) Ingrese la direccion del empleado</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Cargo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="cargo" class="form-control" placeholder="cargo del empleado">
                                        <span class="help-block">(*) Ingrese el cargo del empleado</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="telefono" class="form-control" placeholder="telefono del empleado">
                                        <span class="help-block">(*) Ingrese el telefono del empleado</span>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group row div-error" v-show="errorempleados">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearempleados()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarempleados()">Editar</button>
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
            idEmpresa:1,
            idRol:2,
            estado:'',
            arrayempleados : [],
            modal : 0,
            tituloModal : '',
            tipoAccion : 0,
            errorempleados : 0,
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
            criterio : 'empleados',
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
        listarempleados(page,buscar,criterio){
            let me=this;
            var url='/empleados?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            // Make a request for a user with a given ID
            axios.get(url).then(function (response) {
                // handle success
            var respuesta=response.data;
            me.arrayempleados=respuesta.empleados.data;
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
            me.listarempleados(page,buscar,criterio);
        },
        crearempleados(){
            //valido con el metodo de validacion creado
            if(this.validarempleados()){
                return;
            }

            let me=this;
            axios.post('/empleados/store',{
                'nombres': this.nombres,
                'apellidos': this.apellidos,
                'documento': this.documento,
                'email': this.email,
                'direccion': this.direccion,
                'cargo': this.cargo,
                'telefono': this.telefono
            }).then(function (response) {
            me.cerrarModal();
            me.listarempleados(1,'','nombres');
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        editarempleados(){
            if(this.validarempleados()){
                return;
            }

            let me=this;
            axios.put('/empleados/update',{
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
            me.listarempleados(1,'','nombres');
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        desactivarempleados(id){
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
                axios.put('/empleados/deactivate',{
                    'id': id
                }).then(function (response) {
                me.listarempleados(1,'','nombres');
                swalWithBootstrapButtons.fire(
                'empleados desactivado!'
                )
                }).catch(function (error) {
                    console.log(error);
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                me.listarempleados();
            }
            })
        },
        activarempleados(id){
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
                axios.put('/empleado/activate',{
                    'id': id
                }).then(function (response) {
                me.listarempleados(1,'','empleados');
                swalWithBootstrapButtons.fire(
                'empleados activado!'
                )
                }).catch(function (error) {
                    console.log(error);
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                me.listarempleados();
            }
            })
        },
        validarempleados(){
            this.errorempleados=0;
            this.errorMensaje=[];
            
            if (!this.documento) this.errorMensaje.push("El documento del empleado no puede estar vacio");
            if (!this.email) this.errorMensaje.push("El email del empleado no puede estar vacio");
            if (!this.nombres) this.errorMensaje.push("El nombre del empleado no puede estar vacio");
            if (!this.apellidos) this.errorMensaje.push("Los apellidos del empleado no pueden estar vacio");
            if (!this.direccion) this.errorMensaje.push("El direccion del empleado no puede estar vacia");
            if (!this.cargo) this.errorMensaje.push("el cargo del empleado no puede estar vacio");
            if (!this.telefono) this.errorMensaje.push("El telefono del empleado no puede estar vacio");
            if (this.errorMensaje.length) this.errorempleados=1;

            return this.errorempleados;
        },
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.empleados='';
        },
        abrirModal(modelo, accion, data=[]){
        //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
        switch(modelo){
            case "empleados":
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
                        this.tituloModal='Crear nuevo empleado';
                        this.tipoAccion= 1;
                        break;
                    }
                    case 'actualizar':{
                        //console.log(data);
                        this.modal=1;
                        this.tituloModal='Editar empleado';
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
        this.listarempleados(1,this.buscar,this.criterio);
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
<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Marcas
                        <button type="button" @click="abrirModal('marca','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="nombre">Nombre</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarMarca(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarMarca(1,buscar,criterio)" class="btn btn-dark"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="marca in arrayMarca" :key="marca.id">
                                    <td v-text="marca.nombre"></td>
                                    <td>
                                        <div v-if="marca.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('marca','actualizar',marca)" class="btn btn-warning btn-sm">
                                        <i class="icon-pencil"></i>
                                        </button>&nbsp;
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" @click="eliminarMarca(marca)">
                                        <i class="icon-trash"></i>
                                        </button>&nbsp;
                                        <template v-if="marca.condicion">
                                            <button type="button" class="btn btn-dark btn-sm" @click="desactivarMarca(marca.id)">
                                                <i class="fa fa-ban"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarMarca(marca.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination justify-content-center">
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
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dark modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titulo"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de categoría">
                                        
                                    </div>
                                </div>
                                <div v-show="errorMarca" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjMarca" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="accion==1" class="btn btn-dark" @click="registrarMarca()">Guardar</button>
                            <button type="button" v-if="accion==2" class="btn btn-dark" @click="actualizarMarca()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
                </div>
                <!-- Inicio del modal Eliminar -->
                    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none" aria-hidden="true">
                        <div class="modal-dialog modal-danger" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Eliminar Marca</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Estás seguro de eliminaar el registro?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Cerrar
                                    </button>
                                    <button type="button" @click="eliminarMarca" class="btn btn-danger">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- Fin del modal Eliminar -->
    </main>
</template>

<script>
    export default {
        data (){
            return {
                id_marca: 0,
                nombre : '',                
                arrayMarca : [],
                modal : 0,
                titulo : '',
                accion : 0,
                errorMarca : 0,
                errorMostrarMsjMarca : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },

        methods : {
            listarMarca (page,buscar,criterio){
                let me=this;
                var url= '/marca?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayMarca = respuesta.marcas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarMarca(page,buscar,criterio);
            },
            registrarMarca(){
                if (this.validarMarca()){
                    return;
                }
                
                let me = this;
                axios.post('/marca/registrar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarMarca(1,'','nombre');
                    me.mensaje("¡Se actualizó correctamente!");
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarMarca(){
                if (this.validarMarca()){
                    return;
                }
                let me = this;
                axios.put('/marca/actualizar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'id': this.id_marca
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarMarca(1,'','nombre');
                    me.mensaje("¡Se actualizó correctamente!");

                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarMarca(id){
            swal({  
                title: '¿Está seguro de desactivar esta marca?',
                type: 'warning',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                // buttonsStyling: false,
                reverseButtons: true,
                
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/marca/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarMarca(1,'','nombre');
                        swal(
                        '¡Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                }
                }) 
            },
            activarMarca(id){
            swal({
                title: 'Esta seguro de activar esta categoría?',
                type: 'warning',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                // buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/marca/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarMarca(1,'','nombre');
                        swal(
                        '¡Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                }
                }) 
            },
            eliminarMarca(data = []) {
            let me = this;
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esto!",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "¡No, cancélalo!",
                confirmButtonText: "¡Si, bórralo!",
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "/marca/eliminar";
                    axios
                        .post(url, {
                            id: data["id"],
                        })
                        .then(function (response) {
                            me.listarMarca(1, '', 'nombre');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    Swal.fire("¡Eliminado!", "El registro ha sido eliminado.", "success");
                }
            });
        }, 
            validarMarca(){
                this.errorMarca=0;
                this.errorMostrarMsjMarca =[];
                if (!this.nombre) this.errorMostrarMsjMarca.push("El nombre de la marca no puede estar vacío.");
                if (this.errorMostrarMsjMarca.length) this.errorMarca = 1;
                return this.errorMarca;
            },
            cerrarModal(){
                this.modal=0;
                this.titulo='';
                this.nombre='';
            },
            limpiar() {
            this.nombre = "";
            },
            mensaje(msj) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: msj,
                    showConfirmButton: false,
                    timer: 2000,
                });
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "marca":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.titulo = 'Registrar Marca';
                                this.nombre= '';
                                this.accion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.titulo='Actualizar Marca';
                                this.accion=2;
                                this.id_marca=data['id'];
                                this.nombre = data['nombre'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        mounted() {
            this.listarMarca(1,this.buscar,this.criterio);
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

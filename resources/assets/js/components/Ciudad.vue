<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-map-marker" ></i> Ciudades
                <!-- <button type="button" class="btn btn-dark" data-toggle="modal" @click="abrirModal('guardar')">
                    <i class="icon-plus"></i>
                    &nbsp;Nuevo
                </button>-->
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre">Ciudad</option>
                            </select>
                                    <input type="text"  @keypress="listarCiudad(1,buscar,criterio);" v-model="buscar" class="form-control" placeholder="Buscar texto">
                                    <button type="submit"  @click="listarCiudad(1,buscar,criterio);" class="btn btn-dark"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Ciudad</th>
                            <th>Departamento</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="objeto in arrayDatos" :key="objeto.id">
                            <td v-text="objeto.nombre"></td>
                            <td v-text="objeto.nomDptos"></td>
                            <td>
                                <button type="button" @click="abrirModal('editar',objeto)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button>                          
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
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" id="modalNuevo" :class="{ mostrar: modal }" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dark modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="titulo"></h4>
                    <button type="button" class="close" @click="cerrarModal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" v-model="nombre" id="nombre" name="nombre" class="form-control" placeholder="Nombre de la sucursal" />
                                <span class="help-block">(*) Ingrese el nombre del la ciudad</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">
                                Departamento
                            </label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="id_departamento" id="exampleFormControlSelect1">
                                    <option v-for="objeto in arrayDpto" :key="objeto.id" :value="objeto.id" v-text="objeto.nombre"></option>
                                </select>
                                <span class="help-block">(*) Seleccione el departamento</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="cerrarModal" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <!-- <button v-show="accion == 0" type="button" @click="RegistrarCiudades" class="btn btn-dark">Guardar</button>-->
                    <button v-show="accion" type="button" @click="actualizarCiudad" class="btn btn-dark">Actualizar</button> 
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</main>
</template>

<script>
export default {
    data() {
        return {
            arrayDatos: [],
            nombre: '',
            id_ciudad: 0,
            nomDptos: '',
            modal: 0,
            titulo: '',
            accion: 0,
            arrayDpto: [],
            id_departamento: 0,
            // variables de pagination
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
    methods: {
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            //va a la pagina actual
            me.pagination.current_page = page;
            //envia al metodo para traer los datos
            me.listarCiudad(page,buscar,criterio);
        },
        listarCiudad: function (page, buscar, criterio) {
            let me = this
                var url= '/ciudad?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayDatos = respuesta.ciudades.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        selectDpto() {
            let me = this
            var url = '/departamento/selectDpto';
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayDpto = respuesta.departamentos;
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        actualizarCiudad() {
            let me = this
            var url = '/ciudad/actualizar';
            axios
                .put(url, {
                    id: this.id_ciudad,
                    nombre: this.nombre,
                    id_departamento: this.id_departamento,
                })
                .then(function (response) {
                    me.listarCiudad();
                    me.mensaje('Se actualizó correctamente');
                    me.cerrarModal();
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        abrirModal(accion, data = []) {
            switch (accion) {
                case 'guardar':
                    this.titulo = 'Registrar ciudades';
                    this.accion = 0;
                    this.limpiar();
                    break
                case 'editar':
                    this.titulo = 'Editar ciudades'
                    this.accion = 1;
                    this.id_ciudad= data['id'];
                    this.nombre = data['nombre'];
                    this.id_departamento = data['id_departamento'];
                    break
                default:
                    break
            }
            this.modal = 1
        },
        cerrarModal() {
            this.modal = 0
        },
        limpiar() {
            this.nombre = "";
            this.id_departamento = "";
        },
        mensaje(msj) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: msj,
                showConfirmButton: false,
                timer: 2000,
            })
        }
    },
    computed: {
        isActived: function () {
            return this.pagination.current_page
        },
        //Calcula los elementos de la paginación
        pagesNumber: function () {
            if (!this.pagination.to) {
                return []
            }
            var from = this.pagination.current_page - this.offset
            if (from < 1) {
                from = 1
            }
            var to = from + this.offset * 2
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page
            }
            var pagesArray = []
            while (from <= to) {
                pagesArray.push(from)
                from++
            }
            return pagesArray
        }
    },
    mounted() {
        console.log('Component mounted.')
        this.selectDpto();
        this.listarCiudad(1, this.buscar, this.criterio);
    }
};
</script>

<style>
.modal-content {
    width: 100% !important;
    position: absolute !important;
}

.mostrar {
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #9995957a;
}
</style>

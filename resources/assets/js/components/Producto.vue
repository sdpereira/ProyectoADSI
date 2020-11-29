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
                <i class="fa fa-book"></i> Productos
                <button type="button" class="btn btn-dark" data-toggle="modal" @click="abrirModal('producto', 'registrar')">
                    <i class="icon-plus"></i>&nbsp;Agregar
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre">Producto</option>
                            </select>
                            <input type="text" @keyup.enter="listarProducto(1, buscar, criterio)" v-model="buscar" class="form-control" placeholder="Buscar texto" />
                            <button type="submit" @click="listarProducto(1, buscar, criterio)" class="btn btn-dark"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>                            
                            <th>Producto</th>
                            <th>Categoria</th>
                            <th>Codigo</th>
                            <th>Precio (COL$)</th>
                            <th>Stock</th>
                            <th>Marca</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="producto in arrayProducto" :key="producto.id">                            
                            <td v-text="producto.nombre"></td>
                            <td v-text="producto.nomCat"></td>
                            <td v-text="producto.codigo"></td>
                            <td v-text="producto.precio_venta"></td>
                            <td v-text="producto.stock"></td>
                            <td v-text="producto.nomMr"></td>
                            <td>
                                <div v-if="producto.condicion">
                                    <span class="badge badge-success">Activo</span>
                                </div>
                                <div v-else>
                                    <span class="badge badge-danger">Desactivado</span>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('producto', 'actualizar', producto)"><i class="fa fa-edit"></i></button>
                                &nbsp;
                                <button type="button" class="btn btn-danger btn-sm" @click="eliminarProducto(producto)"><i class="icon-trash"></i></button>
                                &nbsp;
                                <template v-if="producto.condicion">
                                    <button type="button" class="btn btn-dark btn-sm" @click="desactivarProducto(producto.id)">
                                        <i class="fa fa-ban"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click="activarProducto(producto.id)">
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
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Anterior</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" :class="{ mostrar: modal }" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none" aria-hidden="true">
        <div class="modal-dialog modal-dark modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="titulo"></h4>
                    <button type="button" @click="cerrarModal()" class="close" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Marca</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="id_marca" id="exampleFormControlSelect1">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="marcas in arrayMarcas" :key="marcas.id" :value="marcas.id" v-text="marcas.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="id_categoria" id="exampleFormControlSelect2">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Codigo</label>
                            <div class="col-md-9">
                                <input type="text" v-model="codigo" class="form-control" placeholder="Codigo de barras" />
                                <barcode :value="codigo" :options="{ format: 'EAN-13' }"> Creando código de barras </barcode>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Producto</label>
                            <div class="col-md-9">
                                <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del producto" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Precio Venta</label>
                            <div class="col-md-9">
                                <input type="number" v-model="precio_venta" class="form-control" placeholder="" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Stock</label>
                            <div class="col-md-9">
                                <input type="number" v-model="stock" class="form-control" placeholder="" />
                            </div>
                        </div>
                            <div v-show="errorProducto" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error"></div>
                                </div>
                            </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()" > Cerrar</button>
                    <button type="button" class="btn btn-dark" @click="registrarProducto()" v-if="accion == 1"> Guardar</button>
                    <button type="button" class="btn btn-dark" @click="actualizarProducto()" v-if="accion == 2"> Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
    <!-- Inicio del modal Eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none" aria-hidden="true">
        <div class="modal-dialog modal-danger" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Eliminar Producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de eliminar el registro?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="button" @click="eliminarProducto" class="btn btn-danger">
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
import VueBarcode from "vue-barcode";

export default {
    data() {
        return {
            id_producto: 0,
            arrayMarcas: [],
            id_marca: 0,
            nomMr: "",
            arrayCategoria:[],
            id_categoria:0,
            nomCat:"",
            codigo: "",
            nombre: "",
            precio_venta: 0,
            stock: 0,
            arrayProducto: [],
            modal: 0,
            titulo: "",
            accion: 0,
            errorProducto: 0,
            errorMostrarMsjProducto: [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
            offset: 3,
            criterio: "nombre",
            buscar: "",
        };
    },
    components: {
    'barcode': VueBarcode,
    },
    computed: {
    isActived: function () {
        return this.pagination.current_page;
    },
    pagesNumber: function () {
        if (!this.pagination.to) {
        return [];
        }
        var from = this.pagination.current_page - this.offset;
        if (from < 1) {
            from = 1;
        }

        var to = from + this.offset * 2;
        if (to >= this.pagination.last_page) {
            to = this.pagination.last_page;
        }
        var pagesArray = [];
        while (from <= to) {
            pagesArray.push(from);
            from++;
        }
        return pagesArray;
        },
    },
    methods: {
        listarProducto(page, buscar, criterio) {
            let me = this;
            var url = "/producto?page=" + page + "&buscar=" + buscar + "&criterio=" + criterio;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayProducto = respuesta.productos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectMarca() {
            let me = this;
            var url = "/marca/selectMarca";
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayMarcas = respuesta.marcas;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectCategoria() {
            let me = this;
            var url = "categoria/selectCategoria";
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayCategoria = respuesta.categorias;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            //Actualiza  la pagina actual
            me.pagination.current_page = page;
            me.listarProducto(page, buscar, criterio);
        },
        registrarProducto() {
            if (this.validarProducto()) {
                return;
            }
            let me = this;
            axios
                .post("/producto/registrar", {
                    'id_marca': this.id_marca,
                    'id_categoria': this.id_categoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'stock': this.stock,
                    'precio_venta': this.precio_venta,
                })
                .then(function (response) {
                    me.listarProducto(1, "", "nombre");
                    me.mensaje("¡Se guardó correctamente!");
                    me.cerrarModal();
                })
                .catch(function (error) {
                console.log(error);
                });
        },
        actualizarProducto() {
            if (this.validarProducto()) {
                return;
            }
            let me = this;
            axios
                .put("/producto/actualizar", {
                    'id':this.id_producto,
                    'id_marca': this.id_marca,
                    'id_categoria': this.id_categoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'stock': this.stock,
                    'precio_venta': this.precio_venta,
                    'id':this.id_producto
            })
            .then(function (response) {
                me.listarProducto(1, "", "nombre");
                me.cerrarModal();
                me.mensaje("¡Se guardó correctamente!");
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        eliminarProducto(data = []) {
        let me = this;
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "¡No, cancélalo!",
            confirmButtonText: "¡Si, bórralo!"
        }).then(result => {
            if (result.isConfirmed) {
                var url = "/producto/eliminar";
                axios
                    .post(url, {
                        id: data["id"]
                    })
                    .then(function (response) {
                        me.listarProducto(1, '', 'nombre');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                Swal.fire(
                    "¡Eliminado!",
                    "El dato ha sido eliminado.",
                    "success")
                }
            })
        },
        desactivarProducto(id){
            swal({  
                title: '¿Está seguro de desactivar esta producto?',
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
                    axios.put('/producto/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarProducto(1,'','nombre');
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
            activarProducto(id){
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
                    axios.put('/producto/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarProducto(1,'','nombre');
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
        validarProducto() {
            this.errorProducto = 0;
            this.errorMostrarMsjProducto = [];
                if (this.id_marca == 0) this.errorMostrarMsjProducto.push("(*)Selecciona una marca");
                if (!this.nombre) this.errorMostrarMsjProducto.push("(*)El nombre del producto no puede estar vacio");
                if (!this.precio_venta) this.errorMostrarMsjProducto.push("(*)El precio venta del producto debe ser un numero y no puede estar vacio");
                if (!this.stock) this.errorMostrarMsjProducto.push("(*)El stock del producto debe ser un numero y no puede estar vacio");
                if (this.errorMostrarMsjProducto.length) this.errorProducto = 1;
                return this.errorProducto;
        },
        cerrarModal() {
            this.modal = 0;
            this.titulo = "";
            this.id_marca = 0;
            this.nomMr = "";
            this.id_categoria = 0;
            this.nomCat = "";
            this.codigo = "";
            this.nombre = "";
            this.precio_venta = 0;
            this.stock = 0;
            this.imagen = "";
            this.errorProducto = 0;
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
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "producto": {
                switch (accion) {
                    case "registrar": {
                    this.modal = 1;
                    this.titulo = "Agregar Producto";
                    this.id_marca = 0;
                    this.nomMr = "";
                    this.id_categoria = 0;
                    this.nomCat = "";
                    this.codigo = "";
                    this.nombre = "";
                    this.precio_venta = 0;
                    this.stock = 0;
                    this.accion = 1;
                    break;
                    }

                    case "actualizar": {
                    //console.log(data);
                    this.modal = 1;
                    this.titulo = "Editar Producto";
                    this.accion = 2;
                    this.id_producto = data["id"];
                    this.id_marca = data["id_marca"];
                    this.codigo = data["codigo"];
                    this.nombre = data["nombre"];
                    this.precio_venta = data["precio_venta"];
                    this.stock = data["stock"];
                    break;
                    }
                }
                }
            }
            this.selectMarca();
            this.selectCategoria();
        },
    },
        mounted() {
            console.log("Component mounted.");
            this.selectMarca();
            this.selectCategoria();
            this.listarProducto(1, this.buscar, this.criterio);
        },
        
};
</script>
<style>
    .modal-content {
    width: 100% !important;
    position: absolute !important;
    }

    .mostrar {
    height: 1000px;
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
    }

    .div-error {
    display: flex;
    justify-content: center;
    }

    .text-error {
    color: red !important;
    font-weight: bold;
    font-size: 20px;
    }
</style>

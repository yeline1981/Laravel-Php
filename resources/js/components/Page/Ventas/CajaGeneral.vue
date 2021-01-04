<template>

    <main class="main">
        <!-- Breadcrumb-->

        <notification-component :errorMsj="errorMostrarMsj"
                                :texto="textonotificar"
                                :shownotif="shownotif"
                                :ruta="ruta">
        </notification-component>

        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Caja General
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="idtrabajo">ID</option>
                                    <option value="pago">Fecha pago</option>
                                    <option value="cliente">Cliente</option>
                                    <option value="producto">Producto</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarPagos(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" @click="listarPagos(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                        &nbsp;
                        <button type="button" @click="Limpiar()" class="btn btn-light btn-sm" >
                                <i class="fa fa-eraser"></i>
                        </button>

                    </div>



                    <table class="table table-striped table-bordered table-sm " cellspacing="0"  width="100%">
                        <thead>
                        <tr>
                            <th >ID Trabajo </th>
                            <th >Cliente</th>
                            <th >Producto </th>
                            <th >Fecha Pago</th>
                            <th >Ingresado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="aviso in arrayAvisos" :key="aviso.id">
                            <td v-text="aviso.idtrabajo" ></td>
                            <td v-text="aviso.cliente" ></td>
                            <td v-text="aviso.producto" ></td>
                            <td v-text="aviso.pago" ></td>
                            <td v-text="aviso.ingresa" ></td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="clearfix ">
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
            </div>


        </div>

    </main>

</template>

<script>
    import EventBus from "@/EventBus.js";
    import Notifications from "@/components/Layouts/Notifications";
    import Base from "@/components/Layouts/Base";

    export default {
        name: 'CajaGeneral',
        props: ['ruta'],
        extends: Base,
        components: {
            'notification-component': Notifications
        },
       data(){
         return {
            arrayAvisos: [],
            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
            },
            offset : 3,
            criterio : 'idtrabajo',
            buscar: null,
            total: 0,
            modal1: 0,
            modal2: 0,
            id: '',
            precio: '',
            iva: '',
            total: '',
            senna: '',
            ingresa: '',
            factura: '',
            tituloModal: '',
            texto: '',

            arrayFacturaciones: [],
            facturado: '',
            codigo: ''

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
        methods : {
            listarPagos (page,buscar,criterio){
                let me=this;

                var url= me.ruta + '/caja/general?page=' + page ;
                var filter  = 0;

                if (buscar !== null){
                    url = url + '&filter&' + criterio + '=' + buscar ;
                }

                axios.get(url).then(function (response) {
                    console.log(response);

                    me.arrayAvisos = response.data.caja.data;
                    me.pagination= response.data.pagination;
                    me.total = response.data.pagination.total;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarPagos(page,buscar,criterio);
            },
            Limpiar(){
                this.criterio = 'idtrabajo';
                this.buscar = null;
                this.listarPagos(1, this.buscar, this.criterio);
            },


        },
        created: function() {
            console.log('Caja general');
            this.listarPagos(1, this.buscar, this.criterio);

            if (this.$parent.estado == 1){
                this.textonotificar = 'Solicitud aceptada';
                this.showAlert(1);
                this.$parent.estado = 0;
            };


        },

    }
</script>

<style scoped>
    th, td{
        text-align: center;
    }

</style>

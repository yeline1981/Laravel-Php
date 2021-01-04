<template>
    <main class="main">
        <div class="container-fluid">

                <div class="card">
                  <div class="card-header">
                    <i class="fa fa-align-justify"></i> Estado Deudores
                  </div>
                  <div class="card-body">
                    <!--
                    <div class="form-group row">
                        <div class="col-md-8">
                            <div class="input-group">
                                <select class="form-control col-md-4" v-model="criterio">
                                    <option value="nombre">Cliente</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarEstados(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" @click="listarEstados(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                        &nbsp;
                        <button type="button" @click="Limpiar()" class="btn btn-light btn-sm" >
                                <i class="fa fa-eraser"></i>
                        </button>
                    </div>
                    -->

                    <table class="table table-responsive-sm table-bordered table-striped table-sm">
                      <thead>
                        <tr>
                          <th >Cliente</th>
                          <th >Cant Trabajos</th>
                          <th >Importe</th>
                          <th >Deuda</th>
                          <!--
                          <th >Último pago</th>
                          -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="estado in arrayEstados" :key="estado.idcliente">
                          <td v-text="estado.nombre"></td>
                          <td v-text="estado.cant"></td>
                          <td v-text="estado.importe"></td>
                          <td v-text="estado.deuda"></td>
                          <!--
                          <td v-text="estado.ultimopago"></td>
                          -->
                        </tr>

                      </tbody>
                    </table>

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

    </main>

</template>
<script>

export default {
        props : ['ruta'] ,

        components: {

        },
        data(){
            return {
                arrayEstados: [],

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
            listarEstados (page,buscar,criterio){
                let me=this;

                var url= me.ruta +  '/caja/estados?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    console.log(response);
                    me.arrayEstados = response.data.deudas.data;
                    me.pagination= response.data.pagination;
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
                me.listarEstados(page,buscar,criterio);
            },

      },
      mounted() {
          this.listarEstados(1, this.buscar, this.criterio);
      }
    }
</script>

<style scoped>
    th, td{
        text-align: center;
    }

</style>

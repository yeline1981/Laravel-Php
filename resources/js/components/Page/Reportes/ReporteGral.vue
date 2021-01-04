<template>
   <main class="main">

        <div class="container-fluid">

                <div class="card">
                  <div class="card-header">
                    <i class="icon-chart"></i> Reporte General
                  </div>

                  <div class="card-body">

                    <div class="form-group row col-md-12">

                        <div class="form-group row col-md-4">
                            <label class="col-md-3 col-form-label" style="padding-right:0px !important">Desde</label>
                            <div class="col-md-9">
                            <input class="form-control" v-model="desde" type="date" placeholder="date">
                            </div>
                        </div>

                        <div class="form-group row col-md-4">
                            <label class="col-md-3 col-form-label" style="padding-right:0px !important">Hasta</label>
                            <div class="col-md-9">
                            <input class="form-control" v-model="hasta" type="date" placeholder="date">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" @click="fillData()" >
                                Filtrar <i class="fa fa-filter"></i>
                            </button>
                        </div>
                        &nbsp;
                        <div class="text-right">
                            <button type="button" @click="Limpiar()" class="btn btn-light" >
                                    <i class="fa fa-eraser"></i>
                            </button>
                        </div>

                    </div>


                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Cantidad de Trabajo por Tipos</div>
                                <div class="card-body">
                                    <div class="row">
                                        <pie-chart :data="chartTipos" :options="chartOptions" v-if="loadedA"></pie-chart>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Facturado por Tipos de Trabajo</div>
                                <div class="card-body">
                                    <div class="row">
                                        <pie-chart :data="chartImporte" :options="chartOptions" v-if="loadedB"></pie-chart>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                  </div>

                </div>

        </div>
   </main>
</template>

<script>


import PieChart  from './PieChart'

    export default {

      props:['ruta'],
      components: {
        PieChart
      },
      data(){
        return {
            desde: null,
            hasta: null,
            loadedA: 0,
            loadedB: 0,
            chartOptions: {
                hoverBorderWidth: 20
            },
            chartTipos: null,
            chartImporte: null,

        }
      },
      computed:{

      },
      methods: {
          fillData(){
                let me = this;

                var url= me.ruta + '/reportes/general';

                if (me.desde !== null){
                    url = url + '?desde=' + me.desde;
                }

                if (me.hasta != null){
                    url = url + '&hasta=' + me.hasta;
                }

                me.loadedA = 0;
                me.loadedB = 0;

                axios.get(url)
                .then(function (response) {
                    // handle success
                    console.log(response);

                    var dataArray = response.data.tipos;
                    var dataColor = [];

                    me.chartTipos = new Object();
                    me.chartTipos.labels = [];
                    me.chartTipos.datasets = [];

                    var dataset = new Object();
                    dataset.data = [];
                    dataset.backgroundColor = [];

                    for (let i = 0; i < dataArray.length; i++) {
                        me.chartTipos.labels.push(dataArray[i].tipo);
                        dataset.data.push(dataArray[i].total);
                        dataColor.push(me.colorHEX());
                    }

                   dataset.backgroundColor = dataColor;
                   me.chartTipos.datasets.push(dataset);

                   me.loadedA = 1;
//-------------
                   var dataArray = response.data.importe;
                   var data = [];

                    me.chartImporte = new Object();
                    me.chartImporte.labels = [];
                    me.chartImporte.datasets = [];

                    var datasetB = new Object();
                    datasetB.data = [];
                    datasetB.backgroundColor = me.chartTipos.datasets;

                    for (let i = 0; i < dataArray.length; i++) {
                        me.chartImporte.labels.push(dataArray[i].tipo);
                        datasetB.data.push(dataArray[i].total);
                    }

                   datasetB.backgroundColor = dataColor;
                   me.chartImporte.datasets.push(datasetB);

                   me.loadedB = 1;

                })
                .catch(function (error) {
                    // handle error
                    console.log(error.response);
                });
          },
          colorHEX(){
                var simbolos, color;
                simbolos = "0123456789ABCDEF";
                color = "#";

                for(var i = 0; i < 6; i++){
                    color = color + simbolos[Math.floor(Math.random() * 16)];
                }
                return color;
          },
          Limpiar(){
              this.desde = null;
              this.hasta = null;
          }

      },
      mounted() {

      },
      created: function() {
          this.fillData();
      }
    }
</script>

<style>

</style>

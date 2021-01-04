<template>
   <main class="main">

        <div class="container-fluid">

                <div class="card">
                  <div class="card-header">
                    <i class="icon-chart"></i> Tendencias
                  </div>

                  <div class="card-body">

                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Ingresos</div>
                                <div class="card-body">
                                    <div class="row">
                                        <bar-chart :chartdata="importecollection" v-if="loadedI"></bar-chart>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Trabajos Vendidos</div>
                                <div class="card-body">
                                    <div class="row">
                                        <bar-chart :chartdata="avisoscollection" v-if="loadedA"></bar-chart>
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

import BarChart  from './BarChart'


    export default {
      props:['ruta'],
      components: {
        BarChart
      },
      data(){
        return {

            avisoscollection: null,
            importecollection: null,
            piechartData: null,
            loadedA: false,
            loadedI: false,
            loadedP: false,

            Months : Object.freeze({
                1: 'Enero',
                2: 'Febrero',
                3: 'Marzo',
                4: 'Abril',
                5: 'Mayo',
                6: 'Junio',
                7: 'Julio',
                8: 'Agosto',
                9: 'Septiembre',
                10: 'Octubre',
                11: 'Noviembre',
                12: 'Diciembre'
            }),

        }
      },
      computed:{

      },
      methods: {

            fillData () {

                let me = this;

                var url= me.ruta + '/reportes/tendencia';
                axios.get(url)
                .then(function (response) {
                    // handle success
                    console.log(response);

                    var importesArray = response.data.importe;

                    var importe = new Object();
                    importe.label = 'Monto';
                    importe.backgroundColor = 'rgba(255, 99, 132, 0.2)';
                    importe.borderColor = 'rgba(255, 99, 132, 1)';
                    importe.borderWidth = 1;
                    importe.data = [];

                    var monthsImporte = [];

                    importesArray.forEach(function (item) {
                        importe.data.unshift(item.valor );
                        monthsImporte.unshift(me.Months[item.mes]);
                    });

                    me.importecollection = new Object();
                    me.importecollection.datasets = [];
                    me.importecollection.datasets.push(importe);
                    me.importecollection.labels = monthsImporte;
                    me.loadedI = true;


                    var ventasArray = response.data.vendidos;

                    var venta = new Object();
                    venta.label = 'Total';
                    venta.backgroundColor = 'rgba(54, 162, 235, 0.2)';
                    venta.borderColor = 'rgba(54, 162, 235, 1)';
                    venta.borderWidth = 1;
                    venta.data = [];

                    var months = [];

                    ventasArray.forEach(function (item) {
                        venta.data.unshift(item.valor );
                        months.unshift(me.Months[item.mes]);
                    });

                    me.avisoscollection = new Object();
                    me.avisoscollection.datasets = [];
                    me.avisoscollection.datasets.push(venta);
                    me.avisoscollection.labels = months;
                    me.loadedA = true;


                })
                .catch(function (error) {
                    // handle error
                    console.log(error.response);
                });
            }

      },
      mounted() {
          console.log('Montando reporte');
      },
      created: function() {
          console.log('Creando reporte');
          this.loaded = false
          this.fillData();
      }
    }
</script>



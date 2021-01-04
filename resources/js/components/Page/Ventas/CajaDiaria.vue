<template>

    <main class="main">
        <!-- Breadcrumb-->

        <notification-component :errorMsj="errorMostrarMsj"
                                :texto="textonotificar"
                                :shownotif="shownotif"
                                :ruta="ruta">
        </notification-component>

        <div class="container-fluid">

        <!-- card -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Venta del Día
                <div class="float-right">Fecha: {{ fecha }}	 </div>
            </div>

            <div class="card-body">

                <table class="table table-striped table-bordered table-sm " cellspacing="0"  width="100%">
                <thead>
                    <tr>
                    <th style="text-align: center; ">ID</th>
                    <th style="text-align: center; ">Factura</th>
                    <th style="text-align: center; ">Cliente</th>
                    <th style="text-align: center; ">Producto</th>
                    <th style="text-align: center; ">Ingresado</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="aviso in arrayAvisos" :key="aviso.id">

                    <td v-text="aviso.idtrabajo" style="text-align: center; "></td>
                    <td v-text="aviso.factura" style="text-align: center; "></td>
                    <td v-text="aviso.cliente" style="text-align: center; "></td>
                    <td v-text="aviso.tipo" style="text-align: center; "></td>
                    <td v-text="aviso.total" style="text-align: center; "></td>

                    </tr>

                </tbody>
                <tfoot>
                    <tr>
                    <th colspan="4"></th>
                    <th >Nº Trabajos: {{ arrayAvisos.length }}</th>

                    </tr>
                    <tr>
                    <th colspan="4"></th>
                    <th >Total: {{ costoTotal }}</th>
                    </tr>
                </tfoot>
                </table>


            </div>
            <!-- card-body -->
        </div>

        </div>

    </main>

</template>

<script>

import Notifications from "@/components/Layouts/Notifications";
import Base from "@/components/Layouts/Base";

    export default {
        props : ['ruta'] ,
        extends: Base,
        components: {
            'notification-component': Notifications
        },
        data(){
            return {

                arrayAvisos: [],
                costoTotal:0,
                fecha: ''
            }
      },

      methods: {
          listarAvisos(page) {
                let me = this;
                var url=  me.ruta + '/caja/ventadiaria';
                axios.get(url)
                .then(function (response) {
                  // handle success
                   console.log(response);
                   me.arrayAvisos = response.data.caja;

                   for(var i=0; i< me.arrayAvisos.length; i++){
                       me.costoTotal += parseInt(me.arrayAvisos[i].total);
                   }
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                });

          },

          VerVale(){
              window.location.href = me.ruta + '/vale';
          }

      },
      mounted() {


          this.listarAvisos();

          var today = new Date();
          var dd = String(today.getDate()).padStart(2, '0');
          var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
          var yyyy = today.getFullYear();

          this.fecha = dd + '/' + mm + '/' + yyyy;
      }
    }
</script>



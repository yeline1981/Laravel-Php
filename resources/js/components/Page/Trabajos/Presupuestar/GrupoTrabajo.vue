<template>

<div class="card" >

    <div class="card-body" >
        <div class="row">

            <div class="col-md-3 teamSelector" v-for="grupo in arrayGrupos" :key="grupo.id"  @click="Siguiente(grupo)">
                <div class="card text-white text-center" :style="{backgroundColor: setColor(grupo.id)}">
                    <div class="card-body">
                        <p style="font-size: 1.1rem!important">{{grupo.friendly_name}}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

</template>


<script>
import EventBus from "@/EventBus";


export default {
    name: 'GrupoTrabajo',
    props : {
                ruta: String
             } ,
    components: {

    },
    data () {
        return {
            arrayTipos: [],
            arrayGrupos: [],
            tipo: null,
            disabled: false,
            colors: [
                "#FFFFFF", //blanco
                "#d8516c", //rojo
                "#9ab65f", //verde
                "#BC8F8F", //rosa palo
                "#778899", //grisazul
                "#aa77da", //magenta
                "#FF7F50", //naranja
                "#d6c95b", //amarillo
                "#2E8B57", //verde ocuro
                "#2c449d", //azul oscuro
                "#9D2C46", //marron
                "#8db2d6", //azul
                "#6b4a83", //magenta
                "#b4a5bd" //gris violeta
            ],
            color: ''
        }
    },
    methods: {

        Siguiente(newValue) {

            this.$emit('grupo', newValue );
            //this.disabled = true;
        },
        selectProducto() {

                let me = this;
                var url= me.ruta +  '/productos';
                axios.get(url)
                .then(function (response) {
                  // handle success
                   console.log(response);
                   var respuesta= response.data;
                   me.arrayTipos= respuesta.tipos;
                })
                .catch(function (error) {
                  // handle error
                  console.log(error.response);
                });
        },
        selectProductoGrupo() {

                let me = this;
                var url= me.ruta +  '/productos/grupos';
                axios.get(url)
                .then(function (response) {
                  // handle success
                   console.log(response);
                   var respuesta= response.data;
                   me.arrayGrupos= respuesta.grupos;
                })
                .catch(function (error) {
                  // handle error
                  console.log(error.response);
                });
        },
        setColor(value) {
            this.color = this.colors[value];
            return this.colors[value];
        },


    },
    created: function() {

        //this.selectProducto();
        this.selectProductoGrupo();

        EventBus.$on('Limpiar', item => {
            console.log('Limpiando en GrupoTrabajos');
            this.tipo = null;
            this.disabled= false;
        });

    }


}
</script>

<style>
.teamSelector
{
  cursor: pointer
}
</style>


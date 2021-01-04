<template>

</template>

<script>


export default {

    name: 'Base',
    props : ['ruta'] ,
    components: {

    },

    data(){
        return {

            dismissCountDown: 5,
            shownotif: 0,
            textonotificar:'',
            errorMostrarMsj : [],
        }
    },
    methods: {
           showAlert(value) {

            this.shownotif = value;

            var cycle = setInterval(()=> {
                this.dismissCountDown--;

                if (this.dismissCountDown === 0) {
                  this.shownotif = 0;
                  this.dismissCountDown = 5;
                  clearInterval(cycle);
                }

              }, 1000);

            },


    },
}
</script>

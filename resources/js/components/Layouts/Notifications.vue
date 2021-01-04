<template>
     <ol class="center" >

            <div v-if="shownotif===1" class="alertok">
                <strong> {{texto}} </strong>
            </div>

            <div v-else-if="shownotif===2" v-for="error in errorMsj" :key="error" v-text="error" class="alerterror">

            </div>
    </ol>

</template>

<script>
export default {
    name: 'Notifications',
    props : {
             ruta: String,
             errorMsj: Array,
             shownotif: {type: Number, required: true },
             texto: String,
             },
      data(){
        return {
            dismissCountDown: 5,
        }
         },
      methods: {
            Show(){

                var cycle = setInterval(()=> {
                    this.dismissCountDown--;

                    if (this.dismissCountDown === 0) {
                        this.dismissCountDown = 5;
                        clearInterval(cycle);
                    }

                }, 1000);
            }
      },
    created(){

    },
    mounted() {

    }
}
</script>

<style scoped>
  .alerterror {
  padding: 20px;
  background-color: #f44336;
  color: white;
  width: 95%;
  height: 50px;
}

.alertok {
  padding: 20px;
  background-color: #27c927;
  color: white;
  width: 95%;
  height: 50px;
}

.center {
  text-align: center;
  list-style-position: inside;
}
</style>

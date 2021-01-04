<template>
    <div class="form-group row justify-content-center">
        <label class="col-md-2 col-form-label" for="pa_papel">{{titulo}} *</label>
        <div class="col-md-6">
            <select id="pa_papel" class="form-control" v-model="papel" data-show_option_none="yes" @change="Change()">
                <option value="" disabled>Seleccione</option>
                <option v-for="papel in arrayPapel" :key="papel.papel" :value="papel.papel" v-text="papel.papel"></option>
                <option value="Otros" >Otros</option>
            </select>
            <div v-if="papel === 'Otros'" class="row Otros">
                <input class="form-control" type="text" v-model="otropapel" @change="ChangeInput()"/>
            </div>
        </div>
    </div>
</template>

<script>

import EventBus from "@/EventBus";

export default {
    name: 'PapelesLista',

    props: {
        ruta: String,
        titulo: String,
        inic: String
	},
    data(){
        return {
            papel: '',
            otropapel: '',
            arrayPapel: []
        }
    },

    methods: {

        Change(){
            console.log('Change');
            this.$emit('papel', this.papel);
        },
        ChangeInput(){
            console.log('ChangeInput');
            this.$emit('papel', this.otropapel);
            //this.Insert();
        },
        getPapel(){
            let me = this;

            axios.get('/papeles')
            .then(function (response) {
                // handle success
                console.log(response);
                me.arrayPapel= response.data;
            })
            .catch(function (error) {
                // handle error
                console.log(error.response);
            });
        },
        InsertPapel(value){

            let me = this;
            console.log('InsertPapel:' + value);

            if (me.arrayPapel.indexOf(value) === -1){

                axios.post(me.ruta + '/papeles/store', {
                    'papel': value
                })
                .then(function (response) {
                    // handle success
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            }
        },


    },
    created(){
        console.log(' Crear papeles');
        this.getPapel();
        this.papel = this.inic;
    }
}
</script>

<style scoped>
    .Otros {
        padding-top: 1rem;
    }
    .separar{
        margin-left: 1rem;
        margin-right: 1rem;
    }
</style>

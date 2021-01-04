<template>
 <div>
    <component v-bind:is="componentFile"
                     :ruta="ruta"
                     :modo="modo" :datos="datos" :idgrupo="idgrupo"
                      @respuesta="Respuesta"></component>


    <hr>
    <div class="form-group row col-md-12">

        <div class="col-md-9 form-group row" >
            <label class="col-md-2 col-form-label" for="file-multiple-input">Imágenes: </label>

            <div class="col-md-4">
                <input type="file" v-on:change="onImageChange" multiple  >
            </div>
        </div>

        <div class="row col-md-12">
            <div class="card" style="width: 8rem;" v-for="(item) in arrayImagenes" :key="item.name">
                <figure>
                    <img :src="item.base" :alt="item.name" class="card-img-top" height="80" width="80">
                    <figcaption v-text="item.name"> </figcaption>
                </figure>
            </div>
        </div>

        <div class="row col-md-10" v-show="arrayImagenesLoaded.length > 0">
            <div class="card" v-for="(item1, index) in arrayImagenesLoaded" :key="item1.name"   style="width: 6rem;">
                <figure @click="prepareToDelete(index, item1.id)">
                    <img v-bind:src="'data:image/jpeg;base64,'+ item1.data" :alt="item1.name" class="card-img-top" height="60" width="60">
                    <figcaption v-text="item1.name" style="font-size:8pt"> </figcaption>
                </figure>
            </div>
        </div>
    </div>

    <!-- Inicio del modal Confirmar -->
    <div class="modal fade" :class="{'mostrar' : showConfirm}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

        <div class="modal-dialog modal-danger" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <p>Estas seguro de eliminar la imagen?</p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="cancelDeleting()" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" @click="DeleteImagen()" class="btn btn-danger">Aceptar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Fin del modal Pagar -->
 </div>
</template>


<script>

import EventBus from "@/EventBus";

export default {
    name: 'DescriptionContent',
    props: {
        modo: Number,
		componentName: {
			type: String,
			required: true
        },
        ruta: String,
        datos: {type: Object, default: null},
        idgrupo: Number
	},
    computed: {
		componentFile() {
			return () => import(`./bundles/${this.componentName}.vue`);
		}
	},
    data () {
        return {
            tipotrabajo: null,
            arrayImagenes: [],
            arrayImagenesLoaded: [],
            deletingArray: [],
            showConfirm: 0

        }
    },
    methods: {
        onImageChange(e) {
            let files = e.target.files || e.dataTransfer.files;

            if (!files.length)
                return;

            for(var i = 0; i < 10; i++) {

                this.createImage(files[i]);
            }
        },
        createImage(file) {
            let reader = new FileReader();
            let me = this;
            reader.onload = (e) => {

                var imagenData = {name : file.name, base: e.target.result};
                me.arrayImagenes.push(imagenData);

            }
            if(file){
              reader.readAsDataURL(file);
            }
        },
        prepareToDelete(pos) {
            if (this.modo !== 3){
                console.log('Preparando');
                this.deletingArray = pos;
                this.showConfirm = 1;
            }
        },
        cancelDeleting() {
            this.showConfirm = 0;
        },
        DeleteImagen() {

            var id = this.arrayImagenesLoaded[this.deletingArray].id;

            this.arrayImagenesLoaded.splice(this.deletingArray,1);
            this.showConfirm = 0;

            let me = this;

            var url = '/presupuestos/imagen/drop/';
            if (me.modo == 3)
                url = '/trabajos/imagen/drop/';

            axios.put(me.ruta + url + id,{

                }).then(function (response) {
                    // handle success
                    console.log(response.data);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error.response);
                });

            this.deletingArray = null;
        },
        Respuesta(item){
            console.log('Respuesta de trabajo:' + item);

            let me = this;

            var url = '/presupuestos/imagen/store';
            var id = item;

            if (me.modo == 3){
                url = '/trabajos/imagen/store';
                id = item.id;
            }

            for( let i = 0; i < me.arrayImagenes.length; i++ ){

                axios.post(me.ruta + url,{
                    'id': id,
                    'imagen': me.arrayImagenes[i].base,
                }).then(function (response) {
                    // handle success
                    console.log(response.data);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error.response);
                });
            }

        },
        loadImagesSolicitud(){
             console.log('Load Imagen');
             let me = this;
             if ( me.datos !== null){

                axios.get(me.ruta + '/presupuestos/imagen/list?id=' + me.datos.id,{

                    }).then(function (response) {
                        // handle success
                        console.log(response);
                        me.arrayImagenesLoaded = response.data.imagenes;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error.response);
                    });
             }
        },
        loadImages(){
             console.log('Load Imagen');
             let me = this;
             if ( me.datos !== null){

                axios.get(me.ruta + '/trabajos/imagen/list?id=' + me.datos.id,{

                    }).then(function (response) {
                        // handle success
                        console.log(response);
                        me.arrayImagenesLoaded = response.data.imagenes;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error.response);
                    });
             }
        },

    },
    created: function() {
        //console.log('Content:' + this.datos.id);
        if (this.modo == 3){
            this.loadImages();
        }
        else
            this.loadImagesSolicitud();

    }
}
</script>



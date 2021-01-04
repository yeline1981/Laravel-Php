<template>
<div>
    <div class="card" v-show="modal">

        <div class="card-header">
            <h4 class="modal-title">Actualizar datos del cliente: {{ nombre }} </h4>
        </div>
        <div class="card-body">


            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="email">Email</label>
                <div class="col-md-9">
                <input class="form-control" v-model="email" type="email" >

                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="telefono">Teléfono</label>
                <div class="col-md-5">
                <input class="form-control" v-model="telefono" type="tel" >

                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="direccion">Dirección</label>
                <div class="col-md-9">
                <input class="form-control" v-model="direccion" type="text" >

                </div>
            </div>


            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="comentario">Comentario</label>
                <div class="col-md-9">
                    <textarea class="form-control" v-model="comentario" rows="1" ></textarea>
                </div>
            </div>


        </div>
        <div class="card-footer">
            <div class="float-right">
                <button type="button" class="btn btn-secondary" @click="salir(2)">Cerrar</button>
                <button type="button" class="btn btn-primary" @click="actualizarCliente()">Guardar</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->

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

import Notifications from "@/components/Layouts/Notifications";
import Base from "@/components/Layouts/Base";
import EventBus from "@/EventBus.js";

    export default {
      name: 'ModificarCliente',
      extends: Base,
      props : ['ruta'] ,
      data(){
        return {
            id: '',
            nombre : '',
            direccion: '',
            email: '',
            telefono: '',
            comentario: '',

            modal : 0,

            tituloModal : '',
            showConfirm : 0,
            ver:0
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
      methods: {

            actualizarCliente(){
                if (this.validarCliente()){
                    this.showAlert(2);
                    return;
                }

                let me = this;

                axios.post(me.ruta + '/clientes/actualizar',{
                    'id': this.id,
                    'nombre': this.nombre,
                    'direccion': this.direccion,
                    'email': this.email,
                    'telefono': this.telefono,
                    'comentario' : this.comentario


                }).then(function (response) {
                    console.log(response);

                    if (response.status == 200) {
                         me.salir(0, '');
                    }
                    else
                        me.salir(1, '');

                }).catch(function (error) {
                    console.log(error.response);
                });
            },
            salir(result, msg){
                this.modal = 0;
                this.id= '';
                this.nombre = '';
                this.direccion= '';
                this.email= '';
                this.telefono= '';
                this.comentario= '';

                this.tituloModal = '';

                this.showConfirm = 0;
                this.ver=0;

                EventBus.$emit('ModificarCliente', {'id' :result, 'msg': msg});
            },
            validarCliente(){
                var ret = 0;

                this.errorMostrarMsj =[];

                if (!this.telefono) this.errorMostrarMsj.push("El teléfono del cliente no puede estar vacío.");

                if (this.errorMostrarMsj.length) ret = 1;

                return ret;
            },

      },
      created: function() {

        EventBus.$on('VerClientes', (data=[]) => {

                this.modal = 1;
                this.id = data.id;
                this.nombre = data.nombre;
                this.email = data.email;
                this.direccion = data.direccion;
                this.telefono = data.telefono;

                this.comentario = data.comentario;

                this.ver = 1;

        });

      },
      mounted: function() {
        console.log('Montando el Modificar');
      }


    }
</script>

<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: fixed !important;
        background-color: #3c29297a !important;
    }



</style>

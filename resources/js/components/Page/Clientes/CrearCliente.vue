<template>
    <main class="main">

        <notification-component :errorMsj="errorMostrarMsj"
                                :texto="textonotificar"
                                :shownotif="shownotif"
                                :ruta="ruta">
        </notification-component>


        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                     Nuevo Cliente</div>
                  <div class="card-body">
                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">


                      <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="nombre">Nombre y Apellidos *</label>
                        <div class="col-md-9">
                          <input class="form-control" type="text" v-model="nombre" placeholder="">
                        </div>
                      </div>

                      <div class="form-group row">
                         <label class="col-md-3 col-form-label">Tipo de Cliente</label>
                            <div class="col-md-9 col-form-label">
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" id="inline-radio1" type="radio" value=0 v-model.number="iempresa">
                                    <label class="form-check-label" for="inline-radio1">Común</label>
                                </div>
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" id="inline-radio2" type="radio" value=1 v-model.number="iempresa">
                                    <label class="form-check-label" for="inline-radio2">Empresa</label>
                                </div>
                            </div>
                      </div>


                      <div class="form-group row" v-if="iempresa===0">
                        <label class="col-md-3 col-form-label" for="ident">CI*</label>
                        <div class="col-md-3">
                          <input class="form-control" type="text" v-model="ident" placeholder="" maxlength="8">
                        </div>
                      </div>

                      <div class="form-group row" v-else>
                        <label class="col-md-3 col-form-label" for="ident">RUT*</label>
                        <div class="col-md-3">
                          <input class="form-control" type="text" v-model="ident" placeholder="" maxlength="12">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="direccion">Dirección </label>
                        <div class="col-md-9">
                          <input class="form-control" type="text" v-model="direccion" placeholder="">

                        </div>
                      </div>

<!--
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label" >Ciudad *</label>
                        <div class="col-md-6">
                          <select class="form-control" v-model="ciudad">
                              <option value="0" disabled>Seleccione</option>
                              <option v-for="ciudad in arrayCiudad" :key="ciudad.id" :value="ciudad.id" v-text="ciudad.ciudad"></option>
                          </select>
                        </div>
                      </div>
-->
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="email">Email</label>
                        <div class="col-md-9">
                          <input class="form-control" type="email" v-model="email" placeholder="">

                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="telefono">Teléfono *</label>
                        <div class="col-md-3">
                          <input class="form-control" type="text" v-model="telefono" placeholder="" maxlength="50">

                        </div>
                      </div>


                    </form>

                  </div>
                  <div class="card-footer">
                    <div class="float-right">
                    <button class="btn btn-sm btn-danger" @click="Cancelar()" type="reset">
                      <i class="fa fa-ban"></i> Cancelar</button>
                    <button class="btn btn-sm btn-primary" @click="insertarCliente()" type="button">
                      <i class="fa fa-dot-circle-o"></i> Crear</button>
                    </div>
                  </div>
                </div>

              </div>

            </div>
            <!-- /.row-->
          </div>
        </div>
        <!-- fluid-->
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
            ident: '',
            nombre: '',
            direccion: '',
            email:'',
            telefono:'',
            iempresa: 0,
        }
      },
      methods: {
            insertarCliente() {

                    if (this.validarCliente()){
                        console.log('Dio error');
                        me.showAlert(2);
                        return;
                    }

                    let me = this;

                    axios.post(me.ruta +  '/clientes/registrar',{
                    'ident': this.ident,
                    'nombre': this.nombre,
                    'direccion': this.direccion,
                    'email':this.email,
                    'telefono':this.telefono
                    })
                    .then(function (response) {
                    // handle success
                        console.log(response);
                        me.ident = '';
                        me.nombre ='';
                        me.direccion = '';
                        me.email = '';
                        me.telefono ='';

                        me.textonotificar = 'Cliente creado satisfactoriamente';
                        me.showAlert(1);

                    })
                    .catch(function (error) {
                    // handle error
                        console.log(error.response);

                        if (error.response.data.cliente == -2){
                            me.errorMostrarMsj.push('Cédula/Rut de cliente ya existe');
                        }
                        me.errorMostrarMsj.push(error.response.data.message);

                        me.showAlert(2);

                        });
                },
            validate_isRUT()
            {
                if (this.ident.length != 12){
                    this.errorMostrarMsj.push('Rut errónea');
                    return false;
                }
                if (!/^([0-9])*$/.test(this.ident)){
                    this.errorMostrarMsj.push('Rut errónea');
                        return false;
                }
                var dc = this.ident.substr(11, 1);
                var rut = this.ident.substr(0, 11);
                var total = 0;
                var factor = 2;

                for (var i = 10; i >= 0; i--) {
                    total += (factor * rut.substr(i, 1));
                    factor = (factor == 9)?2:++factor;
                }

                var dv = 11 - (total % 11);

                if (dv == 11){
                    dv = 0;
                }else if(dv == 10){
                    dv = 1;
                }
                if(dv == dc){
                    return true;
                }
                this.errorMostrarMsj.push('Rut errónea');
                return false;
            },
            validate_isCI(){
                var a = 0; var i = 0;

                var ci = this.ident;

                if(ci.length <= 7){
                    for(var i = ci.length; i < 8; i++){
                        ci = '0' + ci;
                    }
                }

                console.log('CI:' + ci);

                for(var i = 0; i < 7; i++){
                    a += (parseInt("2987634"[i]) * parseInt(ci[i])) % 10;
                }

                var vret = true;

                console.log('a:' + a + '/ ' + ci[7]);

                if(a%10 === 0 ){
                    if (parseInt(ci[7]) !== 0){
                        vret = false;
                        this.errorMostrarMsj.push('Cédula errónea');
                    }
                }
                else
                {
                    if (parseInt(ci[7]) !== (10 - a % 10)){
                        vret = false;
                        this.errorMostrarMsj.push('Cédula errónea');
                    }
                }

                return vret;
            },
            validarCliente(){
                    var ret = 0;
                    this.notificar = 0;
                    this.shownotif = 0;
                    this.textonotificar = '';
                    this.errorMostrarMsj =[];

                    var identif = true;

                    if (this.iempresa == 0)
                        identif = this.validate_isCI();
                    else
                        identif = this.validate_isRUT();

                    if (identif == false)
                        ret = 1;

                    if (!this.nombre) this.errorMostrarMsj.push("El nombre del cliente no puede estar vacío.");

                    if (!this.ident) this.errorMostrarMsj.push("El número de cédula/rut del cliente no puede estar vacío.");

                // if (this.ident.length > 8) this.errorMostrarMsj.push("El número de cédula del cliente no puede tener más de 8 dígitos.");

                    if (!this.telefono) this.errorMostrarMsj.push("El número de teléfono del cliente no puede estar vacío.");

                    if (this.errorMostrarMsj.length) ret = 1;

                    return ret;
            },
            Cancelar(){
              this.ident = '';
              this.nombre ='';
              this.direccion = '';
              this.email = '';
              this.telefono ='';

              window.location.href = this.ruta + '/main';
            },

      },
        mounted() {
            console.log('Component CrearCliente mounted.');

        }
    }
</script>



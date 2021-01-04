<template>

    <div class="card" >
        <fieldset :disabled="disabled">
            <div class="card-body" >

                <div v-if="Crear==0" class="row">

                    <div class="form-group row col-md-9">
                            <label class="col-md-3 col-form-label" for="">Cliente: </label>
                            <div class="col-md-6">
                                <input class="form-control" type="text" v-model="identVerificar" placeholder="">
                            </div>
                    </div>

                    <div class="text-right" v-if="disabled==false">
                        <button class="btn btn-sm btn-info" type="button" @click="ExistCliente()">
                                    Confirmar<i class="icons "></i> </button>
                    </div>
                    &nbsp;  &nbsp;  &nbsp;   &nbsp;
                    <div class="text-right" v-show="NoExist">
                        <button class="btn btn-sm btn-success" type="button" @click="AbrirNuevo()">
                                    <i class="icons"></i> Crear </button>
                    </div>
                </div>

                <div class="col text-center" v-show="NoExist" style="color: blue">
                    Cliente no encontrado, verifique el número o especifique para crearlo.
                </div>

                <div class="col-md-12" v-show="Crear">

                    <h4>Datos Nuevo Cliente </h4>
                    <br>
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

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="email">Email</label>
                        <div class="col-md-9">
                        <input class="form-control" type="email" v-model="email" placeholder="">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="telefono">Teléfono *</label>
                        <div class="col-md-3">
                        <input class="form-control" type="text" v-model="telefono" placeholder="">

                        </div>
                    </div>

                    <div class="col text-center" v-show="IfError" style="color: red">
                        <div v-for="error in errorMostrarMsjAviso" :key="error" v-text="error" >

                        </div>
                    </div>

                    <div class="text-right" v-show="agregar">
                        <button class="btn btn-sm btn-success" type="button" @click="AgregarCliente()">
                                Agregar<i class="icon-arrow-right-circle icons "></i> </button>
                    </div>
                </div>

            </div>
        </fieldset>
    </div>

</template>


<script>
import EventBus from "@/EventBus";
import vSelect from 'vue-select';

export default {
    name: 'ContactosAviso',
    props : { ruta:String } ,
    components: {
        vSelect
    },
    data () {
        return {
            identVerificar: null,
            ident: '',
            nombre: '',
            direccion: '',
            email:'',
            telefono:'',
            errorMostrarMsjAviso : [],
            iempresa: 0,
            ver:0,

            id: '',
            Normal : 1,
            isActive: 1,
            NoExist: 0,
            IfError: 0,
            Crear: 0,
            arrayCliente: [],
            idcliente: null,
            disabled: false,
            agregar: 1
        }
    },
    methods: {

            validarCliente(){

                    var ret = 0;
                    this.errorMostrarMsjAviso =[];

                    var identif = true;

                        if (this.iempresa == 0)
                            identif = this.validate_isCI();
                        else
                            identif = this.validate_isRUT();

                        if (identif == false)
                            ret = 1;

                    if (!this.ident) this.errorMostrarMsjAviso.push("El identificador del cliente no puede estar vacío.");
                    if (!this.telefono) this.errorMostrarMsjAviso.push("El número de teléfono no puede ser vacío.");

                    if (this.errorMostrarMsjAviso.length) ret = 1;

                    return ret;
            },
            AbrirNuevo(){
                this.Crear = 1;
                this.NoExist = 0;
                this.ident = this.identVerificar;
            },
            AgregarCliente() {
                    if (this.validarCliente()){
                        console.log('Dio error');
                        //this.$emit('Error', this.errorMostrarMsjAviso) ;
                        this.IfError = 1;
                        return;
                    }

                    let me = this;
                    var ident = this.ident;
                    me.IfError = 0;

                    axios.post(me.ruta +  '/clientes/registrar',{
                    'ident': ident,
                    'nombre': this.nombre,
                    'direccion': this.direccion,
                    'email':this.email,
                    'telefono':this.telefono

                    })
                    .then(function (response) {
                        // handle success
                        console.log(response);
                        //var respuesta = response.data;
                        me.disabled = true;
                        me.agregar = 0;
                        me.$emit('cliente', me.ident );

                    })
                    .catch(function (error) {
                    // handle error
                        console.log(error.response);
                        me.errorMostrarMsjAviso = [];
                        if (error.response.data.cliente == -2){
                            me.errorMostrarMsjAviso.push('Identificador de Cédula/RUT ya existe.')
                        }
                        me.IfError = 1;
                    });
            },
            validate_isRUT()
            {
                if (this.ident.length != 12){
                    this.errorMostrarMsjAviso.push('Rut errónea');
                    return false;
                }
                if (!/^([0-9])*$/.test(this.ident)){
                    this.errorMostrarMsjAviso.push('Rut errónea');
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
                this.errorMostrarMsjAviso.push('Rut errónea');
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
                        this.errorMostrarMsjAviso.push('Cédula errónea');
                    }
                }
                else
                {
                    if (parseInt(ci[7]) !== (10 - a % 10)){
                        vret = false;
                        this.errorMostrarMsjAviso.push('Cédula errónea');
                    }
                }

                return vret;
            },
            ExistCliente(){
              let me = this;

              var url= me.ruta + '/clientes/exist?id=' + this.identVerificar ;

              axios.get(url)
                .then(function (response) {
                    // handle success
                    console.log(response);
                    //me.NoExist = 0;
                    me.disabled = true;
                    me.$emit('cliente', me.identVerificar );

                })
                .catch(function (error) {
                // handle error
                    console.log(error.response);
                    me.NoExist = 1;
                });
          }

    },
    created: function() {
        EventBus.$on('Asociar', (item) => {
                this.identVerificar='';
        });

    }
}
</script>



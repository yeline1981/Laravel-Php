<template>

    <div class="card-footer">

        <div class="float-right">

            <button class="btn btn-sm btn-danger" @click="Action(3)" type="reset" v-if="modo===0">
                <i class="fa fa-ban"></i> Cancelar</button>

            <button class="btn btn-sm btn-secondary" @click="Action(5)" type="button" v-if="modo!==0">
                <i class="fas fa-sign-out-alt"></i> Salir</button>

            <button class="btn btn-sm btn-primary" @click="Action(1)" type="button" v-if="modo===0">
                <i class="fa fa-dot-circle-o"></i> Crear</button>

            <button class="btn btn-sm btn-primary" @click="Action(2)" type="button" v-if="modo===2">
                <i class="fa fa-dot-circle-o"></i> Actualizar</button>

            <button class="btn btn-sm btn-primary" @click="Action(7)" type="button" v-if="modo===3 && estado <= 3 && (role=='Administrador' || role=='Vendedor')">
                <i class="fa fa-dot-circle-o"></i> Modificar</button>

            <button class="btn btn-sm btn-success" @click="Confirmar()" type="button" v-if="modo===3 && estado==3">
                <i class="fa fa-check-circle"></i> Hecho</button>

            <button class="btn btn-sm btn-success" @click="Mostrar()" type="button" v-if="modo===3 && estado==1">
                <i class="fas fa-user-check"></i>Mostrar</button>

        </div>

        <!-- Inicio del modal Terminar -->
        <div class="modal fade" :class="{'mostrar' : modal1}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

            <div class="modal-dialog modal-info" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirmación</h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <p>Estas seguro que terminó el trabajo?</p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" @click="Action(4)" class="btn btn-success">Aceptar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Fin del modal Terminar -->

        <!-- Inicio del modal Mostrar -->
        <div class="modal fade" :class="{'mostrar' : modal2}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">

            <div class="modal-dialog modal-info" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirmación</h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <p>Estas seguro de mostrar el trabajo?</p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" @click="Action(6)" class="btn btn-info">Aceptar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Fin del modal Mostrar -->
    </div>

</template>

<script>

export default {
    name: 'DescriptionFooter',
    props: {
        modo: Number,
        estado: Number,
	},
    computed: {

	},
    data () {
        return {
            modal1: 0,
            modal2: 0,
            role: ''
        }
    },
    methods: {
        Action(value){
             this.$emit('action', value );
        },
        Confirmar(){
            this.modal1 = 1;
        },
        Mostrar(){
            this.modal2 = 1;
        },
        cerrarModal(){
            this.modal1 =0;
            this.modal2 =0;
        },
        getPriv(){
            let me = this;

            console.log('llamando privilegio');

            axios.get(me.$parent.ruta + '/usuarios/role')
            .then(function (response) {
                console.log(response);
                me.role = response.data.role;

            }).catch(function (error) {
                console.log('Error privileg: ' + error.response);
            });
        },

    },
    mounted: function() {
        console.log('Montando footer');
        this.getPriv();
    }
}
</script>



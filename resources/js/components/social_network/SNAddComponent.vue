<template>
    <div class="container">
        <div style="text-align: right">
            <router-link class="btn btn-success" to="/social-network"><i class="fa fa-arrow-left"></i> Regresar</router-link>
        </div>
        <br>

        <div class="form-group">
            <label>URL</label>
            <input type="url" v-model="url" name="url" v-validate="'required'" class="form-control" placeholder="Url">
        </div>

        <div class="form-group">
            <label for="sel1">Seleccione:</label>
            <select class="form-control" id="sel1" v-model="tipo">
                <option>Twitter</option>
                <option>Facebook</option>
                <option>Instagram</option>
                <option>Google+</option>
                <option>Linkedin</option>
            </select>
        </div>


        <ul style="color: red">
            <li v-for="error in errors.all()">{{ error }}</li>
        </ul>

        <div class="form-group">
            <button v-if="!modeEdit" type="button" class="btn btn-primary" @click="submit"><i class="fa fa-plus"></i> Adicionar</button>
            <button v-else type="button" class="btn btn-primary" @click="submit"><i class="fa fa-save"></i> Actualizar</button>

        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                id: '',
                url: 'http://',
                tipo: '',
                modeEdit: false
            }
        },
        methods: {
            submit(){
                if(!this.modeEdit && this.errors.any() === false){
                    axios.post('/sn',{
                        tipo: this.tipo,
                        url: this.url,
                    }).then(response => {
                        if(response.status == 200){
                            this.$swal.fire('Red Social registrada correctamente');
                            this.$router.push('list');
                        }else{
                            this.$swal.fire({
                                type: 'error',
                                title: 'Error',
                                text: 'No se pudo registrar la red social.',
                            });
                        }
                    });
                }else if(this.modeEdit && this.errors.any() === false){
                    axios.put('/sn/'+this.id,{
                        tipo: this.tipo,
                        url: this.url,
                    }).then(response => {
                        if(response.status == 200){
                            this.$swal.fire('Red social editada correctamente');
                            this.$router.push('list');
                        }else{
                            this.$swal.fire({
                                type: 'error',
                                title: 'Error',
                                text: 'No se pudo editar la red social.',
                            });
                        }
                    });
                }else{
                    this.$swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'Debe rellenar los campos.',
                    });
                }


            },

            edit(){
                axios.get('sn/'+id)
                    .then(response => {
                        this.$emit('setSN',response);
                    });
            },
        },
        mounted() {
            if(this.$route.params.id !== undefined){
                this.id = this.$route.params.id;
                this.modeEdit = true;

                axios.get('/sn/'+this.id)
                    .then(response => {
                        this.url = response.data.url;
                        this.tipo = response.data.tipo;
                    });
            }
        }
    }
</script>


<style>
    .cursor-over
    {
        cursor: pointer;
    }

    .close{
        float:right;
        cursor: pointer;
        font-weight: bold;
    }
</style>

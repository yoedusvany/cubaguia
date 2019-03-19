<template>
    <div class="container">
        <div style="text-align: right">
            <router-link class="btn btn-success" to="/servicios"><i class="fa fa-arrow-left"></i> Regresar</router-link>
        </div>
        <br>

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" v-model="nombre" name="nombre" v-validate="'required'" class="form-control" placeholder="Nombre del servicio">
        </div>

        <div class="form-group">
            <label for="descTexArea">Descripci&oacute;n</label>
            <textarea v-model="desc" v-validate="'required'" name="desc" class="form-control" id="descTexArea" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="descTexArea1">Descripci&oacute;n - Ingles</label>
            <textarea v-model="desc_en" v-validate="'required'" name="desc_en" class="form-control" id="descTexArea1" rows="3"></textarea>
        </div>



        <div class="row">
            <div class="col-md-6 col-lg-6 form-group">
                <label for="exampleFormControlFile1">Icono</label>
                <input type="file" name="image" v-on:change="onImageChange" class="form-control-file" id="exampleFormControlFile1">
            </div>
            <div class="col-md-6 col-lg-6" v-if="icon">
                <img :src="icon" class="img-responsive" height="100" width="100">
            </div>
        </div>


        <ul style="color: red">
            <li v-for="error in errors.all()">{{ error }}</li>
        </ul>

        <div class="form-group">
            <button type="button" class="btn btn-primary" @click="uploadImage">
                <span v-if="!modeEdit">
                    <i class="fa fa-plus"></i> Adicionar
                </span>
                <span v-if="modeEdit">
                    <i class="fa fa-save"></i> Actualizar
                </span>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                id: '',
                image: '',
                icon: '',
                nombre: '',
                desc : '',
                desc_en : '',
                modeEdit: false
            }
        },
        methods: {
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;

                for(let i=0; i<files.length; i++){
                    this.createImage(files[i]);
                }
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    let obj = {
                        nombre: e.target.result
                    };
                    vm.image = obj.nombre;
                };
                reader.readAsDataURL(file);
            },
            uploadImage(){
                if(!this.modeEdit && this.errors.any() === false){
                    axios.post('/api/servicios',{
                        image: this.image,
                        nombre: this.nombre,
                        desc: this.desc,
                        desc_en: this.desc_en
                    }).then(response => {
                        if(response.status == 200){
                            this.$swal.fire('Servicio registrado correctamente');
                            this.$router.push('list');
                        }else{
                            this.$swal.fire({
                                type: 'error',
                                title: 'Error',
                                text: 'No se pudo registrar el servicio.',
                            });
                        }
                    });
                }else if(this.modeEdit && this.errors.any() === false){
                    axios.put('/api/servicios/'+this.id,{
                        image: this.image,
                        nombre: this.nombre,
                        desc: this.desc,
                        desc_en: this.desc_en
                    }).then(response => {
                        if(response.status == 200){
                            this.$swal.fire('Servicio editado correctamente');
                            this.$router.push('/servicios');
                        }else{
                            this.$swal.fire({
                                type: 'error',
                                title: 'Error',
                                text: 'No se pudo editar el servicio.',
                            });
                        }
                    });
                }else{
                    this.$swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'Debe rellenar los campos nombre y descripción.',
                    });
                }


            },
        },
        mounted() {
            if(this.$route.params.id !== undefined){
                this.id = this.$route.params.id;
                this.modeEdit = true;

                axios.get('/api/servicios/'+this.id)
                    .then(response => {
                        this.nombre = response.data.name;
                        this.desc = response.data.desc;
                        this.desc_en = response.data.desc_en;
                        this.icon = response.data.icon;
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

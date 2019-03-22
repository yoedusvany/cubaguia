<template>
    <div class="container">
        <div style="text-align: right">
            <router-link class="btn btn-success" to="/slider"><i class="fa fa-arrow-left"></i> Regresar</router-link>
        </div>
        <br>

        <div class="form-group">
            <label>Titulo</label>
            <input type="text" v-model="title" name="title" v-validate="'required'" class="form-control" placeholder="Titulo">
        </div>

        <div class="form-group">
            <label>Titulo Ingles</label>
            <input type="text" v-model="title_en" name="title_en" v-validate="'required'" class="form-control" placeholder="Titulo Ingles">
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
                <label for="exampleFormControlFile1">Imagen</label>
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
                title: '',
                title_en: '',
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
                    axios.post('/slider-manager',{
                        image: this.image,
                        title: this.title,
                        title_en: this.title_en,
                        desc: this.desc,
                        desc_en: this.desc_en
                    }).then(response => {
                        if(response.status == 200){
                            this.$swal.fire('Slider registrado correctamente');
                            this.$router.push('list');
                        }else{
                            this.$swal.fire({
                                type: 'error',
                                title: 'Error',
                                text: 'No se pudo registrar el slider.',
                            });
                        }
                    });
                }else if(this.modeEdit && this.errors.any() === false){
                    axios.put('/slider-manager/'+this.id,{
                        image: this.image,
                        title: this.title,
                        title_en: this.title_en,
                        desc: this.desc,
                        desc_en: this.desc_en
                    }).then(response => {
                        if(response.status == 200){
                            this.$swal.fire('Slider editado correctamente');
                            this.$router.push('/slider');
                        }else{
                            this.$swal.fire({
                                type: 'error',
                                title: 'Error',
                                text: 'No se pudo editar el slider.',
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
        },
        mounted() {
            if(this.$route.params.id !== undefined){
                this.id = this.$route.params.id;
                this.modeEdit = true;

                axios.get('/slider-manager/'+this.id)
                    .then(response => {
                        this.title = response.data.title;
                        this.title_en = response.data.title_en;
                        this.desc = response.data.desc;
                        this.desc_en = response.data.desc_en;
                        this.icon = response.data.image;
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

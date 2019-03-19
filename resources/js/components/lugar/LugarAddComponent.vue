<template>
    <div class="container">
        <div style="text-align: right">
            <router-link class="btn btn-success" to="/lugar"><i class="fa fa-arrow-left"></i> Regresar</router-link>
        </div>
        <br>

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" v-model="nombre" name="nombre" v-validate="'required'" class="form-control" placeholder="Nombre del lugar">
        </div>

        <div class="form-group">
            <label for="descTexArea">Descripci&oacute;n</label>
            <textarea v-model="desc" v-validate="'required'" name="desc" class="form-control" id="descTexArea" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="descTexArea1">Descripci&oacute;n Ingles</label>
            <textarea v-model="desc_en" v-validate="'required'" name="desc_en" class="form-control" id="descTexArea1" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="exampleFormControlFile1">Subir im&aacute;genes</label>
            <input type="file" v-on:change="onImageChange" class="form-control-file" id="exampleFormControlFile1" multiple>
        </div>


        <ul style="color: red">
            <li v-for="error in errors.all()">{{ error }}</li>
        </ul>

        <div class="form-group">
            <button v-if="!modeEdit" type="button" class="btn btn-primary" @click="uploadImage"><i class="fa fa-plus"></i> Adicionar</button>
            <button v-else type="button" class="btn btn-primary" @click="uploadImage"><i class="fa fa-save"></i> Actualizar</button>

        </div>

        <div class="row">
            <div class="col-md-4 cursor-over" v-if="image" v-for="item in image">
                <span v-if="modeEdit" class="close" @click="deleteImage(item.id)">X</span>
                <img :src="item.nombre" class="img-responsive" height="200" width="300">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                id: '',
                image: [],
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
                    vm.image.push(obj);
                };
                reader.readAsDataURL(file);
            },
            uploadImage(){
                if(!this.modeEdit && this.errors.any() === false){
                    axios.post('/lugar',{
                        image: this.image,
                        nombre: this.nombre,
                        desc: this.desc,
                        desc_en: this.desc_en
                    }).then(response => {
                        if(response.status == 200){
                            this.$swal.fire('Lugar registrado correctamente');
                            this.$router.push('list');
                        }else{
                            this.$swal.fire({
                                type: 'error',
                                title: 'Error',
                                text: 'No se pudo registrar el lugar.',
                            });
                        }
                    });
                }else if(this.modeEdit && this.errors.any() === false){
                    axios.put('/lugar/'+this.id,{
                        image: this.image,
                        nombre: this.nombre,
                        desc: this.desc,
                        desc_en: this.desc_en
                    }).then(response => {
                        if(response.status == 200){
                            this.$swal.fire('Lugar editado correctamente');
                            this.$router.push('/lugar');
                        }else{
                            this.$swal.fire({
                                type: 'error',
                                title: 'Error',
                                text: 'No se pudo editar el lugar.',
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

            edit(){
                axios.get('lugar/'+id)
                    .then(response => {
                        this.$emit('setLugar',response);
                    });
            },

            deleteImage(id){
                if(this.modeEdit){
                    this.$swal.fire({
                        title: 'Está seguro?',
                        text: "Realmente desea eliminar la imagen",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Borrar'
                    }).then((result) => {
                        if (result.value) {
                            axios.delete('/image-delete/'+id)
                                .then(response => {
                                    this.$swal.fire('Imagen eliminada correctamente');

                                    var index = this.image.findIndex(x => x.id === id);
                                    if (index > -1) {
                                        this.image.splice(index, 1);
                                    }
                                })
                                .catch(error => {
                                    this.$swal.fire({
                                        type: 'error',
                                        title: 'Error',
                                        text: 'Ocurrio un error!',
                                    });
                                });
                        }
                    })
                }
            }
        },
        mounted() {
            if(this.$route.params.id !== undefined){
                this.id = this.$route.params.id;
                this.modeEdit = true;

                axios.get('/lugar/'+this.id)
                    .then(response => {
                        this.nombre = response.data.nombre;
                        this.desc = response.data.desc;
                        this.desc_en = response.data.desc_en;

                        for(let i = 0; i<response.data.images.length; i++){
                            this.image.push(response.data.images[i]);
                        }
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

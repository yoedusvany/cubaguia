<template>
    <div class="container">
        <div style="text-align: right">
            <router-link class="btn btn-success" to="/excursion"><i class="fa fa-arrow-left"></i> Regresar
            </router-link>
        </div>
        <br>

        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Nombre:</label>
                    <input class="form-control" type="text" placeholder="Nombre de la Excursion" v-model="nombre">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Precio:</label>
                    <vue-numeric class="form-control" currency="$" separator="," v-model="precio"></vue-numeric>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label>Descripci&oacute;n:</label>
                    <textarea class="form-control" placeholder="Descripcion de la excursion" rows="3" v-model="desc"></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label>Descripci&oacute;n: Ingles</label>
                    <textarea class="form-control" placeholder="Descripcion de la excursion" rows="3" v-model="desc_en"></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="exampleFormControlFile1">Subir imagen de portada</label>
                    <input type="file" v-on:change="onImageChange" class="form-control-file" id="exampleFormControlFile1">
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <span v-if="image">Imagen principal</span>
                    <img :src="image" class="img-responsive" height="100" width="100">
                </div>
            </div>
        </div>

        <div class="row">
            <lugar-select
                class="col-lg-4 col-sm-12 col-md-4 cursor-over"
                v-for="item in listLugares"
                @selectLugar="selectLugar"
                v-bind:key="item.id"
                :id="item.id"
                :nombre="item.nombre"
                :desc="item.desc"
                :img="item.imagen"
                :selected="preSelected(item.id)"
            >
            </lugar-select>
        </div>

        <br>

        <div class="row">
            <div class="form-group">
                <button v-if="!modeEdit" type="button" class="btn btn-primary" @click="uploadImage"><i class="fa fa-plus"></i> Adicionar</button>
                <button v-else type="button" class="btn btn-primary" @click="uploadImage"><i class="fa fa-save"></i> Actualizar</button>
            </div>
        </div>

    </div>
</template>

<script>

    import SelectLugares from './SelectLugaresComponent.vue';

    export default {
        components:{
            'lugar-select': SelectLugares
        },

        data: () => ({
            nombre: '',
            precio: '',
            desc: '',
            desc_en: '',
            image:'',
            listLugares:[],
            listLugaresSelected:[],
            id:'',
            modeEdit: false
        }),

        methods:{
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            uploadImage(){
                if(!this.modeEdit){
                    this.save();
                }else{
                    this.edit();
                }
            },

            getLugares: function () {
                fetch('/lugar-list')
                    .then(response => response.json())
                    .then(res => {
                        this.listLugares = res;
                    })
            },

            loadData(){
                axios.get('/excursion/'+this.id)
                    .then(response => {
                        this.nombre = response.data.nombre;
                        this.precio = response.data.precio;
                        this.desc = response.data.desc;
                        this.desc_en = response.data.desc_en;
                        this.image = response.data.img;

                        response.data.lugares.forEach(function(element){
                            this.listLugaresSelected.push(element.lugar_id);
                        },this)
                    });
            },

            preSelected(id){
                var index = this.listLugaresSelected.findIndex(x => x === id);
                return index > -1;
            },

            selectLugar: function(id){
                let index = this.listLugaresSelected.indexOf(id);

                if(index > -1){
                    this.listLugaresSelected.splice(index,1);
                }else{
                    this.listLugaresSelected.push(id);
                }
            },

            save(){
                axios.post('/excursion',{
                    nombre: this.nombre,
                    precio: this.precio,
                    desc: this.desc,
                    desc_en: this.desc_en,
                    image: this.image,
                    listaLugares: this.listLugaresSelected
                }).then(response => {
                    if(response.status == 200){
                        this.$swal.fire('Excursión registrada correctamente');
                        this.$router.push('/excursion');
                    }else{
                        this.$swal.fire({
                            type: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al intentar registrar la excursión.',
                        });
                    }
                });
            },




            edit(){
                axios.put('/excursion/'+this.id,{
                    nombre: this.nombre,
                    precio: this.precio,
                    desc: this.desc,
                    desc_en: this.desc_en,
                    image: this.image,
                    listaLugares: this.listLugaresSelected
                }).then(response => {
                    if(response.status == 200){
                        this.$swal.fire('Excursión registrada correctamente');
                        this.$router.push('/excursion');
                    }else{
                        this.$swal.fire({
                            type: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al intentar registrar la excursión.',
                        });
                    }
                });
            },
        },

        mounted() {
            this.getLugares();

            if(this.$route.params.id !== undefined){
                this.id = this.$route.params.id;
                this.modeEdit = true;

                this.loadData();
            }
        }
    }
</script>


<style>
    .cursor-over
    {
        cursor: pointer;
    }

</style>

<template>
    <div class="container">

        <div style="text-align: right">
            <router-link class="btn btn-primary" to="/slider/add"><i class="fa fa-plus"></i> Adicionar</router-link>
        </div>
        <br>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titulo</th>
                <th scope="col" width="15%">Titulo Ingles</th>
                <th scope="col" width="30%">Desc.</th>
                <th scope="col" width="30%">Desc. Ingles</th>
                <th scope="col">Imagen</th>
                <th scope="col" width="25%">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in listSliders">
                <th scope="row">{{ index+1 }}</th>
                <td>{{ item.title }}</td>
                <td>{{ item.title_en }}</td>
                <td>{{ item.desc }}</td>
                <td>{{ item.desc_en }}</td>
                <td><img :src="item.image" width="50px" height="50px"></td>
                <td>
                    <router-link class="btn btn-success" :to="{ name: 'sliderAdd', params: { id: item.id }}"><i class="fa fa-edit"></i> Editar</router-link>
                    <button type="button" class="btn btn-danger" v-on:click.prevent="removeSlider(item.id)"><i class="fa fa-remove"></i> Eliminar</button>
                </td>
            </tr>

            </tbody>
        </table>


    </div>
</template>

<script>
    export default {
        data:function(){
            return {
                listSliders : [],
                id : ''
            }
        },
        methods:{
            getSliders: function () {
                fetch('/slider-manager')
                    .then(response => response.json())
                    .then(res => {
                        this.listSliders = res;
                    })
            },

            setId: function(id){
                this.id = id;
            },

            removeSlider: function(id){
                this.id = id;

                this.$swal.fire({
                    title: 'Está seguro?',
                    text: "Se eliminará el slider seleccionado.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/slider-manager/'+id)
                            .then(response => {
                                this.$swal.fire('Slider eliminado correctamente.');
                                this.getServicios();
                            })
                            .catch(error => {
                                this.$swal.fire({
                                    type: 'error',
                                    title: 'Error',
                                    text: 'Ocurrió un error!.',
                                });
                            });
                    }
                })


            },
            editSlider: function(id){
                this.$router.push({ name: 'sliderAdd', params: { id: id }})
            },
        },
        mounted() {
            this.getSliders();
        }
    }
</script>

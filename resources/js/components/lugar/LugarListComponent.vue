<template>
    <div class="container">

        <div style="text-align: right">
            <router-link class="btn btn-primary" to="/lugar/add"><i class="fa fa-plus"></i> Adicionar</router-link>
        </div>
        <br>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col" width="40%">Desc.</th>
                <th scope="col" width="40%">Desc. Ingles</th>
                <th scope="col">Fecha</th>
                <th scope="col" width="20%">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in listLugares">
                <th scope="row">{{ index+1 }}</th>
                <td>{{ item.nombre }}</td>
                <td>{{ item.desc }}</td>
                <td>{{ item.desc_en }}</td>
                <td>{{ item.created_at }}</td>
                <td>
                    <router-link class="btn btn-success" :to="{ name: 'lugarAdd', params: { id: item.id }}"><i class="fa fa-edit"></i> Editar</router-link>
                    <button type="button" class="btn btn-danger" v-on:click.prevent="removeLugar(item.id)"><i class="fa fa-remove"></i> Eliminar</button>
                </td>
            </tr>

            </tbody>
        </table>


    </div>
</template>

<script>
    export default {
        name: 'lugar-list-component',
        data:function(){
            return {
                listLugares : [],
                id : ''
            }
        },
        methods:{
            getLugares: function () {
                fetch('/lugar-list')
                    .then(response => response.json())
                    .then(res => {
                        this.listLugares = res;
                    })
            },
            setId: function(id){
                this.id = id;
            },
            removeLugar: function(id){
                this.id = id;
                //let route = this.$route.path;
                //let rt = route.replace('/list','');

                this.$swal.fire({
                    title: 'Está seguro?',
                    text: "Se eliminará el lugar seleccionado.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/lugar/'+id)
                            .then(response => {
                                this.$swal.fire('Lugar eliminado correctamente.');
                                this.getLugares();
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
            editLugar: function(id){
                this.$router.push({ name: 'add', params: { id: id }})
            },
        },
        mounted() {
            this.getLugares();
        }
    }
</script>

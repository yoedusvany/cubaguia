<template>
    <div class="container">
        <div style="text-align: right">
            <router-link class="btn btn-primary" to="/excursion/add"><i class="fa fa-plus"></i> Adicionar</router-link>
        </div>
        <br>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col" width="40%">Desc.</th>
                <th scope="col">Precio</th>
                <th scope="col">Fecha</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in listExcursions">
                <th scope="row">{{ index+1 }}</th>
                <td>{{ item.nombre }}</td>
                <td>{{ item.desc }}</td>
                <td class="text-right">${{ item.precio }}</td>
                <td>{{ item.created_at }}</td>
                <td>
                    <button type="button" class="btn btn-success" v-on:click.prevent="editItem(item.id)"><i class="fa fa-edit"></i> Editar</button>
                    <button type="button" class="btn btn-danger" v-on:click.prevent="removeItem(item.id)"><i class="fa fa-remove"></i> Eliminar</button>
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
                listExcursions : [],
            }
        },
        methods:{
            getExcursions: function () {
                fetch('/excursion-list')
                    .then(response => response.json())
                    .then(res => {
                        this.listExcursions = res;
                    })
            },
            editItem: function(id){
                this.$router.push({ name: 'excursionAdd', params: { id: id }})
            },
            removeItem: function(id){
                this.$swal.fire({
                    title: 'Esta seguro?',
                    text: "Se eliminara la excursion seleccionada",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('excursion/'+id)
                            .then(response => {
                                this.$swal.fire('Excursion eliminada correctamente');
                                this.getExcursions();
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


            },
        },
        mounted() {
            this.getExcursions();
        }
    }
</script>

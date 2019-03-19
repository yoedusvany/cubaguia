<template>
    <div class="container">

        <div style="text-align: right">
            <router-link class="btn btn-primary" to="/servicios/add"><i class="fa fa-plus"></i> Adicionar</router-link>
        </div>
        <br>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col" width="50%">Desc.</th>
                <th scope="col" width="20%">Icono</th>
                <th scope="col" width="25%">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in listServicios">
                <th scope="row">{{ index+1 }}</th>
                <td>{{ item.name }}</td>
                <td>{{ item.desc }}</td>
                <td><img :src="item.icon" width="50px" height="50px"></td>
                <td>
                    <router-link class="btn btn-success" :to="{ name: 'servicioAdd', params: { id: item.id }}"><i class="fa fa-edit"></i> Editar</router-link>
                    <button type="button" class="btn btn-danger" v-on:click.prevent="removeServicio(item.id)"><i class="fa fa-remove"></i> Eliminar</button>
                </td>
            </tr>

            </tbody>
        </table>


    </div>
</template>

<script>
    export default {
        name: 'servicio-list-component',
        data:function(){
            return {
                listServicios : [],
                id : ''
            }
        },
        methods:{
            getServicios: function () {
                fetch('/api/servicios')
                    .then(response => response.json())
                    .then(res => {
                        this.listServicios = res;
                    })
            },

            setId: function(id){
                this.id = id;
            },

            removeServicio: function(id){
                this.id = id;

                this.$swal.fire({
                    title: 'Está seguro?',
                    text: "Se eliminará el servicio seleccionado.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/services/'+id)
                            .then(response => {
                                this.$swal.fire('Servicio eliminado correctamente.');
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
            editServicio: function(id){
                this.$router.push({ name: 'servicioAdd', params: { id: id }})
            },
        },
        mounted() {
            this.getServicios();
        }
    }
</script>

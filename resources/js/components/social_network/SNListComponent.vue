<template>
    <div class="container">

        <div style="text-align: right">
            <router-link class="btn btn-primary" to="/social-network/add"><i class="fa fa-plus"></i> Adicionar</router-link>
        </div>
        <br>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">URL</th>
                <th scope="col">Tipo</th>
                <th scope="col" width="20%">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in listSN">
                <th scope="row">{{ index+1 }}</th>
                <td>{{ item.url }}</td>
                <td>{{ item.tipo }}</td>
                <td>
                    <router-link class="btn btn-success" :to="{ name: 'snAdd', params: { id: item.id }}"><i class="fa fa-edit"></i> Editar</router-link>
                    <button type="button" class="btn btn-danger" v-on:click.prevent="removeSN(item.id)"><i class="fa fa-remove"></i> Eliminar</button>
                </td>
            </tr>

            </tbody>
        </table>


    </div>
</template>

<script>
    export default {
        name: 'sn-list-component',
        data:function(){
            return {
                listSN : [],
                id : ''
            }
        },
        methods:{
            getSN: function () {
                fetch('/sn')
                    .then(response => response.json())
                    .then(res => {
                        this.listSN = res;
                    })
            },
            setId: function(id){
                this.id = id;
            },
            removeSN: function(id){
                this.id = id;
                //let route = this.$route.path;
                //let rt = route.replace('/list','');

                this.$swal.fire({
                    title: 'Está seguro?',
                    text: "Se eliminará la Red Social seleccionada.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/sn/'+id)
                            .then(response => {
                                this.$swal.fire('Red Social eliminado correctamente.');
                                this.getSN();
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
            editSN: function(id){
                this.$router.push({ name: 'add', params: { id: id }})
            },
        },
        mounted() {
            this.getSN();
        }
    }
</script>

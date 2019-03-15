<template>
    <div class="container">

        <div class="form-group">
            <label>Tel&eacute;fono</label>
            <input type="text" v-model="phone" name="phone" v-validate="'required'" class="form-control"
                   placeholder="Telefono">
        </div>

        <div class="form-group">
            <label>Correo</label>
            <input type="text" v-model="email" name="email" v-validate="'required'" class="form-control"
                   placeholder="Correo">
        </div>

        <div class="form-group">
            <label for="descTexArea">Direcci&oacute;n</label>
            <textarea v-model="address" v-validate="'required'" name="address" class="form-control" id="descTexArea"
                      rows="3"></textarea>
        </div>


        <ul style="color: red">
            <li v-for="error in errors.all()">{{ error }}</li>
        </ul>

        <div class="form-group">
            <button type="button" class="btn btn-primary" @click="saveData"><i class="fa fa-save"></i> Salvar</button>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                address: '',
                phone: '',
                email: '',
            }
        },

        methods: {
            saveData() {
                if (this.errors.any() === false) {
                    axios.put('/update-contact-data', {
                        address: this.address,
                        phone: this.phone,
                        email: this.email
                    }).then(response => {
                        if (response.status == 200) {
                            this.$swal.fire('Datos actualizados correctamente');
                        } else {
                            this.$swal.fire({
                                type: 'error',
                                title: 'Error',
                                text: 'No se pudo registrar el lugar.',
                            });
                        }
                    });
                } else {
                    this.$swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'Debe rellenar todos los campos.',
                    });
                }


            },
        },

        mounted() {
            axios.get('getContactData')
                .then(response => {
                    console.log(response);
                    this.address = response.data.address;
                    this.phone = response.data.phone;
                    this.email = response.data.email;
                })
                .catch(error => {
                    this.$swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'Ocurrio un error!',
                    });
                });
        }
    }
</script>


<style>
    .cursor-over {
        cursor: pointer;
    }

    .close {
        float: right;
        cursor: pointer;
        font-weight: bold;
    }
</style>

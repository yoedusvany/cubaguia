<template>
    <div class="container">
        <h4>Contact Us</h4>
        <p>
            {{ address }}<br>
            <strong>Phone:</strong> {{ phone }}<br>
            <strong>Email:</strong> {{ email }}<br>
        </p>
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

        mounted() {
            this.$axios.get('getContactData')
                .then(response => {
                    this.address = response.data.address;
                    this.phone = response.data.phone;
                    this.email = response.data.email;
                })
                .catch(error => {
                    console.log(e);
                });
        }
    }
</script>

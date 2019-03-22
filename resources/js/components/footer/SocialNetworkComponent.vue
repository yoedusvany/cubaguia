<template>
    <div class="container">
        <span v-for="item in listSN">
            <a :href="item.url" v-if="item.tipo === 'Twitter'" class="twitter"><i class="fa fa-twitter"></i></a>
            <a :href="item.url" v-else-if="item.tipo === 'Facebook'" class="facebook"><i class="fa fa-facebook"></i></a>
            <a :href="item.url" v-else-if="item.tipo === 'Instagram'" class="instagram"><i class="fa fa-instagram"></i></a>
            <a :href="item.url" v-else-if="item.tipo === 'Google+'" class="google-plus"><i class="fa fa-google-plus"></i></a>
            <a :href="item.url" v-else class="linkedin"><i class="fa fa-linkedin"></i></a>
        </span>
    </div>
</template>

<script>
    export default {
        data() {
            return {
               listSN : []
            }
        },

        mounted() {
            this.$axios.get('/api/sn')
                .then(response => {
                    this.listSN = response.data;
                })
                .catch(error => {
                    console.log(e);
                });
        }
    }
</script>

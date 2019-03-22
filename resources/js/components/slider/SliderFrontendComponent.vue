<template>
    <div class="container">
        <div class="carousel-item" v-for="item in listSliders">
            <div class="carousel-background"><img :src="item.image" alt=""></div>
            <div class="carousel-container">
                <div class="carousel-content">
                    <h2>{{ item.title }}</h2>
                    <p>{{ item.desc }}</p>
                    <!--<a href="#featured-services" class="btn-get-started scrollto">Get Started</a>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                listSliders: [],
            }
        },

        mounted() {
            axios.get('/api/slider-manager')
                .then(response => {
                    this.listSliders = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        }

    }
</script>

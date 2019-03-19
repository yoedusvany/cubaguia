<template>
    <div class="container">
        <header class="section-header wow fadeInUp">
            <h3>{{ title }}</h3>
            <p>
                {{ $t('Services_Text') }}


                <br><br>
                {{ $t('Services_Text1') }}
            </p>
        </header>

        <div class="row">

            <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-duration="1.4s" v-for="(servicio, index) in listServicios" :key="index">
                <div class="icon"><img :src="servicio.icon" width="50px" height="50px"></div>
                <h4 class="title"><a href="#">{{ servicio.name}}</a></h4>
                <p class="description">{{servicio.desc}}</p>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data:function(){
            return {
                listServicios : [],
            }
        },

        props: [
            'title'
        ],

        methods: {
            getServicios: function () {
                fetch('/api/servicios')
                    .then(response => response.json())
                    .then(res => {
                        this.listServicios = res;
                    })
            },
        },

        mounted() {
            this.getServicios();
        }
    }
</script>

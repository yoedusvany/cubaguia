<template>
    <div class="col-lg-4 col-md-6 portfolio-item wow fadeInUp" data-wow-delay="0.1s">
        <div class="portfolio-wrap">
            <figure>
                <img :src="excursion.img" style="background-size: auto 100%;" class="img-fluid" alt="">
                <a href="#" class="link-details" v-on:click="showDetail" data-toggle="modal" data-target="#exampleModalCenter" title="More Details"><i
                    class="ion ion-android-open"></i></a>
            </figure>

            <div class="portfolio-info">
                <h4><a href="#">{{ excursion.nombre }}</a></h4>
                <p>{{ excursion.desc }}</p>
            </div>
        </div>


    </div>

</template>

<script>
    import ExcursionDetail from './ExcursionDetailComponent';

    export default {
        components: {
            'excursion-detail': ExcursionDetail
        },

        props: ['excursion', 'index'],

        data() {
            return {
                show: false,
            }
        },

        methods: {
            showDetail: function () {
                this.show = true;

                const panelInstance = this.$showPanel({
                    component : ExcursionDetail,
                    cssClass: "fondo",
                    props: {
                        excursion: this.excursion
                    }
                });
            }
        },

        mounted() {
        }
    }
</script>

<style>
    .fondo{
        background: #e9ecef!important;
    }
</style>

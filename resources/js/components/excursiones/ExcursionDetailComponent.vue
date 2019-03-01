<template>
    <div class="jumbotron">
        <br>
        <h1 class="display-4 text-center">{{ excursion.nombre }}</h1>
        <hr class="my-4">
        <p class="lead">{{ excursion.desc }}</p>

        <div class="text-center">
            <h3>Lugares</h3>
        </div>
        <lugares class="row" v-for="lugar in lugares" :lugar="lugar" :key="lugar.id"></lugares>

        <br>
        <div class="text-center">
            <button class="btn btn-primary" v-on:click.prevent="closePanel">
                <i class="fa fa-close"></i> Close Panel
            </button>
        </div>
    </div>

</template>


<script>
    import Lugares from './ExcursionesLugaresComponent';

    export default {
        components:{
            'lugares': Lugares
        },

        props: ['excursion'],

        data() {
            return {
                lugares: [],
            }
        },

        methods: {
            closePanel() {
                this.$emit("closePanel", {});
            },
            getLugares: function () {
                fetch('/excursion-lugar/'+this.excursion.id)
                    .then(response => response.json())
                    .then(res => {
                        this.lugares = res;
                    })
            },
        },
        mounted() {
            this.getLugares();
        }
    };
</script>

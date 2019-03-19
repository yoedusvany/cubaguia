<template>
    <div class="jumbotron">
        <br>
        <h1 class="display-4 text-center">{{ excursion.nombre }}</h1>
        <hr class="my-4">
        <p class="lead" v-if="idioma === 'es'">{{ excursion.desc }}</p>
        <p class="lead" v-else>{{ excursion.desc_en }}</p>

        <div class="text-center">
            <h3>{{ $t('Places')}}</h3>
        </div>
        <lugares class="row" v-for="lugar in lugares" :lugar="lugar" :key="lugar.id"></lugares>

        <br>
        <div class="text-center">
            <button class="btn btn-primary" v-on:click.prevent="closePanel">
                <i class="fa fa-close"></i> {{ $t('ClosePanel')}}
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
                idioma: window.laravel.idioma
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

<template>
    <div class="container">

        <header class="section-header">
            <h3 class="section-title">{{ title }}</h3>
        </header>

        <div class="row portfolio-container">
            <excursion-item-component v-for="(item, index) in excursiones" :key="item.id" :index="index+1" :excursion="item"></excursion-item-component>
        </div>

        <slideout-panel></slideout-panel>
    </div>
</template>

<script>

    import ExcursionItem from './ExcursionItemComponent';

    export default {
        components: {
            'excursion-item-component': ExcursionItem
        },

        data() {
            return {
                excursiones: []
            }
        },

        props: [
            'title'
        ],

        methods: {
            getExcursiones: function () {
                axios.get('/excursion-list')
                    .then(resp => {
                        this.excursiones = resp.data;
                    });
            }
        },

        mounted() {
            this.getExcursiones();
        }
    }
</script>

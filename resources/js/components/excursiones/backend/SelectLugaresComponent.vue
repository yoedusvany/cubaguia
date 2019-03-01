<template>
    <div v-on:click="clickLugar">
        <div class="card" :class="{lugarSelect:isSelected}" style="width: 18rem;">
            <img class="card-img-top" :src="img">
            <div class="card-body">
                <h5 class="card-title">{{nombre}}</h5>
                <p class="card-text">{{ desc }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['id','nombre','desc','img', 'selected'],

        data: () => ({
            isSelected : false
        }),

        methods:{
            clickLugar: function () {
                this.isSelected = !this.isSelected;
                this.$emit('selectLugar', this.id);
            }
        },
        mounted() {
            this.isSelected = this.selected;
        },
        watch: {
            selected: function (val, oldVal) {
                this.isSelected = val;
            },
        }
    }
</script>


<style>
    .lugarSelect{
        outline: 1px solid blue;
    }
</style>

<template>
    <div class="container">
        <h3>Servicios</h3>
        <div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

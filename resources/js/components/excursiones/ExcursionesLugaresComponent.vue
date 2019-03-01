<template>
    <div class="container">
        <div class="col-md-12 col-lg-12">
            <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                    <!--<strong class="d-inline-block mb-2 text-primary"></strong>-->
                    <h3 class="mb-0">{{ lugar.nombre }}</h3>
                    <p class="card-text mb-auto">{{ lugar.desc }}</p>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <div>
                        <img :src="lugar.imagen" class="card-img-top" width="300" height="250" alt="...">
                    </div>
                    <!--<svg class="bd-placeholder-img" width="300" height="250" :xmlns="lugar.imagen"
                         preserveAspectRatio="xMidYMid slice" focusable="false" role="img"
                         aria-label="Placeholder: Thumbnail"><title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#55595c"></rect>
                    </svg>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['lugar'],
        mounted() {
        }
    }
</script>


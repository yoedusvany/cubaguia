<template>
    <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="verContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Informaci&oacute;n detallada del contacto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4 col-lg-4 col-md-4"><b>Nombre</b></div>
                            <div class="col-sm-8 col-lg-8 col-md-8">{{ contact.nombre }}</div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 col-lg-4 col-md-4"><b>Correo</b></div>
                            <div class="col-sm-8 col-lg- col-md-8">{{ contact.email }}</div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 col-lg-4 col-md-4"><b>Asunto</b></div>
                            <div class="col-sm-8 col-lg-8 col-md-8">{{ contact.subject }}</div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-lg-12 col-md-12"><b>Mensaje</b></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-lg-12 col-md-12">
                                <textarea style="resize: none" class="form-control" rows="3" readonly>{{ contact.message }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['id'],
        data:function () {
            return{
                contact:Object,
            }
        },
        methods: {
            getInfo: function (id) {
                fetch('/contact/'+id)
                    .then(resp => resp.json())
                    .then(resp => {
                        this.contact = resp
                    })
            }
        },
        watch: {
            id: function (val, oldVal) {
                this.getInfo(val);
            },
        }

    }
</script>

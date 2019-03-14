<template>
    <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="responderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Redactar correo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12 col-md-12"><b>Para: </b>{{ email }}</div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12 col-lg-12 col-md-12">
                                <input type="text" v-model="subject" class="form-control" id="exampleInputEmail1" placeholder="Asunto" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-lg-12 col-md-12">
                                <textarea v-model="message" style="resize: none" class="form-control" rows="3" placeholder="Teclee el cuerpo del mensaje" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click.prevent="sendMail"><i class="fa fa-send"></i> Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['email'],
        data:function () {
            return{
                subject : '',
                message : ''
            }
        },
        methods: {
            sendMail: function () {

                if(this.subject !== '' && this.message !== ''){
                        fetch('/sendMail/'+this.email+'/'+this.subject+'/'+this.message)
                        .then(response => response.json())
                        .then(res => {
                            console.log(res);

                            if(res){
                                this.subject = '';
                                this.message = '';
                                alert("Correo enviado satisfactoriamente");
                            }
                        })
                }else{
                    alert("Debe rellenar los campos 'Asunto' y/o 'Mensaje'");
                }
            }
        }
    }
</script>

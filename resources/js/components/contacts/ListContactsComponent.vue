<template>
    <div class="container">
        <h3>Contactos</h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Asunto</th>
                <th scope="col">Fecha</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in listContacts">
                <th scope="row">{{ index+1 }}</th>
                <td>{{ item.nombre }}</td>
                <td>{{ item.email }}</td>
                <td>{{ item.subject }}</td>
                <td>{{ item.created_at }}</td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#verContactModal" v-on:click.prevent="setId(item.id)"><i class="fa fa-eye"></i> Ver</button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#responderModal" v-on:click.prevent="responderAction(item.email)"><i class="fa fa-reply"></i> Responder</button>
                </td>
            </tr>

            </tbody>
        </table>


        <contact-show-info-modal-component :id="id" v-show="clicked"></contact-show-info-modal-component>
        <contact-responder-modal-component :email="email" v-show="responder"></contact-responder-modal-component>
    </div>
</template>

<script>
    import ShowContactInfoModalComponent from './ShowContactInfoModalComponent';
    import ResponderModalComponent  from './ResponderModalComponent';

    export default {
        components:{
            'contact-show-info-modal-component' : ShowContactInfoModalComponent,
            'contact-responder-modal-component' : ResponderModalComponent
        },
        data:function(){
            return {
                listContacts : [],
                id : '',
                clicked : false,
                responder : false,
                email : ''
            }
        },
        methods:{
            getContacts: function (id) {
                fetch('/contact-list')
                    .then(response => response.json())
                    .then(res => {
                        this.listContacts = res;
                    })
            },
            setId: function(id){
                this.clicked = true;
                this.id = id;
            },
            responderAction: function(email){
                this.responder = true;
                this.email = email;
            }
        },
        mounted() {
            this.getContacts();
        }
    }
</script>

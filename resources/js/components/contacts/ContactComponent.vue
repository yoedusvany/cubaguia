<template>

    <!--==========================
      Contact Section
    ============================-->

        <div class="container">

            <div class="section-header">
                <h3>{{ title }}</h3>
            </div>

            <div class="row contact-info">

                <div class="col-md-4">
                    <div class="contact-address">
                        <i class="ion-ios-location-outline"></i>
                        <h3>{{ $t('Address') }}</h3>
                        <address>{{ contactDataAddress }}</address>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-phone">
                        <i class="ion-ios-telephone-outline"></i>
                        <h3>{{ $t('Phone') }}</h3>
                        <p><a href="tel:+155895548855">{{ contactDataPhone  }} </a></p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-email">
                        <i class="ion-ios-email-outline"></i>
                        <h3>{{ $t('Email') }}</h3>
                        <p><a href="mailto:info@example.com">{{ contactDataMail }}</a></p>
                    </div>
                </div>

            </div>

            <div class="form">
                <div id="sendmessage">{{ $t('SendMessage') }}</div>
                <div id="errormessage"></div>
                <div class="contactForm">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" name="name" v-model="name" class="form-control" v-bind:placeholder="$t('Name')" data-rule="minlen:4" data-msg="Please enter at least 4 chars" v-validate="'required'">
                            <div class="validation"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" class="form-control" v-model="email" id="email" v-bind:placeholder="$t('Email')" data-rule="email" data-msg="Please enter a valid email" v-validate="'required'" />
                            <span class="validation" v-show="errors.has('email')">{{ errors.first('email') }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject" v-model="subject" id="subject" v-bind:placeholder="$t('Subject')" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" v-validate="'required'" />
                        <div class="validation"></div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" v-model="message" rows="5" data-rule="required" data-msg="Please write something for us" v-bind:placeholder="$t('Message')" v-validate="'required'"></textarea>
                        <div class="validation"></div>
                    </div>
                    <div class="text-center">
                        <button v-on:click.prevent="submitContact" type="submit" data-toggle="modal" data-target="#exampleModal">{{ $t('SendMessageButton') }}</button>
                    </div>
                </div>
            </div>
        </div>

</template>

<script>
    export default {
        props:{
            title : ''
        },

        data:function(){
            return {
                name : '',
                email: '',
                subject : '',
                message : '',
                result  : false,
                textResult : 'Su información de contacto ha sido registrada correctamente. En breve nos pondremos en contacto con usted.',

                contactDataMail: '',
                contactDataPhone: '',
                contactDataAddress: '',
            }
        },
        methods:{
            submitContact: function(){
                this.$validator.validate().then(result => {
                    if (result) {
                        let newContact = {
                            name    : this.name,
                            email   : this.email,
                            subject : this.subject,
                            message : this.message
                        };

                        this.$axios.post('/contact',newContact).then((response) => {
                            this.name = '';
                            this.email = '';
                            this.subject = '';
                            this.message = '';

                            if(response.statusText === "Created"){
                                this.result = true;
                                this.$swal.fire(this.$t('SuccessProccessContactMessage'));
                            }else{
                                this.result = '';
                                this.$swal.fire({
                                    type: 'error',
                                    title: 'Error',
                                    text: this.$t('ErrorProccessContactMessage'),
                                });
                            }
                        });
                    }else{
                        this.$swal.fire({
                            type: 'error',
                            title: 'Error',
                            text:  this.$t('ErrorMessage'),
                        });
                    }
                });



            }
        },
        mounted() {
            this.$axios.get('getContactData')
                .then(response => {
                    this.contactDataAddress = response.data.address;
                    this.contactDataPhone = response.data.phone;
                    this.contactDataMail = response.data.email;
                })
                .catch(error => {
                    this.$swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'Ocurrio un error!',
                    });
                });
        }
    }
</script>

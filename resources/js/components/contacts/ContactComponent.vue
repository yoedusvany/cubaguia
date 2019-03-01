<template>

    <!--==========================
      Contact Section
    ============================-->

        <div class="container">

            <div class="section-header">
                <h3>{{ title }}</h3>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
            </div>

            <div class="row contact-info">

                <div class="col-md-4">
                    <div class="contact-address">
                        <i class="ion-ios-location-outline"></i>
                        <h3>Address</h3>
                        <address>A108 Adam Street, NY 535022, USA</address>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-phone">
                        <i class="ion-ios-telephone-outline"></i>
                        <h3>Phone Number</h3>
                        <p><a href="tel:+155895548855">+1 5589 55488 55</a></p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-email">
                        <i class="ion-ios-email-outline"></i>
                        <h3>Email</h3>
                        <p><a href="mailto:info@example.com">info@example.com</a></p>
                    </div>
                </div>

            </div>

            <div class="form">
                <div id="sendmessage">Your message has been sent. Thank you!</div>
                <div id="errormessage"></div>
                <div class="contactForm">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" name="name" v-model="name" class="form-control" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required>
                            <div class="validation"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" class="form-control" v-model="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" required />
                            <span class="validation" v-show="errors.has('email')">{{ errors.first('email') }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject" v-model="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" required />
                        <div class="validation"></div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" v-model="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                        <div class="validation"></div>
                    </div>
                    <div class="text-center">
                        <button v-on:click.prevent="submitContact" type="submit" data-toggle="modal" data-target="#exampleModal">Send Message</button>
                    </div>
                </div>
            </div>
        </div>

</template>

<script>
    export default {

        data:function(){
            return {
                title : '',
                name : '',
                email: '',
                subject : '',
                message : '',
                result  : false,
                textResult : 'Su información de contacto ha sido registrada correctamente. En breve nos pondremos en contacto con usted.'
            }
        },
        methods:{
            submitContact: function(){
                let newContact = {
                    name    : this.name,
                    email   : this.email,
                    subject : this.subject,
                    message : this.message
                };

                axios.post('/contact',newContact).then((response) => {
                    this.name = '';
                    this.email = '';
                    this.subject = '';
                    this.message = '';

                    if(response.statusText === "Created"){
                        this.result = true;
                        this.$swal.fire('Contacto registrado correctamente.');
                    }else{
                        this.result = '';
                        this.$swal.fire({
                            type: 'error',
                            title: 'Error',
                            text: 'Ocurrió algún error al intentar registrar su información de contacto. Intentelo mas tarde.',
                        });
                    }
                });
            }
        },
        mounted() {
        }
    }
</script>

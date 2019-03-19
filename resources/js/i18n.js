import Vue from 'vue';
import VueI8n from 'vue-i18n';

Vue.use(VueI8n);

export const i18n = new VueI8n({
    locale: window.laravel.idioma,
    fallbackLoale: 'en',
    messages:{
        en: {
            Home: "Home",
            About_Us: "About Us",
            Excursions: "Excursions",
            Contact_Us: "Contact Us",
            Services: "Services",
            Address: "Address",
            Phone: "Phone",
            Email: "Email",
            Contact: "Contact",
            Places: "Places",
            Services_Text : "We will take care of you to spend days for the memory, our services complement the excursion of your life.",
            Services_Text1 : "These are our services.",
            SendMessage : "Your message has been sent. Thank you!",
            SendMessageButton : "Send Message",
            Name: "Name",
            Subject: "Subject",
            Message: "Message",
            ErrorMessage : "You must fill in all fields.",
            ErrorMessage1 : "Something is wrong.",
            ErrorProccessContactMessage : "Some error occurred while trying to register your contact information. Try it later",
            SuccessProccessContactMessage : "Contact registered correctly.",
            ClosePanel : "Close Panel",
            ViewGallery : "See Gallery",
            MoreDetails : "More Details",
        },
        es:{
            Inicio: "Home",
            Acerca_de: "About Us",
            Excursiones: "Excursions",
            Contactenos : "Contact Us" ,
            Servicios : "Services",
            Address : "Dirección",
            Phone: "Teléfono",
            Email: "Correo",
            Contactos : "Contact",
            Places : "Lugares",
            Services_Text : "Nos encargaremos de que pases dias para el recuerdo, nuestros servicios complementan la excursi&oacute;n de tu vida.",
            Services_Text1 : "Estos son nuestros servicios.",
            SendMessage : "Su mensaje ha sido enviado. Gracias!",
            SendMessageButton : "Enviar",
            Name: "Nombre",
            Subject: "Asunto",
            Message: "Mensaje",
            ErrorMessage : "Debe rellenar todos los campos.",
            ErrorMessage1 : "Something is wrong.",
            ErrorProccessContactMessage : "Ocurrió algún error al intentar registrar su información de contacto. Intentelo mas tarde.",
            SuccessProccessContactMessage : "Contacto registrado correctamente.",
            ClosePanel : "Cerrar Panel",
            ViewGallery : "Ver Galería",
            MoreDetails : "Mas Detalles",
        }
    }
});

/** 
 * Here we pull in the Vue dependency from node_modules.
 */
import Vue from 'vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import MovieModal from './components/MovieModal';

const Modal = {
    install(Vue) {
        this.event = new Vue();
        Vue.prototype.$modal = {
            show(modal, params = {}) {
                //Emit the show event of the modal.
                Modal.event.$emit('show', modal, params);
            },
            hide(modal) {
                //Emit the hide event of the modal.
                Modal.event.$emit('hide', modal);
            },
            $event: this.event
        };
    }
};
Vue.use(Modal);
const app = new Vue({
    el: "#root",
    methods: {
        openModal: function(id) {
            //This calls the show function for the modal which emits the show event.
            this.$modal.show('modal', { id: id });
        }
    },
    components: {
        "Modal": Modal,
        "MovieModal": MovieModal
    }
});

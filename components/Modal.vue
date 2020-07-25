<template>
    <div v-if="visible">
        <div class="modal"@click.prevent="visible = false"></div>
        <div class="modal-inner">
            <p class="modal-close"><a href="#" @click.prevent="visible = false" class="button-close">&times;</a></p>
            <slot name="body" :params="params" />
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                params: {}, //This will contain any parameters we want to pass to the parent modal.
                visible: false //Show the modal when this is true.
            };
        },
        props: {
            name: {
                required: true, //Every modal must have a name.
                type: String //The name must be a string.
            }
        },
        beforeMount() {
            //This is the event handler for the show event, this shows the modal.
            this.$modal.$event.$on('show', (modal, params) => {
                if (this.name === modal) {
                    this.params = params;
                    //Emit the before-open event, pass both the done callback function and the id of the modal.
                    this.$emit('before-open', (done) => { 
                        //Show the modal.
                        this.visible = true;
                    }, params.id);
                }
            });
            //This is the event handler for the hide event, this hides the modal.
            this.$modal.$event.$on('hide', (modal, params) => {
                if (this.name === modal) {
                    this.params = params;
                    //Hide the modal.
                    this.visible = false;
                }
            });
        },
        mounted() {
            document.addEventListener('keydown', (e) => {
                //If the modal is visible and the keyCode is 27 (the keyCode for escape), call the hide function of the modal.
                if (this.visible && e.keyCode === 27) {
                    //Call the hide function of the modal passing the name of the modal, this emits the hide event.
                    this.$modal.hide(this.name);
                }
            });
        }
    };
</script>

<style>
    .modal {
        background-color: rgba(0, 0, 0, 0.2); 
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 20;
    }
    .modal-inner {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 30px;
        width: 90%;
        max-width: 500px;
        z-index: 20;
    }
    .modal-close {
        margin: -25px 0 0 250px; 
    }
    @media (min-width: 1200px) {
        .modal-close {
            margin: -25px 0 0 400px; 
        }
    }
    
    .button-close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .button-close:hover,
    .button-close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

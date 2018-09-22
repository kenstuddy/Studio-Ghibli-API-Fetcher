<template>
    <Modal name="modal" @before-open="loadMovie">
        <template slot="body" slot-scope="{ params }">
            <div class="title">
                <span class="title-text"> 
                    {{ title }}
                </span>
            </div>
            <div>
                {{ description }}
            </div>
	</template>
    </Modal>
</template>

<script>
    import axios from 'axios';
    import Modal from './Modal';
    export default {
        data() {
            return {
                description: "", //The description of the movie.
                title: "" //The title of the movie.
            };
        },
        components: {
            Modal
        },
        methods: {
            //This loadMovie method asynchronously loads the movie using async/await and axios to call an API (using an API wrapper), this method is called when the before-open event is emitted (when the modal is currently invisible but was added to the DOM and will become visible). We pass both a callback function called done and the id from the Modal component using params.id.
            async loadMovie(done, id) {
                let response = await axios.get(`fulldescription.php?film=${id}`);
                //Here we set the description and title of the movie using the asynchronous setTimeout method, this movie data is loaded asynchronously using async/await with axios calling an API (using an API wrapper).
                setTimeout(() => {
                    this.title = response.data.title;
                    this.description = response.data.description;
                    //Check that the callback function is actually a function before calling it.
                    if (typeof done === "function") {
                        done();
                    }
                 }, 0);
            }
        }
    };
</script>

<style>
    .title {
        margin-bottom: 10px;
    }
    .title-text {
        font-family: "Verdana";
    }
</style>

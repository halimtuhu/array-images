<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <input
            :id="field.name"
            class="hidden"
            type="text"
            :name="field.name"
            v-model="value"
            >
            <input
                class="hidden"
                type="file"
                ref="add_image"
                @change="fileSelected"
                multiple
            />
            <button
                type="button"
                class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded"
                @click="$refs.add_image.click()"
            >Upload Image</button>
            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>
            <div class="flex flex-col pt-8 text-center">
                <div v-for="(img, index) in images" class="w-1/2 p-2 mb-4 rounded shadow-lg">
                    <p><img
                        :src="img.url"
                        :alt="img.name"
                        class="rounded"
                    /></p>
                    <a href="#" @click.prevent="deleteImage(index)" class="text-danger hover:font-bold no-underline mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                        delete
                    </a>
                </div>
            </div>
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data() {
        return {
            selectedFile: null,
            images: [],
        }
    },

    methods: {
        /**
         * Selected file event trigger
         */
        fileSelected(event) {
            var app = this;
            const fd = new FormData();
            
            var imageCount = event.target.files.length;
            var images = [];
            for (var i = 0; i < imageCount; i++) {
                fd.append('images[]', event.target.files[i]);
            }
            fd.append('disk', this.field.disk);
            fd.append('path', this.field.path);

            axios.post('/nova-vendor/array-images/upload', fd)
                .then(res => {
                    for (var i = 0; i < res.data.length; i++) {
                        app.images.push(res.data[i]);
                    }
                    app.value = JSON.stringify(app.images)
                });
        },

        deleteImage(index) {
            const { saved_path } = this.images[index]
            const params = { disk: this.field.disk }
            axios.delete('/nova-vendor/array-images/delete/' + encodeURIComponent(saved_path), { params })
              .then(() => {
                this.images.splice(index, 1);
                this.value = JSON.stringify(this.images);
              })
              .catch(console.warn)
        },

        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || '';
            this.images = JSON.parse(this.field.value) || [];
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '');
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value;
        },
    },
}
</script>

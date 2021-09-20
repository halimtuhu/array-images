<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
          <div v-if="loading" class="svg-loader">
            <svg class="svg-container" height="100" width="100" viewBox="0 0 100 100">
              <circle class="loader-svg bg" cx="50" cy="50" r="45"></circle>
              <circle class="loader-svg animate" cx="50" cy="50" r="45"></circle>
            </svg>
          </div>
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
            loading: false,
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
            if(this.field.resize) {
              fd.append('resize', this.field.resize);
            }
            this.loading = true;
            axios.post('/nova-vendor/array-images/upload', fd)
                .then(res => {
                    for (var i = 0; i < res.data.length; i++) {
                        app.images.push(res.data[i]);
                    }
                    this.loading = false;
                    app.value = JSON.stringify(app.images)
                }).catch(error => {
                  this.loading = true;
                });
        },

        deleteImage(index) {
            axios.delete('/nova-vendor/array-images/delete/'+this.images[index].name);
            this.images.splice(index, 1);
            this.value = JSON.stringify(this.images);
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
<style>
.svg-loader{
  display:flex;
  position: relative;
  align-content: space-around;
  justify-content: center;
}
.loader-svg{
  position: absolute;
  left: 0; right: 0; top: 0; bottom: 0;
  fill: none;
  stroke-width: 5px;
  stroke-linecap: round;
  stroke: rgb(64, 0, 148);
}
.loader-svg.bg{
  stroke-width: 8px;
  stroke: rgb(207, 205, 245);
}
.animate{
  stroke-dasharray: 242.6;
  animation: fill-animation 1s cubic-bezier(1,1,1,1) 0s infinite;
}

@keyframes fill-animation{
  0%{
    stroke-dasharray: 40 242.6;
    stroke-dashoffset: 0;
  }
  50%{
    stroke-dasharray: 141.3;
    stroke-dashoffset: 141.3;
  }
  100%{
    stroke-dasharray: 40 242.6;
    stroke-dashoffset: 282.6;
  }
}
</style>
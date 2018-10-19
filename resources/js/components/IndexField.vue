<template>
    <span class="flex flex-row overflow-x-auto scrolling-touch" style="width: 10rem;">
        <img
            v-for="img in JSON.parse(field.value)"
            :src="img.url"
            :alt="img.name"
            class="rounded h-8 mr-1"
        >
    </span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
}
</script>

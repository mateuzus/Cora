<template>
    <button
        class="btn btn-sm"
        :class="this.class"
        @click="this.action">
        <i :class="icon"></i> {{text}}
    </button>
</template>

<script>
export default {
    name: "Botao_html.vue",
    props:[
        'class',
        'action',
        'icon',
        'text',
    ]
}
</script>

<style scoped>

</style>

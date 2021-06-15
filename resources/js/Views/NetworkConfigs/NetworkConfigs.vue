<template>
    <div class="container-fluid">
        <div class="content text-center" v-if="isLoading">
            <i class="fas fa-spin fa-sync-alt"></i>
        </div>

        <div class="content" v-else>

        </div>
    </div>
</template>

<script>
import vSelect from 'vue-select';
import {VueEditor} from 'vue2-editor';
export default {
    name: "NetworkConfigs",
    props: [],
    components: {
        vSelect, VueEditor
    },
    data(){

    }
}
</script>

<style scoped>

</style>

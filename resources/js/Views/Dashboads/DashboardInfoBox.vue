<template>
    <div class="col-12">
        <div class="info-box">
            <span class="info-box-icon elevation-1" :class="color"><i :class="icon"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">{{ title }}</span>
                <span class="info-box-number">
                  {{ value }}
                  <small>{{subtitle}}</small>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</template>

<script>
export default {
    name: "DashboardInfoBox",
    props:['icon', 'title', 'value', 'color', 'subtitle'],
}
</script>

<style scoped>

</style>

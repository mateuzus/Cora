<template>
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-light-blue">
            <div class="inner">
                <h3>{{ value || 0 }}</h3>

                <p>{{ title }}</p>
            </div>
            <div class="icon">
                <i :class="icon"></i>
            </div>
<!--            <a :href="link" class="small-box-footer">Veja mais <i class="fas fa-arrow-circle-right"></i></a>-->
        </div>
    </div>
</template>

<script>
export default {
name: "DashboardCard",
    props:['value', 'title', 'icon', 'color', 'link'],
}
</script>

<style scoped>

</style>

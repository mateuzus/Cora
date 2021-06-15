<template>

    <div class="container-fluid">
        <div class="content text-center" v-if="isLoading">
            <i class="fas fa-spin fa-sync-alt"></i>
        </div>
        <div class="content" v-else>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Suas Listas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-condensed">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Descrição</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Quantidade de perguntas</th>
                                            <th scope="col">Perguntas Respondidas</th>
                                            <th scope="col">Ações</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(list, index ) in this.listings">
                                                <td>{{ list.id}}</td>
                                                <td>{{ list.description}}</td>
                                                <td>{{ list.typeLabel}}</td>
                                                <td>{{ list.questions.length}}</td>
                                                <td>{{ list.questions.filter((question)=>{return question.status == true}).length}}</td>
                                                <td>
                                                    <a class="btn btn-default" :href="`/questions/${list.id}`"><i class="fas fa-list"></i> Ver Perguntas</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "ListingByUserPage.vue",
    props: ['user'],
    data() {
        return {
            isLoading: true,
            showModal: false,
            listings: [],
        }
    },

    created() {
        this.getData();
    },
    methods: {
        getData() {
            this.isLoading = true;
            try {
                let url = `/api/v1/system/listings?user_id=${this.user.id}`;

                axios
                    .get(url)
                    .catch(error => {
                        Swal.fire("Opps", error.data.toString(), 'error');
                    })
                    .then(response => {
                        console.log(response.data);
                        this.listings = response.data;
                    });
            } catch (e) {
                Swal.fire('OOOpppss', e.toString(), 'error');
            }
            this.isLoading = false;
        },

    }
}
</script>

<style scoped>
.card-header > .card-tools-filter {
    float: right;
    min-width: 80%;
    margin-right: -0.625rem;
}
</style>

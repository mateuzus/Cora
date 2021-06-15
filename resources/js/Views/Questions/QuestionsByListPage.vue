<template>

    <div class="container-fluid">
        <div class="content text-center" v-if="isLoading">
            <i class="fas fa-spin fa-sync-alt"></i>
        </div>
        <div class="content" v-else>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perguntas da Lista</h3>
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
                                            <th scope="col">Ações</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(question, index ) in this.questions">
                                                <td>{{ question.id}}</td>
                                                <td>{{ question.description}}</td>
                                                <td>{{ question.type_label}}</td>
                                                <td>
                                                    {{question.question_type}}
                                                    <input v-if="question.question_type == 'number_integer'" type="text" @change="answerGived(question, index)" v-model="question.answer" class="form-control" placeholder="DIGITE SUA RESPOSTA">
                                                    <input v-else-if="question.question_type == 'number_decimal'" type="text" @change="answerGived(question, index)" v-model="question.answer" class="form-control" placeholder="DIGITE SUA RESPOSTA">
                                                    <select v-else-if="question.question_type == 'boolean'"  @change="answerGived(question, index)" v-model="question.answer" class="form-control">
                                                        <option :value="null" disabled >Selecione uma opção</option>
                                                        <option value="NAO">NÃO</option>
                                                        <option value="SIM">SIM</option>
                                                    </select>

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
    props: ['user', 'list'],
    data() {
        return {
            isLoading: true,
            showModal: false,
            questions: [],
            answer: null,
        }
    },

    created() {
        this.getData();
    },
    methods: {
        getData() {
            this.isLoading = true;
            try {
                let url = `/api/v1/system/questions/${this.list.id}?user_id=${this.user.id}&awnser_given=false`;

                axios
                    .get(url)
                    .catch(error => {
                        Swal.fire("Opps", error.data.toString(), 'error');
                    })
                    .then(response => {
                        response.data.forEach((question)=>{
                           if(question.status == 0){
                               question.answer = null;
                           }
                            this.questions.push(question);

                        });
                    });
            } catch (e) {
                Swal.fire('OOOpppss', e.toString(), 'error');
            }
            this.isLoading = false;
        },


        answerGived(question, index){
            //remove da lista e submit na resposta
            console.log(question);

            this.isLoading = true;
            try {

                let url = `/api/v1/system/answergiven/${question.id}`;
console.log(url);
                axios
                    .post(url, {
                        answer: question.answer
                    })
                    .catch(error => {
                        Swal.fire("Opps", error.data.toString(), 'error');
                    })
                    .then(response => {
                        let timerInterval
                        Swal.fire({
                            title: "Sucesso",
                            html: response.data.message,
                            timer: 800,
                            timerProgressBar: true,
                            position: 'top-end',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            },
                            willOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {
                                    const content = Swal.getContent()
                                    if (content) {
                                        const b = content.querySelector('b')
                                        if (b) {
                                            b.textContent = Swal.getTimerLeft()
                                        }
                                    }
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                this.questions.splice(index, 1);
                            }
                        })
                    });
            } catch (e) {
                Swal.fire('OOOpppss', e.toString(), 'error');
            }
            this.isLoading = false;

        }

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

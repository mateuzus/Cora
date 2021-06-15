<template>

    <div class="container-fluid">
        <div class="content text-center" v-if="isLoading">
            <i class="fas fa-spin fa-sync-alt"></i>
        </div>
        <div class="content" v-else>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><strong>Listagem de tarefas do POP:</strong> {{ this.pop.name }}
                                </h3>
                                <div class="card-tools">
                                    <div class="btn-group">
                                        <button class="btn btn-tolls" @click="createTask">Adicionar Tarefa</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-condensed">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nome</th>
                                                    <th scope="col">Tipo</th>
                                                    <th scope="col">Obrigatória</th>
                                                    <th scope="col">Tem ação</th>
                                                    <th scope="col">Ações</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(task, index ) in this.tasks">
                                                    <td>{{ task.id }}</td>
                                                    <td>{{ task.description }}</td>
                                                    <td>{{ getTypeLabel(task) }}</td>
                                                    <td>
                                                        <span class="badge badge-success" v-if="task.required == 1">Sim</span>
                                                        <span class="badge badge-danger" v-else>Não</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-success" v-if="task.has_action == 1">Sim</span>
                                                        <span class="badge badge-danger" v-else>Não</span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button class="btn btn-sm btn-default" @click="editTask(task)"><i class="fas fa-edit"></i> Editar</button>
                                                            <button class="btn btn-sm  btn-danger" @click="deleteTask(index, task)"><i class="fas fa-trash"></i> Apagar</button>
                                                        </div>
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
            <!--modal de create e edit-->
            <modal v-bind:show="this.showModal" :modaltitle="'Tarefa'">

                <div slot="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Descrição</label>
                                <input type="text" class="form-control" v-model="task.description" placeholder="Digite a descrição">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6><strong>Obrigatória</strong></h6>
                                <input type="radio" id='requiredYes' v-model="task.required" value='1' class="">
                                <label class="form-label" for="requiredYes">Sim</label>
                                <input type="radio" id='requiredNo' v-model="task.required" value='0' class="">
                                <label class="form-label" for="requiredNo">Não</label>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <h6><strong>Tem ação</strong></h6>
                                    <input type="radio" id='hasActionYes' v-model="task.has_action" value='1' class="">
                                    <label class="form-label" for="hasActionYes">Sim</label>
                                    <input type="radio" id='hasActionNo' v-model="task.has_action" value='0' class="">
                                    <label class="form-label" for="hasActionNo">Não</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tipo</label>
                                <select class="form-control" v-model="task.type">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option value="NUMERO_INTEIRO">NÚMERO INTEIRO</option>
                                    <option value="BOOLEAN">Verdadeiro ou Falso</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Peso</label>
                                <input type="number" step="1" min="1" max="100" class="form-control" v-model="task.weight" placeholder="Digite o peso da pergunta">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Video</label>
                                <input type="text" class="form-control" v-model="task.video" placeholder="Digite o link de um vídeo">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Quantidade?</label>
                                <input type="text" class="form-control" v-model="task.quantity" placeholder="Digite a quantidade para verificação">
                            </div>
                        </div>
                    </div>
                </div>
                <div slot="buttons">
                    <div class="modal-footer">
                        <button class="btn btn-success" v-if="!editingTask" @click="storeTask">
                            <i class="fas fa-check"></i> Salvar
                        </button>
                        <button class="btn btn-success" v-else @click="updateTask(task)">
                            <i class="fas fa-check"></i> Atualizar
                        </button>
                        <button type="button" class="btn btn-secondary" @click="showModal = false">Fechar</button>

                    </div>
                </div>
            </modal>
        </div>
    </div>

</template>

<script>
import vSelect from "vue-select";

export default {

    name: "PopTasksPage.vue",
    props: ['user', 'network', 'pop'],
    components: {
        vSelect
    },
    data() {
        return {
            isLoading: false,
            showModal: false,
            editingTask: false,
            tasks: {},
            task:{
                pop_id:this.pop.id,
                description:null,
                required: 0,
                type: "BOOLEAN",
                weight: 1,
                has_action: 0,
                video: null,
                quantity: null,
            }

        }
    },

    mounted() {
        // jQuery('input').iCheck({
        //     checkboxClass: 'icheckbox_square',
        //     radioClass: 'iradio_square',
        //     increaseArea: '20%' // optional
        // });
        this.getData();
    },
    methods: {
        getData() {
            this.isLoading = true;
            try {
                let url = `/api/v1/operationstandarttasks?pop=${this.pop.id}`;

                axios.get(url)
                    .catch(error => {
                        Swal.fire("Opps", error.data.toString(), 'error');
                    })
                    .then(response => {
                        this.tasks = response.data.data;
                    });
            } catch (e) {
                Swal.fire('OOOpppss', e.toString(), 'error');
            }
            this.isLoading = false;

        },
        getTypeLabel(task){
            switch (task.type) {
                case "BOOLEAN":
                    return "VERDADEIRO OU FALSO";
                case "NUMERO_INTEIRO":
                    return "NÚMERO INTEIRO";
            }

        },
        createTask() {
            this.showModal = true;
            this.editingTask = false;
        },
        storeTask(){
            this.showModal = false;
            let url = `/api/v1/operationstandarttasks?pop=${this.pop.id}`;
            axios.post(url, this.task)
                .then(response=>{

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
                            this.tasks.push(response.data.data);
                            this.task = {
                                pop_id:this.pop.id,
                                    description:null,
                                    required: 0,
                                    type: "BOOLEAN",
                                    weight: 1,
                                    has_action: 0,
                                    video: null,
                                    quantity: null,
                            };
                            this.showModal = false;
                        }
                    })

                }).catch(error=>{
                    this.isLoading=false;
                    Swal.fire("Opps", error.toString(), 'error');
                });
        },
        editTask(task){
            this.showModal = true;
            this.editingTask = true;
            this.task = task;
        },
        updateTask(task){
            this.showModal = false;
            this.showModalEdit = false;
            this.isLoading = true;
            let url = `/api/v1/operationstandarttasks/${task.id}?pop=${this.pop.id}`;
            axios.put(url, task)
                .then(response=>{
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
                            this.task = {
                                pop_id:this.pop.id,
                                description:null,
                                required: 0,
                                type: "BOOLEAN",
                                weight: 1,
                                has_action: 0,
                                video: null,
                                quantity: null,
                            };
                        }
                    })

                }).catch(error=> {

                Swal.fire("Opps", error.toString(), 'error');
            });

            this.isLoading = false;
        },
        deleteTask(index, task){
            Swal.fire({
                title: 'Você tem certeza que gostaria de apagar esse registro?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Apagar`,
                denyButtonText: `Não apagar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = `/api/v1/operationstandarttasks/${task.id}`;
                    axios.delete(url, task)
                        .then(response=>{

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
                                    this.tasks.splice(index, 1);
                                }
                            })

                        }).catch(error=> {
                        Swal.fire("Opps", error.toString(), 'error');
                    });
                } else if (result.isDenied) {
                    Swal.fire('Uffa', 'Suas informações estão a salvo', 'info')
                }
            })
        },
    }
}
</script>

<style scoped>


</style>

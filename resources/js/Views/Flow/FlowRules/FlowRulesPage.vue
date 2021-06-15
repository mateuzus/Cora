<template>

    <div class="container-fluid">
        <div class="content text-center" v-if="isLoading">
            <i class="fas fa-spin fa-sync-alt"></i>
        </div>
        <div class="content" v-else>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Regras do fluxo</h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button class="btn btn-tool" @click="createFlowRule"> <i class="fas fa-plus"></i> Adicionar novo</button>
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
                                            <th scope="col">Ordem</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Gatilho</th>
                                            <th scope="col">Condição</th>
                                            <th scope="col">Valor</th>

                                            <th scope="col">Departamento</th>
                                            <th scope="col">Loja</th>
                                            <th scope="col">Perfil</th>
                                            <th scope="col">Time</th>
                                            <th scope="col">Usuário</th>
                                            <th scope="col">Ações</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(rule, index ) in this.flow_rules">
                                            <td>{{ rule.id }}</td>
                                            <td>{{ rule.order}}</td>
                                            <td>{{ rule.name}}</td>
                                            <td>{{ rule.trigger_label}}</td>
                                            <td>{{ rule.trigger_rule_label}}</td>
                                            <td>{{ rule.use_network_config? rule.flow.network.config.price_lowering_rules :rule.trigger_value }}</td>
                                            <td>{{ rule.department.name }}</td>
                                            <td>{{ rule.store? rule.store.name: "Fim de curso" }}</td>
                                            <td>{{ rule.role? rule.role.name : "Fim de curso" }}</td>
                                            <td>{{ rule.team? rule.team.name : "Fim de curso" }}</td>
                                            <td>
                                                <span class="badge badge-primary" v-for="user in rule.user">{{ user.name}} - {{ user.email}}</span>
                                               </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm  btn-default" @click="editFlowRule(index, rule)"><i class="fas fa-edit"></i> Editar</button>
                                                    <button class="btn btn-sm  btn-danger" @click="deleteFlowRule(index, rule)"><i class="fas fa-trash"></i> Apagar</button>
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

            <modal v-bind:show="this.showModal" :modaltitle="'Item do fluxo'">

                <div slot="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Ordenação</label>
                                <input type="text" class="form-control" v-model="flow_rule.order" placeholder="Digite o ordenação">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" v-model="flow_rule.name" placeholder="Digite o nome">
                            </div>
                        </div>
                    </div>
                </div>
                <div slot="buttons">
                    <div class="modal-footer">
                        <button class="btn btn-success" v-if="!editingFlowRule" @click="storeFlowRule">
                            <i class="fas fa-check"></i> Salvar
                        </button>
                        <button class="btn btn-success" v-else @click="updateFlowRule(this.flow_rule)">
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
import {VueEditor} from "vue2-editor";

export default {

    name: "FlowPage.vue",
    props: ['user', 'network', 'flow'],
    components: {
        vSelect, VueEditor
    },
    data() {
        return {
            isLoading: true,
            showModal: false,
            editingFlowRule: false,
            showModalShow:false,

            showHours: false,
            showDailyWeekend: false,
            showDailyMouth: false,

            flow_rules: [],
            flow_rule: {
                flow_id: null,
                order: null,
                name: null,
            },


        }
    },

    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            this.isLoading = true;
            try {
                console.log(this.flow);
                let url = `/api/v1/flow_rules?flow_id=${this.flow.id}`;

                axios.get(url)
                    .catch(error => {
                        Swal.fire("Opps", error.data.toString(), 'error');
                    })
                    .then(response => {
                        this.flow_rules = response.data.data;
                    });
            } catch (e) {
                Swal.fire('OOOpppss', e.toString(), 'error');
            }
            this.isLoading = false;
        },
        createFlowRule() {

            this.flow_rule={
                flow_id: this.flow.id,
                order: null,
                name: null,
            };

            this.showModal = true;
            this.editingFlowRule = false;
        },
        storeFlowRule(){
            this.showModal = false;
            let url = `/api/v1/flow_rules`;
            axios.post(url, this.flow_rule)
                .then(response=>{
                    this.flow_rules.push(response.data.data);
                    let timerInterval;
                    Swal.fire({
                        title: "Sucesso",
                        html: response.data.message,
                        timer: 800,
                        timerProgressBar: true,
                        position: 'top-end',
                        showClass: {
                            flowup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            flowup: 'animate__animated animate__fadeOutUp'
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

                            this.showModal = false;
                        }
                    })

                }).catch(error=>{
                this.isLoading=false;
                Swal.fire("Opps", error.toString(), 'error');
            });
        },

        editFlowRule(flow_rule){
            this.showModal = true;
            this.editingFlowRule = true;
            this.flow_rule = flow_rule;
        },
        updateFlowRule(flow_rule){
            this.showModal = false;
            this.showModalEdit = false;
            this.isLoading = true;
            let url = `/api/v1/flow_rule/${flow_rule.id}`;
            axios.put(url, flow_rule)
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

                        }
                    })

                }).catch(error=> {

                Swal.fire("Opps", error.toString(), 'error');
            });

            this.isLoading = false;

        },
        deleteFlowRule(index, flow_rule){
            Swal.fire({
                title: 'Você tem certeza que gostaria de apagar esse registro?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Apagar`,
                denyButtonText: `Não apagar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = `/api/v1/flow_rule/${flow.id}`;
                    axios.delete(url, flow_rule)
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
                                    this.flow_rule.splice(index, 1);
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
        toggleModal() {
            this.showModal = !this.showModal;
            this.showModalEdit = !this.showModalEdit;
        },
        handleOpen() {
            console.log('Modal is about to open.');
        },
        handleClose() {
            this.showModal = false
            this.showModalEdit = false
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

<template>

    <div class="container-fluid">
        <div class="content text-center" v-if="isLoading">
            <i class="fas fa-spin fa-sync-alt"></i>
        </div>
        <div class="content" v-else>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Listagem de Pops</h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button class="btn btn-tool" @click="createPop"> <i class="fas fa-plus"></i> Adicionar novo</button>
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

                                            <th scope="col">Fluxo de dados</th>
                                            <th scope="col">Código</th>
                                            <th scope="col">Setor</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Agendamento</th>
                                            <th scope="col">Situação</th>
                                            <th scope="col">Ações</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(pop, index ) in this.pops">
                                            <td><a :href="`flows`">{{ pop.flow.name}}</a></td>
                                            <td>{{ pop.code}}</td>
                                            <td>{{ pop.sector}}</td>
                                            <td>{{ pop.name}}</td>
                                            <td> {{ fullSchedule(pop) }}</td>
                                            <td>
                                                <span class="badge badge-success" v-if="pop.status == true">Ativo</span>
                                                <span class="badge badge-danger" v-else>Inativo</span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-default" @click="showPop(pop)"><i class="fas fa-eye"></i> Ver</button>
                                                    <button class="btn btn-sm btn-default" @click="editPop(pop)"><i class="fas fa-edit"></i> Editar</button>
                                                    <button class="btn btn-sm  btn-danger" @click="deletePop(index, pop)"><i class="fas fa-trash"></i> Apagar</button>
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
            <!--modal de create e edit-->
            <modal v-bind:show="this.showModal" :modaltitle="'POP'">

                <div slot="content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Rede</label>
                                <select class="form-control" v-model="pop.network_id">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option v-for="network in this.network" v-bind:value="network.id">
                                        {{ network.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Código</label>
                                <input type="text" class="form-control" v-model="pop.code" placeholder="Digite o código">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Setor</label>
                                <input type="text" class="form-control" v-model="pop.sector" placeholder="Digite o setor">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" v-model="pop.name" placeholder="Digite o nome">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Objetivo</label>
                                <vue-editor v-model="pop.target" useCustomImageHandler @imageAdded="handleImageAdded"
                                            class="vue-editor" placeholder="Digite o objetivo"></vue-editor>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Referência</label>
                                <vue-editor v-model="pop.references" useCustomImageHandler @imageAdded="handleImageAdded"
                                            class="vue-editor" placeholder="Digite a referência"></vue-editor>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Material Necessário</label>
                                <vue-editor v-model="pop.material" useCustomImageHandler @imageAdded="handleImageAdded"
                                            class="vue-editor" placeholder="Digite o material necessário"></vue-editor>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Descrição</label>
                                <vue-editor v-model="pop.description" useCustomImageHandler @imageAdded="handleImageAdded"
                                            class="vue-editor" placeholder="Digite a descrição"></vue-editor>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Perfis</label>
                                <select class="form-control" v-model="pop.roles_id" multiple="multiple">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option v-for="role in this.roles" v-bind:value="role.id">
                                        {{ role.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Departamentos</label>
                                <select class="form-control" v-model="pop.departments_id" multiple="multiple">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option v-for="department in this.departments" v-bind:value="department.id">
                                        {{ department.code }} - {{ department.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Lojas</label>
                                <select class="form-control" v-model="pop.stores_id" multiple="multiple">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option v-for="store in this.stores" v-bind:value="store.id">
                                        {{ store.code }} - {{ store.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Situação</label>
                                <select class="form-control" v-model="pop.status">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option value="0">INATIVO</option>
                                    <option value="1">ATIVO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Agendamento</label>
                                <select @change="changeSchedule(pop.schedule)" class="form-control" v-model="pop.schedule">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option v-for="schedule in this.schedules" v-bind:value="schedule.id">
                                        {{ schedule.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4" v-if="showDailyWeekend">
                            <div class="form-group">
                                <label class="form-label">Dias da Semana</label>
                                <select class="form-control" v-model="pop.day">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option v-for="dailyWeekend in this.dailyWeekends" v-bind:value="dailyWeekend.id">
                                        {{ dailyWeekend.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="showDailyMouth">
                            <div class="form-group">
                                <label class="form-label">Dias do Mês</label>
                                <select class="form-control" v-model="pop.day">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option v-for="n in 30" v-bind:value="n">
                                        {{ n }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="showHours">
                            <div class="form-group">
                                <label class="form-label">Horário</label>
                                <input class="form-control" type="time" v-model="pop.hour" placeholder="Selecione um horário">
                            </div>
                        </div>


                    </div>
                </div>
                <div slot="buttons">
                    <div class="modal-footer">
                        <button class="btn btn-success" v-if="!editingPop" @click="storePop">
                            <i class="fas fa-check"></i> Salvar
                        </button>
                        <button class="btn btn-success" v-else @click="updatePop(pop)">
                            <i class="fas fa-check"></i> Atualizar
                        </button>
                        <button type="button" class="btn btn-secondary" @click="showModal = false">Fechar</button>

                    </div>
                </div>
            </modal>
            <!--modal de show-->
            <modal v-bind:show="this.showModalShow" :modaltitle="'POP'">

                <div slot="content">
                    <div class="row m-3">
                        <div class="col-md-4">
                            <img src="/img/muffato/logo-muffato.png" alt="Logo" class="img-fluid">
                        </div>
                        <div class="col-md-8">
                            <h2><strong>PROCEDIMENTO OPERACIONAL PADRÃO</strong></h2>
                        </div>
                    </div>
                    <div class="row m-3">

                        <div class="col-md-12">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Nome:</button>
                                <button class="btn btn-default btn-xs"> {{this.popShow.name}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Código:</button>
                                <button class="btn btn-default btn-xs"> {{this.popShow.code}}</button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Setor:</button>
                                <button class="btn btn-default btn-xs"> {{this.popShow.sector}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Objetivo:</button>

                            </div>
                            <div v-html="this.popShow.target"></div>
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Executantes: </button>
                                <button class="btn btn-default btn-xs" v-for="role in this.popShow.roles">
                                    {{role.name}}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Lojas :</button>

                            </div>

                            <ul class="list-group">
                                <li class="list-group-item-personal" v-for="store in this.popShow.stores">
                                    {{store.name}}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Departamentos :</button>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item-personal" v-for="department in this.popShow.departments">
                                    {{department.name}}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Referências :</button>
                            </div>
                            <div v-html="this.popShow.references"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Material Necessário :</button>
                            </div>
                            <div v-html="this.popShow.material"></div>
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Descrição :</button>
                            </div>
                            <div v-html="this.popShow.description"></div>
                        </div>

                    </div>
                    <div class="row m-3">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Tarefas:</button>
                            </div>
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item" v-for="task in this.popShow.tasks">
                                    <a href="#" class="nav-link">
                                        {{task.description}}
                                    </a>
                                </li>

                            </ul>

                        </div>
                    </div>


                </div>
                <div slot="buttons">
                    <div class="modal-footer">
                        <a v-bind:href="`operationstandarttasks?pop=${this.popShow.id}`" class="btn btn-default btn-sm">Ver tarefas</a>
                        <button type="button" class="btn btn-secondary btn-sm" @click="showModalShow = false">Fechar</button>

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

    name: "PopPage.vue",
    props: ['user', 'network'],
    components: {
        vSelect, VueEditor
    },
    data() {
        return {
            isLoading: true,
            showModal: false,
            editingPop: false,
            showModalShow:false,

            showHours: false,
            showDailyWeekend: false,
            showDailyMouth: false,

            pops: [],
            schedules: [
                {
                    "id": "everyMinute",
                    "name": "A cada minuto"
                },
                {
                    "id": "everyTwoMinutes",
                    "name": "A cada dois minutos"
                },
                {
                    "id": "everyThreeMinutes",
                    "name": "A cada tres minutos"
                },
                {
                    "id": "everyFourMinutes",
                    "name": "A cada quatro minutos"
                },
                {
                    "id": "everyFiveMinutes",
                    "name": "A cada cinco minutos"
                },
                {
                    "id": "everyTenMinutes",
                    "name": "A cada dez minutos"
                },
                {
                    "id": "everyFifteenMinutes",
                    "name": "A cada quinze minutos"
                },
                {
                    "id": "everyThirtyMinutes",
                    "name": "A cada trinta minutos"
                },
                {
                    "id": "hourly",
                    "name": "A cada hora"
                },
                {
                    "id": "hourlyAt",
                    "name": "A cada hora(hora)"
                },
                {
                    "id": "everyTwoHours",
                    "name": "A cada duas horas"
                },
                {
                    "id": "everyThreeHours",
                    "name": "A cada tres horas"
                },
                {
                    "id": "everyFourHours",
                    "name": "A cada quatro horas"
                },
                {
                    "id": "everySixHours",
                    "name": "A cada seis horas"
                },
                {
                    "id": "daily",
                    "name": "Diaramente"
                },
                {
                    "id": "dailyAt",
                    "name": "Diaramente às:(hora) "
                },
                {
                    "id": "weekly",
                    "name": "Semanalmente no domingo as 00:00h "
                },
                {
                    "id": "weeklyOn",
                    "name": "Semanalmente às: (dia da semana) às (hora)"
                },
                {
                    "id": "monthly",
                    "name": "Mensalmente no primeiro dia do mês as 00:00h"
                },
                {
                    "id": "monthlyOn",
                    "name": "Mensalmente às: (dia da mês) às (hora)"
                },
                {
                    "id": "lastDayOfMonth",
                    "name": "Último dia do mês as (hora)"
                },
                {
                    "id": "yearly",
                    "name": "Anualmente"
                },
            ],
            dailyWeekends: [
                {id:0,name:"DOMINGO"},
                {id:1,name:"SEGUNDA-FEIRA"},
                {id:2,name:"TERÇA-FEIRA"},
                {id:3,name:"QUARTA-FEIRA"},
                {id:4,name:"QUINTA-FEIRA"},
                {id:5,name:"SEXTA-FEIRA"},
                {id:6,name:"SÁBADO"},
            ],

            departments:[],
            roles:[],
            stores:[],
            pop: {
                network_id: "",
                code: null,
                sector: null,
                name: null,
                target: null,
                references: null,
                description:null,
                material: null,
                schedule: "",
                day: null,
                time: null,
                status: "",
                roles_id:[],
                departments_id:[],
                stores_id:[],
            },
            popShow:{
                network: null,
                code: null,
                sector: null,
                name: null,
                target: null,
                references: null,
                description:null,
                material: null,
                schedule: null,
                day: null,
                time: null,
                status: null,
                roles:[],
                departments:[],
                stores:[],
            }

        }
    },

    mounted() {
        this.getData();
        this.getStores();
        this.getDepartments();
        this.getRoles();

    },
    methods: {
        handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {
            console.log(file, Editor);

            var formData = new FormData();
            formData.append("image", file);

            axios({
                url: "https://fakeapi.yoursite.com/images",
                method: "POST",
                data: formData
            })
                .then(result => {
                    let url = result.data.url; // Get url from response
                    Editor.insertEmbed(cursorLocation, "image", url);
                    resetUploader();
                })
                .catch(err => {
                    console.log(err);
                });
        },
        fullSchedule: function (pop) {


            let schedule = this.schedules.filter(item =>
            {
                return item.id === pop.schedule
            });
            var dayHour = '';
            switch (pop.schedule){
                case 'hourlyAt'|| 'dailyAt':
                    dayHour = "às "+ pop.time
                    break;
                case 'weeklyOn':
                    dayHour = "no(a) "+pop.day +" às "+ pop.time
                    break;
                case 'monthlyOn':
                    dayHour = "no dia: "+pop.day +" às "+ pop.time
                    break;
                default:
                    dayHour = "";

                    break
            }
            return schedule[0].name + dayHour;
        },
        changeSchedule(value){
            switch (value){
                case 'dailyAt':
                    //liberar o horario
                    this.showHours = true
                    break;
                case 'hourlyAt':
                    //liberar o horario
                    this.showHours = true
                    break;
                case 'weeklyOn':
                    //liberar o dia da semana e horario
                    this.showHours = true
                    this.showDailyWeekend=true
                    this.showDailyMouth=false
                    break;
                case 'monthlyOn':
                    //liberar o dia do mes e  horario
                    this.showHours = true
                    this.showDailyWeekend=false
                    this.showDailyMouth=true
                    break;
                default:
                    this.showHours = false;
                    this.showDailyWeekend=false
                    this.showDailyMouth=false
                    break;
            }
        },
        getData() {
            this.isLoading = true;
            try {
                let url = `/api/v1/operationstandart?user_id=${this.user.id}`;

                axios.get(url)
                    .catch(error => {
                        Swal.fire("Opps", error.data.toString(), 'error');
                    })
                    .then(response => {
                        this.pops = response.data.data;
                    });
            } catch (e) {
                Swal.fire('OOOpppss', e.toString(), 'error');
            }
            this.isLoading = false;
        },
        createPop() {
            this.showModal = true;
            this.editingPop = false;
        },
        showPop(pop){

            console.log(pop);
            this.showModalShow = true;
            this.popShow = pop;
        },
        storePop(){
            this.showModal = false;
            let url = `/api/v1/operationstandart`;
            axios.post(url, this.pop)
                .then(response=>{
                    this.pops.push(response.data.data);
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
                            this.getData();
                            this.showModal = false;
                            this.pop = {
                                network_id: "",
                                code: null,
                                sector: null,
                                name: null,
                                target: null,
                                references: null,
                                description:null,
                                material: null,
                                schedule: "",
                                day: null,
                                time: null,
                                status: "",
                                roles_id:[],
                                departments_id:[],
                                stores_id:[],
                            };
                        }
                    })

                }).catch(error=>{
                this.isLoading=false;
                Swal.fire("Opps", error.toString(), 'error');
            });
        },

        editPop(pop){
            this.showModal = true;
            this.editingPop = true;
            this.pop = pop;
            this.pop.roles_id=pop.roles.map((role)=>{return role.id;});
            this.pop.departments_id=pop.departments.map((department)=>{return department.id;});
            this.pop.stores_id=pop.stores.map((store)=>{return store.id;});
        },
        updatePop(pop){
            this.showModal = false;
            this.showModalEdit = false;
            this.isLoading = true;
            let url = `/api/v1/operationstandart/${pop.id}`;
            axios.put(url, pop)
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
                            this.pop = {
                                network_id: "",
                                code: null,
                                sector: null,
                                name: null,
                                target: null,
                                references: null,
                                description:null,
                                material: null,
                                schedule: "",
                                day: null,
                                time: null,
                                status: "",
                                roles_id:[],
                                departments_id:[],
                                stores_id:[],
                            };
                        }
                    })

                }).catch(error=> {

                Swal.fire("Opps", error.toString(), 'error');
            });

            this.isLoading = false;

        },
        deletePop(index, pop){


            Swal.fire({
                title: 'Você tem certeza que gostaria de apagar esse registro?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Apagar`,
                denyButtonText: `Não apagar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = `/api/v1/operationstandart/${pop.id}`;
                    axios.delete(url, pop)
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
                                    this.pops.splice(index, 1);
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
        getRoles(){

            try {
                let url = `/api/v1/roles`;

                axios.get(url)
                    .catch(error => {
                        Swal.fire("Opps", error.data.toString(), 'error');
                    })
                    .then(response => {
                        this.roles = response.data.data;
                    });
            } catch (e) {
                Swal.fire('OOOpppss', e.toString(), 'error');
            }

        },
        getDepartments(){
            try {
                let url = `/api/v1/departments`;

                axios.get(url)
                    .catch(error => {
                        Swal.fire("Opps", error.data.toString(), 'error');
                    })
                    .then(response => {
                        this.departments = response.data.data;
                    });
            } catch (e) {
                Swal.fire('OOOpppss', e.toString(), 'error');
            }
        },
        getStores(){
            try {
                let url = `/api/v1/stores?network_id=${this.network[0].id}`;

                axios.get(url)
                    .catch(error => {
                        Swal.fire("Opps", error.data.toString(), 'error');
                    })
                    .then(response => {
                        this.stores = response.data.data;
                    });
            } catch (e) {
                Swal.fire('OOOpppss', e.toString(), 'error');
            }
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
.list-group-item-personal{
    position: relative;
    display: block;
    padding: 0.45rem 0.55rem;
    background-color: #ffffff;
    border: 1px solid rgba(0, 0, 0, 0.125);
    text-align: center;
    font-weight: bold;
    font-size: 12pt;
}
</style>

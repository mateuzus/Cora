<template>

    <div class="container-fluid">
        <div class="content text-center" v-if="isLoading">
            <i class="fas fa-spin fa-sync-alt"></i>
        </div>
        <div class="content" v-else>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Listagem de Rotinas</h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button class="btn btn-tool" @click="createRoutine"> <i class="fas fa-plus"></i> Adicionar novo</button>
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
                                            <th scope="col">Agendamento</th>
                                            <th scope="col">Situação</th>
                                            <th scope="col">Ações</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(routine, index ) in this.routines">

                                            <td>{{ routine.id}}</td>
                                            <td>{{ routine.name}}</td>
                                            <td> {{ fullSchedule(routine) }}</td>
                                            <td>
                                                <span class="badge badge-success" v-if="routine.status == true">Ativo</span>
                                                <span class="badge badge-danger" v-else>Inativo</span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-default" @click="showRoutine(routine)"><i class="fas fa-eye"></i> Ver</button>
                                                    <button class="btn btn-sm btn-default" @click="editRoutine(routine)"><i class="fas fa-edit"></i> Editar</button>
                                                    <button class="btn btn-sm  btn-danger" @click="deleteRoutine(index, routine)"><i class="fas fa-trash"></i> Apagar</button>
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
            <modal v-bind:show="this.showModal" :modaltitle="'Rotina'">

                <div slot="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Rede</label>
                                <select class="form-control" v-model="routine.network_id">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option v-for="network in this.network" v-bind:value="network.id">
                                        {{ network.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" v-model="routine.name" placeholder="Digite o nome">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Descrição</label>
                                <vue-editor v-model="routine.description" useCustomImageHandler @imageAdded="handleImageAdded"
                                            class="vue-editor" placeholder="Digite a descrição"></vue-editor>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Perfis</label>
                                <select class="form-control" v-model="routine.roles_id" multiple="multiple">
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
                                <select class="form-control" v-model="routine.departments_id" multiple="multiple">
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
                                <select class="form-control" v-model="routine.stores_id" multiple="multiple">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option v-for="store in this.stores" v-bind:value="store.id">
                                        {{ store.code }} - {{ store.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Situação</label>
                                <select class="form-control" v-model="routine.status">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option value="0">INATIVO</option>
                                    <option value="1">ATIVO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Agendamento</label>
                                <select @change="changeSchedule(routine.schedule)" class="form-control" v-model="routine.schedule">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option v-for="schedule in this.schedules" v-bind:value="schedule.id">
                                        {{ schedule.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6" v-if="showDailyWeekend">
                            <div class="form-group">
                                <label class="form-label">Dias da Semana</label>
                                <select class="form-control" v-model="routine.day">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option v-for="dailyWeekend in this.dailyWeekends" v-bind:value="dailyWeekend.id">
                                        {{ dailyWeekend.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="showDailyMouth">
                            <div class="form-group">
                                <label class="form-label">Dias do Mês</label>
                                <select class="form-control" v-model="routine.day">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option v-for="n in 30" v-bind:value="n">
                                        {{ n }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" v-if="showHours">
                            <div class="form-group">
                                <label class="form-label">Horário</label>
                                <input class="form-control" type="time" v-model="routine.hour" placeholder="Selecione um horário">
                            </div>
                        </div>


                    </div>
                </div>
                <div slot="buttons">
                    <div class="modal-footer">
                        <button class="btn btn-success" v-if="!editingRoutine" @click="storeRoutine">
                            <i class="fas fa-check"></i> Salvar
                        </button>
                        <button class="btn btn-success" v-else @click="updateRoutine(routine)">
                            <i class="fas fa-check"></i> Atualizar
                        </button>
                        <button type="button" class="btn btn-secondary" @click="showModal = false">Fechar</button>

                    </div>
                </div>
            </modal>
            <!--modal de show-->
            <modal v-bind:show="this.showModalShow" :modaltitle="'Rotinas'">

                <div slot="content">
                    <div class="row m-3">
                        <div class="col-md-4">
                            <img src="/img/muffato/logo-muffato.png" alt="Logo" class="img-fluid">
                        </div>
                        <div class="col-md-8">
                            <h2><strong>Rotina</strong></h2>
                        </div>
                    </div>
                    <div class="row m-3">

                        <div class="col-md-12">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Nome:</button>
                                <button class="btn btn-default btn-xs"> {{this.routineShow.name}}</button>
                            </div>
                        </div>
                    </div>

                    <div class="row m-3">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Executantes: </button>
                                <button class="btn btn-default btn-xs" v-for="role in this.routineShow.roles">
                                    {{role.name}}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Lojas :</button>
                                <button class="btn btn-default btn-xs" v-for="store in this.routineShow.stores">
                                    {{store.name}}
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Departamentos :</button>
                                <button class="btn btn-default btn-xs" v-for="department in this.routineShow.departments">
                                    {{department.name}}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Descrição :</button>
                            </div>
                            <div v-html="this.routineShow.description"></div>
                        </div>

                    </div>
                    <div class="row m-3">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <button class="btn bg-cyan btn-xs">Tarefas:</button>
                            </div>
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item" v-for="task in this.routineShow.tasks">
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
                        <a v-bind:href="`routinetasks?routine=${this.routineShow.id}`" class="btn btn-default btn-sm">Ver tarefas</a>
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

    name: "RoutinePage.vue",
    props: ['user', 'network'],
    components: {
        vSelect,VueEditor
    },
    data() {
        return {
            isLoading: true,
            showModal: false,
            editingRoutine: false,
            showModalShow:false,

            showHours: false,
            showDailyWeekend: false,
            showDailyMouth: false,

            routines: [],
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
            routine: {
                network_id: "",
                name: null,
                description: null,
                schedule: "",
                day: null,
                time: null,
                status: "",
                roles_id:[],
                departments_id:[],
                stores_id:[],
            },
            routineShow:{
                networks: null,
                name: null,
                description: null,
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

        this.getStores();
        this.getDepartments();
        this.getRoles();
        this.getData();
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
        fullSchedule: function (routine) {


            let schedule = this.schedules.filter(item =>
            {
                return item.id === routine.schedule
            });
            var dayHour = '';
            switch (routine.schedule){
                case 'hourlyAt'|| 'dailyAt':
                    dayHour = "às "+ routine.time
                    break;
                case 'weeklyOn':
                    dayHour = "no(a) "+routine.day +" às "+ routine.time
                    break;
                case 'monthlyOn':
                    dayHour = "no dia: "+routine.day +" às "+ routine.time
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
                let url = `/api/v1/routine`;

                axios.get(url)
                    .catch(error => {
                        Swal.fire("Opps", error.data.toString(), 'error');
                    })
                    .then(response => {
                        this.routines = response.data.data;
                    });
            } catch (e) {
                Swal.fire('OOOpppss', e.toString(), 'error');
            }
            this.isLoading = false;
        },
        createRoutine() {
            this.showModal = true;
            this.editingRoutine = false;
        },
        showRoutine(routine){

            console.log(routine);
            this.showModalShow = true;
            this.routineShow = routine;
        },
        storeRoutine(){
            this.showModal = false;
            let url = `/api/v1/routine`;
            axios.post(url, this.routine)
                .then(response=>{
                    this.routines.push(response.data.data);
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
                            this.routine = {
                                network_id: "",
                                name: null,
                                schedule: "",
                                day: null,
                                time: null,
                                status: "",
                                roles_id:[],
                                departments_id:[],
                                stores_id:[],
                            };
                            this.getData();
                            this.showModal = false;
                        }
                    })

                }).catch(error=>{
                this.isLoading=false;
                Swal.fire("Opps", error.toString(), 'error');
            });
        },

        editRoutine(routine){
            console.log(routine);
            this.showModal = true;
            this.editingRoutine = true;
            this.routine = routine;
            this.routine.roles_id=routine.roles.map((role)=>{return role.id;});
            this.routine.departments_id=routine.departments.map((department)=>{return department.id;});
            this.routine.stores_id=routine.stores.map((store)=>{return store.id;});
        },
        updateRoutine(routine){
            this.showModal = false;
            this.showModalEdit = false;
            this.isLoading = true;
            let url = `/api/v1/routine/${routine.id}`;
            axios.put(url, routine)
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
                            this.routine = {
                                network_id: "",
                                name: null,
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
        deleteRoutine(index, routine){


            Swal.fire({
                title: 'Você tem certeza que gostaria de apagar esse registro?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Apagar`,
                denyButtonText: `Não apagar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = `/api/v1/routine/${routine.id}`;
                    axios.delete(url, routine)
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
                                    this.routines.splice(index, 1);
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
</style>

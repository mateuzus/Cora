<template>
    <div class="container-fluid">
        <div class="content text-center" v-if="isLoading">
            <i class="fas fa-spin fa-sync-alt"></i>
        </div>
        <div class="content" v-else>
            <div class="row">
                <dashboard-card :value="this.dados.lists.total" :icon="'fas fa-list'"
                                :title="'Total de listas da rede'"></dashboard-card>
                <dashboard-card :value="this.dados.lists.not_finalized" :icon="'fas fa-check'"
                                :title="'Total de listas respondidas'"></dashboard-card>
                <dashboard-card :value="this.dados.lists.finished" :icon="'fas fa-times'"
                                :title="'Total de listas à responder'"></dashboard-card>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4 mt-2">
                    <dashboard-info-box :color="'bg-light-blue'" :icon="'fas fa-laugh'" :title="'Op. da rede'"
                                        :value="this.dados.operators.total_of_users"></dashboard-info-box>
                    <dashboard-info-box :color="'bg-info'" :icon="'fas fa-meh'" :title="'Op. que responderam'"
                                        :value="this.dados.operators.users_who_responded"></dashboard-info-box>
                    <dashboard-info-box :color="'bg-danger'" :icon="'fas fa-frown'" :title="'Op. que não responderam'"
                                        :value="this.dados.operators.users_who_didnt_responded"></dashboard-info-box>


                </div>
                <div class="col-md-4" style="min-height: 100%">
                    <div class="card bg-light-blue h-100">
                        <div class="card-header border-0" style="cursor: move;">

                            <h3 class="card-title">
                                <i class="far fa-calendar-alt"></i>
                                Efetividade
                            </h3>


                        </div>

                        <div class="card-body pt-0">

                            <div class="info-card-effectiveness" style="width: 100%">
                                {{ calcEffectiveness }} %
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <dashboard-info-box :color="'bg-light-blue'" :icon="'fas fa-laugh'"
                                        :title="'Total de perguntas do dia de hoje'"
                                        :value="this.dados.questions.total_questions"></dashboard-info-box>
                    <dashboard-info-box :color="'bg-info'" :icon="'fas fa-meh'"
                                        :title="'Total de perguntas respondidas'"
                                        :value="this.dados.questions.total_questions_answered"></dashboard-info-box>
                    <dashboard-info-box :color="'bg-danger'" :icon="'fas fa-frown'"
                                        :title="'Total de perguntas não respondidas'"
                                        :value="this.dados.questions.total_unanswered_questions"></dashboard-info-box>


                </div>

            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"> Relatório Listas por grupo</h5>
                        </div>
                        <div class="card-body">
                            <GChart
                                type="ColumnChart"
                                :data="chartListingsByRole"
                                :options="chartOptionsEffectiveness"
                            />

                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"> Relatório Perguntas por grupo</h5>
                        </div>
                        <div class="card-body">
                            <GChart
                                type="ColumnChart"
                                :data="chartQuestionsByRole"
                                :options="chartOptionsEffectiveness"
                            />

                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"> Efetividade 7 dias</h5>
                        </div>
                        <div class="card-body">
                            <GChart
                                type="ColumnChart"
                                :data="chartEffetivenessSevenDays"
                                :options="chartOptionsEffectiveness"
                            />

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"> Efetividade 90 dias</h5>
                        </div>
                        <div class="card-body">
                            <GChart
                                type="ColumnChart"
                                :data="chartEffetivenessNinetenDays"
                                :options="chartOptionsEffectiveness"
                            />

                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Usuário</th>
                                    <th>Listas Criadas</th>
                                    <th>Listas Não Respondidas</th>
                                    <th>Listas Respondidas</th>
                                    <th>Listas Finalizadas</th>
                                    <th>Efetivadade 7 dias(%)</th>
                                    <th>Efetivadade 90 dias(%)</th>
                                    <th>Tendência</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="user in this.topUsers">
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.qtd_lists }}</td>
                                    <td>{{ user.qtd_unanswered_list }}</td>
                                    <td>{{ user.qtd_answered_list }}</td>
                                    <td>{{ user.qtd_not_finalized }}</td>
                                    <td>{{ user.effectives_seven_day }}</td>
                                    <td>{{ user.effectives_nineteen_day }}</td>
                                    <td>
                                        <i class="fas fa-thumbs-up text-success" v-if="user.trend ==='up'"></i>
                                        <i class="fas fa-thumbs-down text-danger" v-if="user.trend ==='down'"></i>
                                        <i class="fas fa-equals text-indigo" v-if="user.trend ==='equal'"></i>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DashboardCard from "./DashboardCard";
import DashboardInfoBox from "./DashboardInfoBox";
import {GChart} from 'vue-google-charts';

export default {
    name: "DashboardManager",
    components: {DashboardInfoBox, DashboardCard, GChart},
    props: ['user', 'token'],
    data() {
        return {
            isLoading: true,
            chartOptionsByRole:{
                title: `Relório por Grupo de Usuário`,
                colors: ['#4682b4', '#778899', '#008080'],
            },
            chartOptionsEffectiveness:{
                seriesType: 'bars',
                legend: {position: 'bottom'},
                vAxes: {
                    0:{
                        viewWindow: {
                            min: 0,
                        },
                    },

                },
                series: {
                    2: {
                        type: 'line',
                        curveType: 'function',
                        ticks:[0,100],
                        viewWindow: {
                            min: 0,
                        },
                    }
                },
                colors: ['#4682b4', '#778899', '#008080'],
                animation:{
                    duration:50,
                },
                chartArea: {
                    left: 40,
                    right: 30,
                    bottom: 30,
                    top: 10,
                }
            },
            dados: {
                "lists": {
                    "not_started": null,
                    "initiates": null,
                    "finished": null,
                    "finalized_but_not_complete": null,
                    "not_finalized": null,
                    "total": null,
                },
                "operators": {
                    "total_of_users": 0,
                    "users_who_didnt_responded": 0,
                    "users_who_responded": 0
                },
                "questions": {
                    'total_unanswered_questions': 0,
                    'total_questions_answered': 0,
                    'total_questions': 0,
                },
                "total_per_user": {
                    "listings": [],
                    "questions": []
                },
                "total_per_user_last_7_days": {
                    "total": {}
                },
                "total_per_user_last_90_days": {
                    "total": {}
                }
            },
        }
    },
    computed: {
        calcEffectiveness: function () {
            if(this.dados.operators.total_of_users == 0){
                return 0;
            }
            return ((this.dados.operators.users_who_responded / this.dados.operators.total_of_users) * 100).toLocaleString()
        },
        chartListingsByRole: function () {
            var data=[] ;
            data.push(["Nome", "Qtd de Listas", "Qtd de Respondidas","% de concluídas"]);
            this.dados.total_per_user.listings.map(function (role) {
                data.push([
                    role.name,
                    role.qtd_list,
                    role.qtd_answered_list,
                    role.qtd_list === 0 ?  0 :((role.qtd_answered_list / role.qtd_list)* 100),
                ])
            })


            return data;
        },
        chartQuestionsByRole: function () {
            var data=[] ;
            data.push(["Nome", "Qtd de Perguntas", "Qtd de Respondidas","% de concluídas"]);
            this.dados.total_per_user.questions.map(function (role) {
                data.push([
                    role.name,
                    role.qtd_questions,
                    role.qtd_answered_questions,
                    ((role.qtd_answered_questions / role.qtd_questions) * 100),
                ]);
            })


            return data;
        },
        chartEffetivenessSevenDays: function () {
            var data=[] ;
            data.push(["Data","Total","Finalizadas", "Efetividade"]);
            this.dados.total_per_user_last_7_days.map(function (effectiveness) {
                data.push([
                    effectiveness.date,
                    effectiveness.qtd_list,
                    effectiveness.qtd_unanswered_list,
                    ((effectiveness.qtd_unanswered_list / effectiveness.qtd_list)* 100),
                ]);
            })


            return data;
        },
        chartEffetivenessNinetenDays: function () {
            var data=[] ;
            data.push(["Data","Total","Finalizadas", "Efetividade"]);
            this.dados.total_per_user_last_90_days.map(function (effectiveness) {
                data.push([
                    effectiveness.date,
                    effectiveness.qtd_list,
                    effectiveness.qtd_unanswered_list,
                    ((effectiveness.qtd_unanswered_list / effectiveness.qtd_list)* 100),
                ]);
            })


            return data;
        },
        topUsers: function (){
            var data=[] ;

            this.dados.top_users.map(function (users) {

                var trend = 'equal';
                if(users.effectives_seven_day > users.effectives_nineteen_day){
                    trend = 'up';
                }
                if(users.effectives_seven_day < users.effectives_nineteen_day){
                    trend = 'down';
                }

                data.push({
                    name: users.name,
                    qtd_lists: users.qtd_lists,
                    qtd_unanswered_list: users.qtd_unanswered_list,
                    qtd_answered_list: users.qtd_answered_list,
                    qtd_not_finalized: users.qtd_not_finalized,
                    effectives_seven_day: users.effectives_seven_day,
                    effectives_nineteen_day: users.effectives_nineteen_day,
                    trend: trend,
                });
            })
            return data
        }
    },
    mounted() {
        this.getData();


    },
    methods: {
        getData() {
            this.isLoading = true;
            try {
                let url = `/api/v1/dashboard?user_id=${this.user.id}`;
                axios.get(url)
                    .catch(error => {
                        Swal.fire("Opps", error.data.toString(), 'error');
                    })
                    .then(response => {
                        console.log(response);
                        this.dados = response.data;
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            } catch (e) {
                Swal.fire('OOOpppss', e.toString(), 'error');
            }

        },


    }
}
</script>

<style scoped>
.info-card-effectiveness {
    font-size: 50pt;
    text-align: center;
    position: absolute;
    transform: translate(-50%, -50%);
    top: 50%;
    left: 50%;
}
</style>

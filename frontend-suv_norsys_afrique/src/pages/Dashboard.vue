<template>
  <div>
    <div class="row">
      <div class="col-md-3">
        <stats-card>
          <div class="icon-big text-center" slot="header" :class="`icon-${user.type}`">
            <i :class="user.icon"></i></div>
          <div class="numbers" slot="content">
            <p>{{user.title}}</p>
            {{nbUsers}}
          </div>
          <div class="stats row" slot="footer">
            <div class="col-md-6">
              <i :class="user.footerIcon"></i>
            </div>
            <div class="col-md-6 text-right">
              <router-link :to="{path:'/utilisateurs'}" style="color: #424141">
                {{user.footerText}}
              </router-link>
            </div>
          </div>
        </stats-card>
      </div>
      <div class="col-md-3">
        <stats-card>
          <div class="icon-big text-center" slot="header" :class="`icon-${client.type}`">
            <i :class="client.icon"></i></div>
          <div class="numbers" slot="content">
            <p>{{client.title}}</p>
            {{nbClients}}
          </div>
          <div class="stats row" slot="footer">
            <div class="col-md-6">
              <i :class="client.footerIcon"></i>
            </div>
            <div class="col-md-6 text-right">
              <router-link :to="{path:'/clientvisiteur'}" style="color: #424141">
                {{client.footerText}}
              </router-link>
            </div>
          </div>
        </stats-card>
      </div>
      <div class="col-md-3">
        <stats-card>
          <div class="icon-big text-center" slot="header" :class="`icon-${event.type}`">
            <i :class="event.icon"></i></div>
          <div class="numbers" slot="content">
            <p>{{event.title}}</p>
            {{nbEvents}}
          </div>
          <div class="stats row" slot="footer">
            <div class="col-md-6">
              <i :class="event.footerIcon"></i>
            </div>
            <div class="col-md-6 text-right">
              <router-link :to="{path:'/event'}" style="color: #424141">
                {{event.footerText}}
              </router-link>
            </div>
          </div>
        </stats-card>
      </div>
      <div class="col-md-3">
        <stats-card>
          <div class="icon-big text-center" slot="header" :class="`icon-${activite.type}`">
            <i :class="activite.icon"></i></div>
          <div class="numbers" slot="content">
            <p>{{activite.title}}</p>
            {{nbActivities}}
          </div>
          <div class="stats row" slot="footer">
            <div class="col-md-6">
              <i :class="activite.footerIcon"></i>
            </div>
            <div class="col-md-6 text-right">
              <router-link :to="{path:'/activites'}" style="color: #424141">
                {{activite.footerText}}
              </router-link>
            </div>
          </div>
        </stats-card>
      </div>
    </div>

    <!--Charts-->
    <div class="row">
      <div class="col-12">
      </div>
      <div class="col-md-6 col-12">
        <card>
          <pie-chart :chart-data="chart1Data" :width="330" :height="310"></pie-chart>
          <div slot="default">
            <i class="fa fa-circle text-info"></i> Campus
            <i class="fa fa-circle text-warning"></i> Visite Client
          </div>
          <div slot="header">
            <h4 class="card-title">Nombre des événements</h4>
            <p class="card-category">le pourcentage des événements selon le type</p>
          </div>
          <span slot="footer" class="stats">
            <i class="ti-list"></i>
            <router-link :to="{path:'/event'}" style="color: #676363">
              Voir la liste des événements
            </router-link>
            </span>
        </card>
      </div>
      <div class="col-md-6 col-12">
        <card>
          <bar-chart :chart-data="chart2Data" :width="330" :height="310"></bar-chart>
          <div slot="default">
            <i class="fa fa-circle text-info"></i> Hotel
            <i class="fa fa-circle text-success"></i> Restaurant
            <i class="fa fa-circle text-danger"></i> Transport
          </div>
          <div slot="header">
            <h4 class="card-title">Hotel / Restaurant / Transport</h4>
            <p class="card-category">Nombre d'Hotel, Restaurant et Transport</p>
          </div>
          <span slot="footer" class="stats">
            <div class="d-flex align-items-center">
              <div class="col">
                <span>
                   <i class="ti-list"></i>
                     <router-link :to="{path:'/hotels'}" style="color: #676363">
                       Voir Hotel
                    </router-link>
                </span>
                </div>
              <div class="col">
                <span>
                     <i class="ti-list"></i>
                     <router-link :to="{path:'/restaurant'}" style="color: #676363">
                        Voir Restaurant
                     </router-link>
                </span>
              </div>
              <div class="col">
              <span>
                <i class="ti-list"></i>
                  <router-link :to="{path:'/transport'}" style="color: #676363">
                   Voir Transport
                   </router-link>
              </span>
              </div>
            </div>
            </span>
        </card>
      </div>
      <div class="col-md-12">
        <chart-card title="Événements par mois"
                    sub-title="Nombre d'événements par mois"
                    :chart-data="activityChart.data"
                    :chart-options="activityChart.options"
                    chart-type="Bar"
        >
          <span slot="footer">
            <i class="ti-list"></i>
            <router-link :to="{path:'/event'}" style="color: #676363">
              Voir la liste des événements
            </router-link>
          </span>
          <div slot="legend">
            <i class="fa fa-circle text-info"></i> événments Campus
            <i class="fa fa-circle text-warning"></i> événments Visite Client
          </div>
        </chart-card>
      </div>
    </div>
  </div>
</template>
<script>
import { StatsCard, ChartCard } from "@/components/index";
import axios from "axios";
import PieChart from "../components/PieChart";
import BarChart from "@/components/BarChart";
var mois1 = [];var mois2 = [];
var tab1=[];var tab2=[]; var key;
export default {
  components: {
    StatsCard,
    ChartCard,
    PieChart,
    BarChart
  },
  beforeCreate() {
    if (localStorage.getItem("token") == null) {
      this.$router.push("/login");
    }
  },
  mounted() {
    this.fillData();
    this.fillData2();
    this.getEventbyMonth();
    this.getUtilisateurs();
    this.getEvenements();
    this.getActivities();
    this.getClients();
  },
  methods: {
    fillData() {
      axios
        .get("/evenement/list")
        .then((response) => {
          this.loaded = true;
          this.campus = 0;
          this.visiteClient=0;
          for (let i=0;i<response.data.length;i++){
            if (response.data[i].Type.nom === 'campus'){
              this.campus =  this.campus + 1;
            }
            else if (response.data[i].Type.nom === 'VisteClient'){
              this.visiteClient=  this.visiteClient + 1;
            }
          }
          let num1 = ((this.campus)/(this.campus+this.visiteClient))*100
          let num2 = ((this.visiteClient)/(this.campus+this.visiteClient))*100

          this.chart1Data = {
            labels: ["Campus", "VisiteClient"],
            datasets: [
              {
                backgroundColor: ["#3091B2","#ffc107"],
                data: [num1.toFixed(2),num2.toFixed(2)],
              },
            ],
          };
        })
        .catch((error) => {
          console.error(error);
        });
    },
    fillData2() {
      let one = "/hotels"
      let two = "/restaurant"
      let three = "/transport/liste"

      const requestOne = axios.get(one);
      const requestTwo = axios.get(two);
      const requestThree = axios.get(three);

      axios.all([requestOne, requestTwo, requestThree]).then(axios.spread((...responses) => {
        const responseOne = responses[0].data.length
        const responseTwo = responses[1].data.length
        const responseThree = responses[2].data.length
        this.chart2Data = {
          labels: ["Hotel", "Restaurant","Transport"],
          datasets: [
            {
              backgroundColor: ["#17a2b8","#28a745","#dc3545"],
              data: [responseOne,responseTwo,responseThree],
            },
          ],
        };
      })).catch(errors => {
        console.error(error);
      })
    },
    getUtilisateurs() {
      axios.get('/utilisateurs').then((response) => {
        this.utilisateurs = response.data
        this.nbUsers = this.utilisateurs.length
      })
    },
    getEvenements() {
      axios.get('/evenement/list').then((response) => {
        this.evenements = response.data
        this.nbEvents = this.evenements.length
      })
    },
    getEventbyMonth(){
      axios.get('/evenement/list').then((response) => {
        this.evenements = response.data
        for (let i=0;i<this.evenements.length;i++){
          if (this.evenements[i].Type.nom === 'campus'){
            mois1.push(new Date(this.evenements[i].date).getMonth());
          }
          else if (this.evenements[i].Type.nom === 'VisteClient'){
            mois2.push(new Date(this.evenements[i].date).getMonth());
          }
        }
        if (tab1.length === 0 || tab2.length === 0){
          for(key of mois1){
            if ( tab1[key]){
              tab1[key]+=1;
            }else tab1[key]=1;
          }
          for(key of mois2){
            if ( tab2[key]){
              tab2[key]+=1;
            }else tab2[key]=1;
          }
        }
        window.dispatchEvent(new Event('resize'))
      })
    },
    getActivities() {
      axios.get('/activites').then((response) => {
        this.activities = response.data
        this.nbActivities = this.activities.length
      })
    },
    getClients() {
      axios.get('clientvisiteur/liste').then((response) => {
        this.clients = response.data
        this.nbClients =  this.clients.length
      })
    }
  },
  computed: {
    getcampus: {
      get: function () {
        return this.campus;
      },
      getvisiteClient: {
        get: function () {
          return this.visiteClient;
        },
      },
    },
  },
  data() {
    var months = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
    return {
      data: [1.2],
      chart1Data: {},
      chart2Data: {},
      loaded: false,
      campus:0,
      visiteClient:0,
      clients:[],
      activities: [],
      evenements: [],
      utilisateurs: [],
      tab1:{},tab2:{},
      nbUsers: "",
      nbEvents: "",
      nbActivities: "",
      nbClients: "",
      user: {
        title: "Nombre des Collaborateurs",
        icon: "ti-user",
        type: "success",
        footerText: "Voir la liste",
        footerIcon: "ti-list"
      },
      event: {
        title: "Nombre des événements",
        icon: "ti-calendar",
        type: "warning",
        footerText: "Voir la liste",
        footerIcon: "ti-list"
      },
      activite: {
        title: "Nombre des activités",
        icon: "ti-medall",
        type: "info",
        footerText: "Voir la liste",
        footerIcon: "ti-list"
      },
      client: {
        title: "Nombre des clients",
        icon: "ti-stats-up",
        type: "danger",
        footerText: "Voir la liste",
        footerIcon: "ti-list"
      },
      activityChart: {
        data: {
          labels: months,
          series: [tab1,tab2]
        },
        options: {
          seriesBarDistance: 10,
          axisX: {
            showGrid: false,
            offset: 20
          },
          axisY:{
            onlyInteger:true
          },
          height: "245px"
        }
      },
      activityUser: {
        data: {
          labels: [
            "activité XXX",
            "activité YYY",
            "activité ZZZ"
          ],
          series: [
            [2, 2 , 3]
          ]
        },
        options: {
          seriesBarDistance: 10,
          axisX: {
            showGrid: false
          },
          axisY:{
            onlyInteger:true
          },
          height: "245px",
        }
      },
    };
  }
};
</script>

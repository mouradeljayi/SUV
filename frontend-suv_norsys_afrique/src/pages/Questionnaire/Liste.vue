<template>
  <div class="row">
    <div class="col-12">
      <card>
        <div v-for="(activite, index) in activites" v-bind:key="activite.id">
          <div v-show="index === questionIndex" id="wrapper">
            <div class="row">
              <div class="col-md-6">
                <h3>Questionnaire de sonadage</h3>
                <b-card-body class="card-body"><h5>Activité:  <b>{{ activite.nom }}</b></h5></b-card-body>
                <b-card-body class="card-body"><h5>Montant : <b>{{ activite.montant }} Dh</b></h5></b-card-body>
                <b-card-body class="card-body"><h5>Cotisation salarie : <b>{{ activite.cotisationParSalarie }} Dh</b></h5></b-card-body>
                <b-card-body class="card-body"><h5>Cotisation entreprise : <b>{{ activite.cotisationEntreprise }} Dh</b></h5></b-card-body>
              </div>
              <div class="col-md-6 my-auto">
                <div v-for="answer in items" v-bind:key="answer.id" class="form-check">
                  <input class="form-check-input" type="radio"
                         :value="answer.value"
                         :name="index"
                         v-model="responses[index]">
                  <label class="form-check-label customlabel">
                    <strong>{{answer.message}}</strong>
                  </label>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <p-button type="warning"
                        round
                        v-if="questionIndex > 0"
                        @click.native.prevent="prev"
                        class="ml-3"
              >Retour
              </p-button>
              <p-button type="success"
                        round
                        @click.native.prevent="next"
                        class="ml-4"
              >Suivant
              </p-button>
            </div>
          </div>
        </div>
        <div v-show="questionIndex === activites.length">
          <div class="row">
            <div class="col-md-12 text-center">
              <h1>Merci pour votre vote</h1>
            </div>
            <div class="col-md-12 text-center">
              <p-button type="info"
                        round
                        @click.native.prevent="envoyerVote"
              >Envoyer
              </p-button>
            </div>
          </div>
        </div>
      </card>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import NotificationTemplate from "@/pages/Notifications/NotificationTemplate";
import jwtDecode from "jwt-decode";

export default {
  data() {
    let act = [];
    let rpns = [];
    let ques = [];
    return {
      rpns,
      act,
      ques,
      activites: [],
      titres: [],
      questionnaires: [],
      items: [{ message: 'Oui', value: true }, { message: 'Non', value: false }],
      questionIndex: 0,
      responses: [],
      errors: [],
      error: '',
      check : true,

    };
  },
  methods:{

    prev() {
      this.questionIndex--;
    },

    next() {
      if (this.responses[this.questionIndex] === undefined) {
        this.errors[this.questionIndex] = 1;
        this.$notify({
          group: 'notifications',
          title: 'Veuillez choisir une réponse',
          type: 'danger',
          template: NotificationTemplate,
          duration: 5000,
          horizontalAlign: 'center',
          verticalAlign: 'top'
        });
      }
      else {
        this.errors[this.questionIndex] = 0;
        this.questionIndex++;
      }
    },

    listTitreQuestionnaire() {
      axios.get("/titre/questionnaire").then(response => {
        this.titres = response.data;
      });
    },

    listActivities() {
      axios.get("/activites").then(response => {
        this.activites = response.data;
      });
    },

    listQuestionnaire() {
      axios.get("/questionnairelist").then(response => {
        this.questionnaires = response.data;
      });
    },

    envoyerVote(){
      if (this.check===true) {
        for(let i=0; i<this.activites.length; i++) {
          this.rpns.push(this.responses[i]);
          this.act.push(this.activites[i]);
          this.ques.push(this.questionnaires[i]);
          const authentication = jwtDecode(localStorage.getItem('token'));
          const resultat = {
            utilisateur: authentication.username,
            activite: this.act[i].id,
            vote: this.rpns[i],
            questionnaire: this.act[i]
          };
          axios.post('/result/ajouter', resultat)
        }
        this.check = false
      }
      this.$notify({
        group: 'notifications',
        title: 'Votre vote a été envoyé',
        type: 'success',
        template: NotificationTemplate,
        duration: 5000,
        horizontalAlign: 'center',
        verticalAlign: 'top'
      });
    }
  },

  mounted() {
    this.listActivities();
    this.listQuestionnaire();
    this.listTitreQuestionnaire();
  }
};
</script>
<style>
.customlabel{
  margin-left: 12px;
}
</style>

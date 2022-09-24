<template>
  <div class="row">
    <div class="col-12">
      <card>
        <div v-for="(pac, index) in pacs" v-bind:key="pac.id">
          <div v-show="index === questionIndex" id="wrapper">
            <div class="row">
              <div class="col-md-12">
                <h3>Questionnaire de confirmation</h3>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <b-card-body class="card-body"><h5>Activité:  <b>{{ pac.activite.nom }}</b></h5></b-card-body>
                <b-card-body class="card-body"><h5>Montant : <b>{{ pac.activite.montant }} Dh</b></h5></b-card-body>
                <b-card-body class="card-body"><h5>Cotisation salarie : <b>{{ pac.activite.cotisationParSalarie }} Dh</b></h5></b-card-body>
                <b-card-body class="card-body"><h5>Cotisation entreprise : <b>{{ pac.activite.cotisationEntreprise }} Dh</b></h5></b-card-body>
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
        <div v-show="questionIndex === pacs.length">
          <div class="row">
            <div class="col-md-12 text-center">
              <h2>Merci pour votre vote</h2>
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
import NotificationTemplate from "@/pages/Notifications/NotificationTemplate";
import axios from "axios";
import jwtDecode from "jwt-decode";

export default {
  data() {
    let act = [];
    let rpns = [];
    return {
      rpns,
      act,
      pacs: [],
      items: [{ message: 'Oui', value: true }, { message: 'Non', value: false }],
      questionIndex: 0,
      responses: [],
      errors: [],
      check : true
    }
  },
  mounted() {
    this.getPacs()
  },
  methods: {
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
    getPacs() {
      axios.get('/pac/liste').then((response) => {
        this.pacs = response.data
      })
    },
    envoyerVote() {
      if (this.check===true) {
        for(let i=0; i<this.pacs.length; i++){
        this.rpns.push(this.responses[i]);
        this.act.push(this.pacs[i]);
        const authentication = jwtDecode(localStorage.getItem('token'));
        if(this.rpns[i] === true){
          const resultat = {
            utilisateur: authentication.username,
            pac: this.act[i].id,
            vote: this.rpns[i],
          };
          axios.post('finalresult/ajouter', resultat)
        }
        }
      }
      this.check = false
      this.$notify({
        group: 'notifications',
        title: 'Votre confirmation a été envoyé',
        type: 'success',
        template: NotificationTemplate,
        duration: 5000,
        horizontalAlign: 'center',
        verticalAlign: 'top'
      });
    },
  },
}
</script>

<style scoped>

</style>

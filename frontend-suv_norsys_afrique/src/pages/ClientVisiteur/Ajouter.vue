<template>
  <card class="card" title="Ajouter Client Visiteur">
    <div>
      <form @submit.prevent="ajouterClientVisiteur">
        <div class="row">
          <div class="col-md-6">
            <fg-input type="text"
                      label="Nom"
                      placeholder="nom"
                      v-model="clientVisiteur.nom">
            </fg-input>
          </div>
          <div class="col-md-6">
            <fg-input type="text"
                      label="prenom"
                      placeholder="prenom"
                      v-model="clientVisiteur.prenom">
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <label>Evenements</label>
            <multiselect :options="evenements"
                         placeholder="choisissez evenements"
                         deselect-label="Entrez pour evenements"
                         select-label="Entrez pour evenements"
                         label="nom"
                         v-bind:key="clientVisiteur.evenement.id"
                         v-model="clientVisiteur.evenement"
            >
            </multiselect>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p-button type="success"
                      round
                      native-type="submit">
              Ajouter
            </p-button>
          </div>
        </div>
        <div class="clearfix"></div>
      </form>
    </div>
  </card>
</template>

<script>
import axios from "axios";
import Notification from "@/pages/Notifications/NotificationTemplate";
import Multiselect from 'vue-multiselect'
import Vue from 'vue'
import NotificationTemplate from "@/pages/Notifications/NotificationTemplate";

Vue.component('multiselect', Multiselect)

export default {
  data() {
    return {
      evenements: [],
      clientVisiteur: {
        nom: "",
        Prenom: "",
        evenement: ""
      }
    }
  },
  methods: {
    getEvenements() {
      axios.get('/evenement/list').then((response) => {
        this.evenements = response.data
      });
    },
    ajouterClientVisiteur() {
      const data = {
        nom: this.clientVisiteur.nom,
        prenom: this.clientVisiteur.prenom,
        evenement: this.clientVisiteur.evenement,

      }
      console.log(data)
      axios.post('/clientvisiteur/ajouter', data).then(response => {
        console.log(response.data)

      })
      this.$router.push("/clientvisiteur")
    },

  },
  mounted() {
    this.getEvenements()
  },
}
</script>

<style scoped>

</style>


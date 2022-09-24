<template>
  <card class="card" title="Modifier Client Visiteur">
    <div>
      <form @submit.prevent="modifierClientVisiteur(clientVisiteurs.id)">
        <div class="row">
          <div class="col-md-6">
            <fg-input type="text"
                      label="Nom"
                      placeholder="nom"
                      v-model="clientVisiteurs.nom">
            </fg-input>
          </div>
          <div class="col-md-6">
            <fg-input type="text"
                      label="prenom"
                      placeholder="prenom"
                      v-model="clientVisiteurs.prenom">
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
                        v-model="clientVisiteurs.Evenement"
                         v-bind:key="clientVisiteurs.Evenement.id"
            >
            </multiselect>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p-button type="success"
                      round
                      native-type="submit">
              Modifier
            </p-button>
          </div>
        </div>
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
      clientVisiteurs: ""
    };
  },
  methods: {
    getEvenements() {
      axios.get('/evenement/list').then((response) => {
        this.evenements = response.data;

      });
    },
    getClientVisiteurs(id) {
      axios.get("/clientvisiteur/afficher/" + id, id).then(response => {
        this.clientVisiteurs = response.data;
      });
    },
    modifierClientVisiteur(id) {
      const updatedClientVisiteur = {
        nom: this.clientVisiteurs.nom,
        prenom: this.clientVisiteurs.prenom,
        Evenement: this.clientVisiteurs.Evenement,

      };
      console.log(updatedClientVisiteur)
      axios.put("/clientvisiteur/modifier/" + this.clientVisiteurs.id, updatedClientVisiteur).then(response => {
        this.$notify({
          title: 'client visiteur modifiée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        });
        this.$router.push("/clientvisiteur");
      })
    }
  },
  mounted() {
    this.getClientVisiteurs(this.$route.params.id);
    this.getEvenements(this.$route.params.id)
  },
}
</script>

<style scoped>

</style>

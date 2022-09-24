<template>
  <card class="card" title="Modifier une activité">
    <div>
      <form @submit.prevent="modifierActivite(activite.id)">
        <div class="row">
          <div class="col-md-8">
            <fg-input type="text"
                      label="Nom de l'activité"
                      placeholder="Nom de l'activité"
                      v-bind:value="activite.nom"
                      v-model="activite.nom">
            </fg-input>
          </div>
          <div class="col-md-6">
            <label>Responsable</label>
            <multiselect :options="utilisateurs"
                         placeholder="choisissez responsable"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         label="nom"
                         v-bind:key="activite.responsableEtude"
                         v-model="activite.responsableEtude"
            >
            </multiselect>
          </div>
          <div class="col-md-6">
            <label>Evenement</label>
            <multiselect :options="evenements"
                         placeholder="choisissez Evenement"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         label="nom"
                         v-bind:key="activite.evenement.id"
                         v-model="activite.evenement"
            >
            </multiselect>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <fg-input type="number"
                      label="Cotisation"
                      placeholder="Cotisation"
                      v-bind:value="activite.cotisation"
                      v-model="activite.cotisation">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="number"
                      label="Cotisation Entreprise"
                      placeholder="Cotisation/Employé"
                      v-bind:value="activite.cotisationEntreprise"
                      v-model="activite.cotisationEntreprise">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="number"
                      label="Cotisation/Salarie"
                      placeholder="Cotisation/Salarie"
                      v-bind:value="activite.cotisationParSalarie"
                      v-model="activite.cotisationParSalarie">
            </fg-input>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <fg-input type="datetime-local"
                      label="Date"
                      placeholder="Date"
                      v-model="activite.date">
            </fg-input>
          </div>
          <div class="col-md-5">
            <fg-input type="number"
                      label="participant"
                      placeholder="Participant"
                      v-model="activite.participant">
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <fg-input type="number"
                      label="Montant"
                      placeholder="Montant"
                      v-bind:value="activite.montant"
                      v-model="activite.montant">
            </fg-input>
          </div>
          <div class="col-md-6">
            <fg-input type="text"
                      label="Detail Montant"
                      placeholder="Montant/Employé"
                      v-bind:value="activite.detailMontant"
                      v-model="activite.detailMontant">
            </fg-input>
          </div>
          <div class="col-md-3">
            <fg-input type="number"
                      label="Prix Global par Salarie"
                      placeholder="Prix Global/Salarie"
                      v-bind:value="activite.prixGlobalParSalarie"
                      v-model="activite.prixGlobalParSalarie">
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label>Description</label>
            <textarea rows="5" class="form-control"
                      placeholder="Description"
                      v-model="activite.description">
              </textarea>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-3">
            <div class="center_buttons">
              <p-button type="success"
                        native-type="submit">
                Modifier
              </p-button>
              <p-button type="danger"
                        native-type="reset">
                Réinitialiser
              </p-button>
            </div>
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
      utilisateurs: [],
      evenements: [],
      activite: "",
    };
  },
  methods: {
    getUtilisateurs() {
      axios.get('/utilisateurs').then((response) => {
        this.utilisateurs = response.data
      });
    },
    getEvenements() {
      axios.get('/evenement/list').then((response) => {
        this.evenements = response.data
      });
    },
    getActivities(id) {
      axios.get("activites/afficher/" + id, id).then(response => {
        this.activite = response.data;
      });

    },
    modifierActivite() {
      const updatedActivite = {
        nom: this.activite.nom,
        description: this.activite.description,
        date: this.activite.date,
        cotisation: this.activite.cotisation,
        montant: this.activite.montant,
        detail_montant: this.activite.detailMontant,
        cotisation_entreprise: this.activite.cotisationEntreprise,
        cotisation_par_salarie: this.activite.cotisationParSalarie,
        prixGlobalParSalarie: this.activite.prixGlobalParSalarie,
        participant: this.activite.participant,
        responsableEtude: this.activite.responsableEtude.id,
        evenement: this.activite.evenement.id
      };
      axios.put("activites/modifier/" + this.activite.id, updatedActivite).then(response => {
        this.$notify({
          title: 'Activité modifiée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',

        });
        this.$router.push("/activites");
      }).catch(error => {
        this.$notify({
          title: error.toString(),
          type: 'danger',
          template: NotificationTemplate,
          icon: 'fa fa-times',
          horizontalAlign: 'center',
        });
      });
    }
  },
  mounted() {
    this.getActivities(this.$route.params.id);
    this.getUtilisateurs(this.$route.params.id);
    this.getEvenements(this.$route.params.id);

  }
}
</script>

<style scoped>
.center_buttons{
  display: grid;
  grid-auto-flow: column;
  grid-gap: 10px;
}
</style>

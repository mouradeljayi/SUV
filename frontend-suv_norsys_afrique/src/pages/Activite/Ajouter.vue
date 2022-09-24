<template>
  <card class="card" title="Ajouter une activité">
    <div>
      <form @submit.prevent="ajouterActivite">

        <div class="row">
          <div class="col-md-8">
            <fg-input type="text"
                      label="Nom de l'activité"
                      placeholder="Nom de l'activité"
                      v-model="activite.nom">
            </fg-input>
          </div>
          <div class="col-md-6">
            <label>Responsable</label>
            <multiselect :options="utilisateurs"
                         placeholder="choisissez responsable"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         label="prenom"
                         v-bind:key="activite.responsable_etude.id"
                         v-model="activite.responsable_etude"
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
                      v-model="activite.cotisation">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="number"
                      label="Cotisation Entreprise"
                      placeholder="Cotisation/Employé"
                      v-model="activite.cotisation_entreprise">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="number"
                      label="Cotisation/Salarie"
                      placeholder="Cotisation/Salarie"
                      v-model="activite.cotisation_par_salarie">
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
                      placeholder="participant"
                      v-model="activite.participant">
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <fg-input type="number"
                      label="Montant"
                      placeholder="Montant"
                      v-model="activite.montant">
            </fg-input>
          </div>
          <div class="col-md-6">
            <fg-input type="text"
                      label="Détail Montant"
                      placeholder="Détail Montant"
                      v-model="activite.detail_montant">
            </fg-input>
          </div>
          <div class="col-md-3">
            <fg-input type="number"
                      label="Prix Global par Salarie"
                      placeholder="Prix Global/Salarie"
                      v-model="activite.prix_globale_par_salarie">
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
                Ajouter
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
      activite: {
        nom: "",
        description: "",
        date: "",
        cotisation: null,
        montant: null,
        detail_montant: "",
        cotisation_entreprise: null,
        cotisation_par_salarie: null,
        prix_globale_par_salarie: null,
        participant: null,
        responsable_etude: "",
        evenement: ""
      }
    };
  },
  mounted() {
    this.getUtilisateurs()
    this.getEvenements()
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
    ajouterActivite() {
        const activite_data = {
          nom: this.activite.nom,
          description: this.activite.description,
          date: this.activite.date,
          cotisation: this.activite.cotisation,
          montant: this.activite.montant,
          detail_montant: this.activite.detail_montant,
          cotisation_entreprise: this.activite.cotisation_entreprise,
          cotisation_par_salarie: this.activite.cotisation_par_salarie,
          prix_globale_par_salarie: this.activite.prix_globale_par_salarie,
          participant: this.activite.participant,
          responsable_etude: this.activite.responsable_etude.id,
          evenement: this.activite.evenement.id
        };
      axios.post('activites/ajouter', activite_data).then(
        this.$notify({
          title: 'Activité ajoutée',
          text: 'Activité ajoutée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        }),
        this.$router.push('/activites')
      ).catch(
        err => {
          err.toString()
          this.$notify({
            title: 'Erreur',
            text: 'Erreur lors de l\'ajout de l\'activité',
            type: 'error',
            template: NotificationTemplate,
            icon: 'fa fa-times'
        });
    });
    },
  },
}
</script>

<style scoped>
.center_buttons{
  display: grid;
  grid-auto-flow: column;
  grid-gap: 10px;
}
</style>

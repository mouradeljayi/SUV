@<template>
  <card class="card" title="Modifier Evenement">
    <div>
      <form @submit.prevent="modifierEvenement(evenement.id)">
        <div class="row">
          <div class="col-md-6">
            <fg-input type="text"
                      label="Nom evenement"
                      placeholder="Nom"
                      v-model="evenement.nom">
            </fg-input>
          </div>
         <div class="col-md-6">
            <label>Type d'événement</label>
            <multiselect :options="typeEvenement"
                        placeholder="choisissez le type d'événement"
                        deselect-label="Entrez pour supprimer"
                        select-label="Entrez pour sélectionner"
                        label="nom"
                        v-bind:key="evenement.Type.id"
                        v-model="evenement.Type">
            </multiselect>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <fg-input type="date"
                      label="Date de début de l'événement"
                      v-model="date"
                      required>
            </fg-input>
          </div>
          <div class="col-md-3">
            <fg-input type="date"
                      label="Date de fin de l'événement"
                      v-model="date_fin"
                      required>
            </fg-input>
          </div>
          <div class="col-md-6">
            <label>Status</label>
            <multiselect :options="statusEvenement"
                        placeholder="choisissez le status d'événement"
                        deselect-label="Entrez pour supprimer"
                        select-label="Entrez pour sélectionner"
                        label="nom"
                        v-bind:key="evenement.status.id"
                        v-model="evenement.status">
            </multiselect>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label>Description</label>
            <textarea class="form-control"
                      v-model="evenement.description"
                      placeholder="Donnez une description sur l'événement"
                      required>
        </textarea>
          </div>
        </div>
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
        <div class="clearfix"></div>
      </form>
    </div>
  </card>
</template>

<script>
import axios from "axios";
import NotificationTemplate from "../Notifications/NotificationTemplate";
import Multiselect from 'vue-multiselect'
import Vue from 'vue'
import { mutations } from "../../store"
Vue.component('multiselect', Multiselect)
export default {
  data() {
    return {
      typeEvenement: [],
      statusEvenement: [],
      evenement: "",
      date: "",
      date_fin: ""
    };
  },
  methods: {
    getStatus() {
      axios.get('type/status').then((response) => {
        this.statusEvenement = response.data
      })
    },
    getType() {
      axios.get('typeevenement/liste').then((response) => {
        this.typeEvenement = response.data
      })
    },
    getEvenement(id) {
      axios.get("/evenement/afficher/" + id, id).then(response => {
        this.evenement = response.data;
        this.date = mutations.formatDate(new Date(this.evenement.date))
        this.date_fin = mutations.formatDate(new Date(this.evenement.dateFinEvenement))
      });
    },
    modifierEvenement(id) {
      const updatedEvenement = {
        nom: this.evenement.nom,
        Type: this.evenement.Type.id,
        date: this.date,
        date_fin_evenement: this.date_fin,
        status: this.evenement.status,
        description: this.evenement.description
      };
      axios.put("/evenement/modifier/" + this.evenement.id, updatedEvenement).then(response => {
        this.$notify({
          title: 'Evenement modifiée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        });
        this.$router.push("/event");
      })
    }
  },
  mounted() {
    this.getEvenement(this.$route.params.id);
    this.getStatus()
    this.getType()
  }
}
</script>

<style scoped>
</style>

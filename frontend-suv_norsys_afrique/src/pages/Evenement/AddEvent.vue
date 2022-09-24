<template>
  <card>
    <div class="text-center">
      <div class="text-left">
        <h3>Création d'évévement</h3>
        <br><br>
      </div>
      <form @submit.prevent="ajouterEvenement">
        <div class="row">
          <div class="col-md-6">
            <fg-input type="text"
                      label="Nom Événement"
                      placeholder="Donnez le nom d'événement"
                      v-model="evenement.nom"
                      aria-required="true"
                      required
            >
            </fg-input>
          </div>
          <div class="col-md-6">
            <label>type d'événement</label>
            <multiselect v-model="evenement.type"
                         :options="options"
                         placeholder="choisissez le type d'événement"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         v-bind:key="evenement.type.id"
                         label="nom"
            >
            </multiselect>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <fg-input type="date"
                      label="Date de début de l'événement"
                      v-model="evenement.date"
                      required
            >
            </fg-input>
          </div>
          <div class="col-md-3">
            <fg-input type="date"
                      label="Date de fin de l'événement"
                      v-model="evenement.date_fin_evenement"
                      required
            >
            </fg-input>
          </div>
          <div class="col-md-6">
            <label>Status</label>
            <multiselect v-model="evenement.status"
                         :options="stOptions"
                         placeholder="choisissez le status d'événement"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         label="nom"
                         v-bind:key="evenement.status.id"
            >
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
        <div class="center">
          <div class="row">
            <div class="col-md-6">
              <p-button type="secondary"
                        round
                        @click.native.prevent="annuler">
                Annuler
              </p-button>
            </div>
            <div class="col-md-6">
              <p-button type="success"
                        round
                        native-type="submit"
              >
                Ajouter l'événement
              </p-button>
            </div>
          </div>
        </div>
      </form>
      <br>
      <div class="center">
      </div>
    </div>
  </card>
</template>
<script>
import axios from "axios";
import Multiselect from 'vue-multiselect'
import Vue from 'vue'
import { store, mutations } from "../../store";
Vue.component('multiselect', Multiselect)
export default {
  data() {
    return{
      options: [],
      stOptions: [],
      value: "",
      evenement: {
        nom: "",
        description: "",
        date: "",
        date_fin_evenement: "",
        status: "",
        type: ""
      }
    }
  },
  mounted() {
    this.getStatus()
    this.getType()
  },
  created() {
    this.evenement.date = mutations.formatDate(store.dates.date)
    this.evenement.date_fin_evenement = mutations.formatDate(store.dates.date_fin)
  },
  methods:{
    getStatus() {
      axios.get('type/status').then((response) => {
        this.stOptions = response.data
      })
    },
    getType() {
      axios.get('typeevenement/liste').then((response) => {
        this.options = response.data
      })
    },
    annuler() {
      this.$router.push({path: '/event'});
    },
    ajouterEvenement() {
      axios.post("evenement/create", this.evenement)
        .then((response) => {
        })
      if (this.evenement.type.nom === 'Visite Client'){
        this.$router.push({path: '/clientvisiteur/'});
      } else{
        this.$router.push({path: '/userchoice'});
      }
    },
  }
}
</script>
<template>
  <card class="card" title="Modifier Table planning d'événement">
    <div>
      <form @submit.prevent="modifierVisiteClient(visitClients.id)">
        <div class="row">
          <div class="col-md-6">
            <label>Evenements</label>
            <multiselect :options="evenements"
                         placeholder="choisissez evenements"
                         deselect-label="Entrez pour evenements"
                         select-label="Entrez pour evenements"
                         label="nom"
                         v-bind:key="visitClients.evenement.id"
                         v-model="visitClients.evenement"
            >
            </multiselect>
          </div>
          <div class="col-md-6">
            <label>Transports</label>
            <multiselect :options="transports"
                         placeholder="choisissez Transport"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         label="nom"
                         v-bind:key="visitClients.transport.id"
                         v-model="visitClients.transport"
            >
            </multiselect>
          </div>
          <div class="col-md-6">
            <label>Restaurants</label>
            <multiselect :options="restaurants"
                         placeholder="choisissez Transport"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         label="nom"
                         v-bind:key="visitClients.restaurant.id"
                         v-model="visitClients.restaurant"
            >
            </multiselect>
          </div>
          <div class="col-md-6">
            <label>Hotels</label>
            <multiselect :options="hotels"
                         placeholder="choisissez Transport"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         label="nom"
                         v-bind:key="visitClients.hotel.id"
                         v-model="visitClients.hotel"
            >
            </multiselect>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <fg-input type="text"
                      label="Jour"
                      placeholder="Jour"
                      v-model="visitClients.Jour">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="text"
                      label="Heure"
                      placeholder="heure"
                      v-model="visitClients.heure">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="number"
                      label="Nombre De Pax"
                      placeholder="nombredepax"
                      v-model="visitClients.nombreDePax">
            </fg-input>
          </div>
          <div class="col-md-12">
            <label>Programme De Jour</label>
            <textarea rows="5" class="form-control"
                      placeholder="Programme De Jour"
                      v-model="visitClients.programmeDeJour">
              </textarea>
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
      transports: [],
      restaurants: [],
      hotels: [],
      evenements: [],
      visitClients: ""
    };
  },
  methods: {
    getEvenements() {
      axios.get('/evenement/list').then((response) => {
        this.evenements = response.data;
      });
    },
    getTransports() {
      axios.get('/transport/liste').then((response) => {
        this.transports = response.data
      });
    },
    getRestaurants() {
      axios.get('/restaurant').then((response) => {
        this.restaurants = response.data
      });
    },
    getHotels() {
      axios.get('/hotels').then((response) => {
        this.hotels = response.data
      });
    },
    getVisiteClients(id) {
      axios.get("/visiteclient/afficher/" + id, id).then(response => {
        this.visitClients = response.data;
      });
    },
    modifierVisiteClient(id) {
      const updatedVisiteClient = {
        Jour: this.visitClients.Jour,
        programmeDeJour: this.visitClients.programmeDeJour,
        heure: this.visitClients.heure,
        nombreDePax: this.visitClients.nombreDePax,
        transport: this.visitClients.transport,
        restaurant: this.visitClients.restaurant,
        hotel: this.visitClients.hotel,
        evenement: this.visitClients.evenement.id,
      };
      axios.put("/visiteclient/modifier/" + this.visitClients.id, updatedVisiteClient).then(response => {
        this.$notify({
          title: 'visite client modifiée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        });
        this.$router.push("/visiteclient");
      })
    }
  },
  mounted() {
    this.getVisiteClients(this.$route.params.id);
    this.getTransports(this.$route.params.id)
    this.getRestaurants(this.$route.params.id)
    this.getHotels(this.$route.params.id)
    this.getEvenements(this.$route.params.id)
  }
}
</script>
<style scoped>
</style>

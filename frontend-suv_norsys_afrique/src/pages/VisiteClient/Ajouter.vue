<template>
  <card class="card" title="Ajouter Table planning d'événement">
    <div>
      <form @submit.prevent="ajouterVisiteClient">
        <div class="row">
          <div class="col-md-6">
            <label>Evenements</label>
            <multiselect :options="evenements"
                         placeholder="choisissez evenements"
                         select-label="Entrez evenements"
                         label="nom"
                         v-bind:key="visiteClients.evenement.id"
                         v-model="visiteClients.evenement"
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
                         v-bind:key="visiteClients.transport.id"
                         v-model="visiteClients.transport"
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
                         v-bind:key="visiteClients.restaurant.id"
                         v-model="visiteClients.restaurant"
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
                         v-bind:key="visiteClients.hotel.id"
                         v-model="visiteClients.hotel"
            >
            </multiselect>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <fg-input type="date"
                      label="Jour"
                      placeholder="Jour"
                      v-model="visiteClients.jour">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="time"
                      label="Heure"
                      placeholder="heure"
                      v-model="visiteClients.houre">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="number"
                      label="Nombre De Pax"
                      placeholder="nombredepax"
                      v-model="visiteClients.nombredepax">
            </fg-input>
          </div>

          <div class="col-md-12">
            <label>Programme De Jour</label>
            <textarea rows="5" class="form-control"
                      placeholder="Programme De Jour"
                      v-model="visiteClients.programmedejour">
              </textarea>
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
      transports: [],
      hotels: [],
      restaurants: [],
      evenements: [],
      visiteClients: {
        jour: "",
        Programmedejour: "",
        houre: "",
        nombredepax: null,
        transport: "",
        restaurant: "",
        hotel: "",
        evenement: "",
      }
    }
  },
  methods: {
    getEvenements() {
      axios.get('/evenement/list').then((response) => {
        this.evenements = response.data
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
    ajouterVisiteClient() {
      const data = {
        jour: this.visiteClients.jour,
        programmedejour: this.visiteClients.programmedejour,
        houre: this.visiteClients.houre,
        nombredepax: this.visiteClients.nombredepax,
        transport: this.visiteClients.transport,
        restaurant: this.visiteClients.restaurant,
        hotel: this.visiteClients.hotel,
        evenement: this.visiteClients.evenement.id,
      }
      axios.post('visiteclient/ajouter', data).then(response => {
        this.$notify({
          title: 'Visite Client ajoutée',
          text: ' Visite Client ajoutée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        })
      })
      this.$router.push("/visiteclient")
    },

  },
  mounted() {
    this.getTransports()
    this.getRestaurants()
    this.getHotels()
    this.getEvenements()
  },

}
</script>

<style scoped>

</style>

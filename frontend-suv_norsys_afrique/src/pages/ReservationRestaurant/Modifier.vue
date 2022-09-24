<template>
  <card class="card" title="Modifier une reservation">
    <div>
      <form @submit.prevent="modifierReservationRestaurant(reservationrestaurant.id)">
        <div class="row">
          <div class="col-md-12">
            <label>Evenement</label>
            <multiselect :options="events"
                         placeholder="choisissez l'evenement"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         label="nom"
                         v-bind:key="reservationrestaurant.evenement.id"
                         v-model="reservationrestaurant.evenement">
            </multiselect>
          </div>
          <div class="col-md-6">
            <fg-input type="datetime-local"
                      label="Date"
                      placeholder="Date"
                      v-bind:value="reservationrestaurant.dateEntree"
                      v-model="reservationrestaurant.dateEntree">
            </fg-input>
          </div>
          <div class="col-md-6">
            <fg-input type="number"
                      label="Nombre de personne"
                      placeholder="Nombre de personne"
                      v-bind:value="reservationrestaurant.nbrPersonne"
                      v-model="reservationrestaurant.nbrPersonne">
            </fg-input>
          </div>
          <div class="col-md-12">
            <label>Restaurant</label>
            <multiselect :options="restaurants"
                         placeholder="choisissez restaurant"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         label="nom"
                         v-bind:key="reservationrestaurant.restaurant.id"
                         v-model="reservationrestaurant.restaurant">
            </multiselect>
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
import NotificationTemplate from "../Notifications/NotificationTemplate";
import Multiselect from 'vue-multiselect'
import Vue from 'vue'

Vue.component('multiselect', Multiselect)

export default {
  data() {
    return {
      reservationrestaurant: "",
      restaurants: [],
      events: [],
    };
  },
  methods: {
    getEvents() {
      axios
        .get('/evenement/list')
        .then((reponse) => {
          this.events = reponse.data
        })
    },
    listRestaurants() {
      axios.get("/restaurant").then(response => {
        this.restaurants = response.data;
      });
    },
    getReservationRestuarnts(id) {
      axios.get("/reservation/restaurant/" + id, id).then(response => {
        this.reservationrestaurant = response.data;
      });
    },
    modifierReservationRestaurant() {
      const updatedReservationRestaurant = {
        dateEntree: this.reservationrestaurant.dateEntree,
        nbrPersonne: this.reservationrestaurant.nbrPersonne,
        evenement: this.reservationrestaurant.evenement.id,
        restaurant: this.reservationrestaurant.restaurant,
      };
      axios.put("/reservation/restaurant/modifier/" + this.reservationrestaurant.id, updatedReservationRestaurant).then(response => {
        this.$notify({
          title: 'Reservation modifiée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',

        });
        this.$router.push("/reservation/liste");
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
    this.getReservationRestuarnts(this.$route.params.id);
    this.listRestaurants(this.$route.params.id);
    this.getEvents(this.$route.params.id);
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

<template>
  <card class="card" title="Modifier une Résérvation d'hôtel">
    <div>
      <form @submit.prevent="modifierReservation(reservationHotel.id)">
        <div class="row">
          <div class="col-md-6">
            <label>Hôtel</label>
            <multiselect :options="hotels"
                         placeholder="choisissez l'hôtel"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         label="nom"
                         v-bind:key="reservationHotel.hotel.id"
                         v-model="reservationHotel.hotel"
            >
            </multiselect>
          </div>
          <div class="col-md-6">
            <label>Chambre</label>
            <multiselect :options="chambres"
                         placeholder="choisissez le type de chambre"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         v-model="reservationHotel.chambre"
            >
            </multiselect>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label>Evenement</label>
            <multiselect :options="evenements"
                         placeholder="choisissez l'evenement"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         label="nom"
                         v-bind:key="reservationHotel.evenement.id"
                         v-model="reservationHotel.evenement"
            >
            </multiselect>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <fg-input type="number"
                      label="Nombre de Personnes"
                      placeholder="Saisissez le nombre de personnes"
                      v-model="reservationHotel.nbrPersonne">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="number"
                      label="Nombre de nuits par personne"
                      placeholder="Saisissez le nombre de nuits par personne"
                      v-model="reservationHotel.nbrNuitParPersonne">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="number"
                      label="Total de nuits"
                      placeholder="Saisissez le nombre total de nuits"
                      v-model="reservationHotel.totalNuitee"
            >
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <fg-input type="date"
                      label="Date d'entré"
                      placeholder="Date d'entré"
                      v-model="reservationHotel.dateEntree">
            </fg-input>
          </div>
          <div class="col-md-6">
            <fg-input type="date"
                      label="Date de sortie"
                      placeholder="Date de sortie"
                      v-model="reservationHotel.dateSortie">
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
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
      hotels: [],
      evenements: [],
      chambres: ['Single', 'Double'],
      reservationHotel: ""
    }
  },
  mounted() {
    this.getReservationHotel(this.$route.params.id)
    this.getHotels()
    this.getEvenements()
  },
  methods: {
    getEvenements() {
      axios.get('/evenement/list').then((reponse) => {
        this.evenements = reponse.data
        console.log(this.evenements)
      })
    },
    getHotels() {
      axios.get('/hotels').then((response) => {
        this.hotels = response.data
      })
    },
    getReservationHotel(id) {
      axios.get('reservation/hotel/afficher/' + id).then((response) => {
        this.reservationHotel = response.data
      })
    },
    modifierReservation() {
      const updatedReservationHotel = {
        chambre: this.reservationHotel.chambre,
        dateEntree: this.reservationHotel.dateEntree,
        dateSortie: this.reservationHotel.dateSortie,
        nuitParPersonne: this.reservationHotel.nbrNuitParPersonne,
        nbrPersonne: this.reservationHotel.nbrPersonne,
        totalNuitee: this.reservationHotel.totalNuitee,
        hotel: this.reservationHotel.hotel,
        evenement: this.reservationHotel.evenement.id
      };
      axios.put("/reservation/hotel/modifier/" + this.reservationHotel.id, updatedReservationHotel).then(response => {
        this.$notify({
          title: 'Réservation hôtel modifié avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        });
        this.$router.push("/reservation/liste");
      })
    }
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

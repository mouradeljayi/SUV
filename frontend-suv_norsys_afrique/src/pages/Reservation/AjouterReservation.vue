<template>
  <card class="card" title="Ajouter une Réservation">
    <div>
      <form @submit.prevent="">
        <label>Type de Réservation</label>
        <div class="row">
          <div class="col-md-12">
            <multiselect :options="types"
                         placeholder="choisissez le type de réservation"
                         deselect-label="Entrez pour supprimer"
                         select-label="Entrez pour sélectionner"
                         v-model="valeur"
                         :costum-label="showDiv($event)"
            >
            </multiselect>
          </div>
        </div>
        <div v-if="selectedValue1" >
          <form @submit.prevent="ajouterReservationHotel">
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
              <div class="col-md-12">
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
                          v-model="reservationHotel.nuitParPersonne"
                >
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
                          v-model="reservationHotel.dateEntree"
                >
                </fg-input>
              </div>
              <div class="col-md-6">
                <fg-input type="date"
                          label="Date de sortie"
                          placeholder="Date de sortie"
                          v-model="reservationHotel.dateSortie"
                >
                </fg-input>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
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
        <div v-if="selectedValue2" >
          <form @submit.prevent="ajouterReservationRestaurant">
            <div class="row">
              <div class="col-md-6">
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
              <div class="col-md-6">
                <label>Evenement</label>
                <multiselect :options="evenements"
                             placeholder="choisissez l'evenement"
                             deselect-label="Entrez pour supprimer"
                             select-label="Entrez pour sélectionner"
                             label="nom"
                             v-bind:key="reservationrestaurant.evenement.id"
                             v-model="reservationrestaurant.evenement">
                </multiselect>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <fg-input type="datetime-local"
                          label="Date"
                          placeholder="Date"
                          v-model="reservationrestaurant.date_entree">
                </fg-input>
              </div>
              <div class="col-md-6">
                <fg-input type="number"
                          label="Nombre de personne"
                          placeholder="Nombre de personne"
                          v-model="reservationrestaurant.nbr_personne">
                </fg-input>
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
        <div v-if="selectedValue3" >
          <form @submit.prevent="ajouterReservationTransport">
            <div class="row">
              <div class="col-md-6">
                <label>transports</label>
                <multiselect :options="transports"
                             placeholder="choisissez Transport"
                             deselect-label="Entrez pour supprimer"
                             select-label="Entrez pour sélectionner"
                             label="nom"
                             v-bind:key="reservationTransport.transport.id"
                             v-model="reservationTransport.transport"
                >
                </multiselect>
              </div>
              <div class="col-md-6">
                <label>Evenement</label>
                <multiselect :options="evenements"
                             placeholder="choisissez l'evenement"
                             deselect-label="Entrez pour supprimer"
                             select-label="Entrez pour sélectionner"
                             label="nom"
                             v-bind:key="reservationTransport.evenement.id"
                             v-model="reservationTransport.evenement">
                </multiselect>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <fg-input type="datetime-local"
                          label="Date"
                          placeholder="Date"
                          v-model="reservationTransport.date">
                </fg-input>
              </div>

              <div class="col-md-6">
                <fg-input type="number"
                          label="nombre Pax"
                          placeholder="Saisissez le nombre de Pax"
                          v-model="reservationTransport.nombrePax"
                >
                </fg-input>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <fg-input type="text"
                          label="lieu Depart"
                          placeholder="Saisissez le lieu de Depart"
                          v-model="reservationTransport.lieuDepart">
                </fg-input>
              </div>
              <div class="col-md-6">
                <fg-input type="text"
                          label="destination"
                          placeholder="Saisissez la destination"
                          v-model="reservationTransport.destination">
                </fg-input>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
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
      types: ["Réservation Hôtel", "Réservation Réstaurant", "Réservation Transport"],
      selectedValue1: false,
      selectedValue2: false,
      selectedValue3: false,
      valeur: '',
      evenements: [],
      hotels: [],
      restaurants: [],
      transports: [],
      chambres: ["Single", "Double"],
      reservationHotel: {
        chambre: "",
        dateEntree: "",
        dateSortie: "",
        nuitParPersonne: "",
        nbrPersonne: "",
        totalNuitee: "",
        hotel: "",
        evenement: ""
      },
      reservationrestaurant: {
        restaurant: "",
        evenement: "",
        date_entree: "",
        nbr_personne: null,
      },
      reservationTransport: {
        transport: "",
        evenement: "",
        date: "",
        lieuDepart: "",
        destination: "",
        nombrePax: null,
      }
    }
  },
  mounted() {
    this.getEvenements()
    this.getTransports();
    this.getHotels();
    this.listRestaurants();
  },
  methods: {
    showDiv (event) {
      if(this.valeur === 'Réservation Hôtel') {
        this.selectedValue1 = true
        this.selectedValue2 = false
        this.selectedValue3 = false
      }
      if(this.valeur === 'Réservation Réstaurant') {
        this.selectedValue2 = true
        this.selectedValue1 = false
        this.selectedValue3 = false
      }
      if(this.valeur === 'Réservation Transport') {
        this.selectedValue3 = true
        this.selectedValue2 = false
        this.selectedValue1 = false
      }
      return event;
    },
    getEvenements() {
      axios
        .get('evenement/list')
        .then((reponse) => {
          this.evenements = reponse.data
        })
      console.log(this.evenements)
    },
    getTransports() {
      axios.get('/transport/liste').then((response) => {
        this.transports = response.data
      })
    },
    getHotels() {
      axios.get('/hotels').then((response) => {
        this.hotels = response.data
      })
    },
    listRestaurants() {
      axios.get("/restaurant").then((response) => {
        this.restaurants = response.data;
      });
    },
    ajouterReservationHotel() {
      const ajouterReservationHotel = {
        chambre: this.reservationHotel.chambre,
        dateEntree: this.reservationHotel.dateEntree,
        dateSortie: this.reservationHotel.dateSortie,
        nuitParPersonne: this.reservationHotel.nuitParPersonne,
        nbrPersonne: this.reservationHotel.nbrPersonne,
        totalNuitee: this.reservationHotel.totalNuitee,
        hotel: this.reservationHotel.hotel,
        evenement: this.reservationHotel.evenement.id
      };
      axios.post('reservation/hotel/ajouter', ajouterReservationHotel).then(
        this.$notify({
          title: 'Résérvation d\'hôtel faite avec succès',
          text: 'Résérvation d\'hôtel faite avec succès',
          type: 'success',
          template: Notification,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        }),
        this.$router.push('/reservation/liste')
      ).catch(
        err => {
          err.toString()
          this.$notify({
            title: 'Erreur lors résérvation d\'hôtel !',
            text: 'Erreur lors résérvation d\'hôtel !',
            type: 'error',
            template: Notification,
            icon: 'fa fa-times'
          });
        });
    },
    ajouterReservationRestaurant() {
      const ajouterReservationRestaurant = {
        restaurant: this.reservationrestaurant.restaurant,
        date_entree: this.reservationrestaurant.date_entree,
        nbr_personne: this.reservationrestaurant.nbr_personne,
        evenement: this.reservationrestaurant.evenement.id
      };
      axios.post('/reservation/restaurant/ajouter', ajouterReservationRestaurant).then(
        this.$notify({
          title: 'Restaurant reservée',
          text: 'Restaurant reservée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        }),
        this.$router.push('/reservation/liste')
      ).catch(
        err => {
          err.toString()
          this.$notify({
            title: 'Erreur',
            text: 'Erreur lors de l\'ajout de reservation',
            type: 'error',
            template: NotificationTemplate,
            icon: 'fa fa-times'
          });
        });
    },
    ajouterReservationTransport() {
      const ajouterReservationTransport = {
        transport: this.reservationTransport.transport,
        date: this.reservationTransport.date,
        lieuDepart: this.reservationTransport.lieuDepart,
        nombrePax: this.reservationTransport.nombrePax,
        destination: this.reservationTransport.destination,
        evenement: this.reservationTransport.evenement.id
      };
      axios.post('/reservationtransports/ajouter', ajouterReservationTransport).then(
        this.$notify({
          title: 'transport reservée',
          text: 'transport reservée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        }),
        this.$router.push('/reservation/liste')
      ).catch(
        err => {
          err.toString()
          this.$notify({
            title: 'Erreur',
            text: 'Erreur lors de l\'ajout de reservation',
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
.center_buttons {
  display: grid;
  grid-auto-flow: column;
  grid-gap: 10px;
}
</style>

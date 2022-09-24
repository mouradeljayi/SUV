<template>
  <card class="card" title="modifier Transport">
    <div>
      <form @submit.prevent="modifierReservation(reservationTransport.id)">
        <div class="row">
          <div class="col-md-6">
            <label>transports</label>
            <multiselect :options="transport"
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

          <div class="col-md-4">
            <fg-input type="text"
                      label="lieu Depart"
                      placeholder="Saisissez le lieu de Depart"
                      v-model="reservationTransport.lieuDepart">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="text"
                      label="destination"
                      placeholder="Saisissez la destination"
                      v-model="reservationTransport.destination">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="number"
                      label="nombre Pax"
                      placeholder="Saisissez le nombre de Pax"
                      v-model="reservationTransport.nombrePax"
            >
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
import NotificationTemplate from "../Notifications/NotificationTemplate";

export default {
  data() {
    return {
      transport: [],
      evenements: [],
      reservationTransport: ""
    };
  },
  methods: {
    getTransports(id) {
      axios.get("transport/liste").then((response) => {
        this.transport = response.data;
      });
    },
    getEvenements() {
      axios
        .get('evenement/list')
        .then((reponse) => {
          this.evenements = reponse.data
        })
    },
    getReservationsTransport(id) {
      axios.get('reservationtransports/' + id).then((response) => {
        this.reservationTransport = response.data
      })
    },
    modifierReservation(id) {
      const updatedReservationTransport = {
        date: this.reservationTransport.date,
        lieuDepart: this.reservationTransport.lieuDepart,
        destination: this.reservationTransport.destination,
        nombrePax: this.reservationTransport.nombrePax,
        transport: this.reservationTransport.transport,
        evenement: this.reservationTransport.evenement.id,
      };
      axios.put("/reservationtransports/edit/" + this.reservationTransport.id, updatedReservationTransport).then(response => {
        this.$notify({
          title: 'transport modifiée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        });
        this.$router.push("/reservation/liste");
      })
    }
  },
  mounted() {
    this.getTransports(this.$route.params.id);
    this.getReservationsTransport(this.$route.params.id);
    this.getEvenements(this.$route.params.id);
  }
}
</script>
<style>
</style>

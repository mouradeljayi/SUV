<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <multiselect :options="types" :custom-label="showDiv"
                     placeholder="choisissez le type de réservation"
                     deselect-label="Entrez pour supprimer"
                     select-label="Entrez pour sélectionner"
                     v-model="valeur"
        >
        </multiselect>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <card title="Liste des Réservations">
          <p-button type="info" class="addbutton"
                    outline
                    @click.native.prevent="ajouterReservation">
            Ajouter Une réservation
          </p-button>
          <div class="table table-responsive">
<!--            <div v-if="selectedValue0">-->
<!--              <table id="datatable"></table>-->
<!--            </div>-->
            <div v-if="selectedValue1">
              <table id="datatable">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Hôtel</th>
                  <th>Date Entree</th>
                  <th>Date Sortie</th>
                  <th>Chambre</th>
                  <th>Nombre Personne</th>
                  <th>Nombre nuits par Personne</th>
                  <th>Total Nuitée</th>
                  <th>Evenement</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="reservation in reservationHotels" v-bind:key="reservation.id">
                  <td>{{ reservation.id }}</td>
                  <td>{{ reservation.hotel.nom }}</td>
                  <td>{{ new Date(reservation.dateEntree).toLocaleDateString('fr', options) }}</td>
                  <td>{{ new Date(reservation.dateSortie).toLocaleDateString('fr', options) }}</td>
                  <td>{{ reservation.chambre }}</td>
                  <td>{{ reservation.nbrPersonne }}</td>
                  <td>{{ reservation.nbrNuitParPersonne }}</td>
                  <td>{{ reservation.totalNuitee }}</td>
                  <td>{{ reservation.evenement.nom }}</td>
                  <td>
                    <button class="btn btn-info btn-sm" v-b-modal="'modifier'+reservation.id">
                      <i class="fa fa-edit"></i>
                    </button>
                    <b-modal :id="'modifier'+reservation.id" title="Confirmation">
                      <b>
                        Voulez-vous vraiment modifier cette reservation ?
                      </b>
                      <template #modal-footer="{ ok, cancel }">
                        <p-button
                          round
                          type="info"
                          @click.native.prevent="modifierHotel(reservation.id)">
                          Oui
                        </p-button>
                        <p-button
                          round
                          type="danger"
                          @click.native.prevent="cancel()">
                          Annuler
                        </p-button>
                      </template>
                    </b-modal>
                    |
                    <button class="btn btn-danger btn-sm" v-b-modal="'supprimer'+reservation.id">
                      <i class="fa fa-trash"></i>
                    </button>
                    <b-modal :id="'supprimer'+reservation.id" title="Confirmation">
                      <b>
                        Voulez-vous vraiment Supprimer cette reservation ?
                      </b>
                      <template #modal-footer="{ ok, cancel }">
                        <p-button
                          round
                          type="info"
                          @click.native.prevent="supprimerHotel(reservation.id)">
                          Oui
                        </p-button>
                        <p-button
                          round
                          type="danger"
                          @click.native.prevent="cancel()">
                          Annuler
                        </p-button>
                      </template>
                    </b-modal>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
            <div v-if="selectedValue2">
              <table id="datatable">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Restaurant</th>
                  <th>Evenement</th>
                  <th>Date Entree</th>
                  <th>Nombre personne</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="reservationrestaurant in reservationrestaurants" v-bind:key="reservationrestaurant.id">
                  <td>{{ reservationrestaurant.id }}</td>
                  <td>{{ reservationrestaurant.restaurant.nom }}</td>
                  <td>{{ reservationrestaurant.evenement.nom }}</td>
                  <td>{{ new Date(reservationrestaurant.dateEntree).toLocaleDateString('fr', options) }}</td>
                  <td>{{ reservationrestaurant.nbrPersonne }}</td>
                  <td>
                    <button v-b-modal="'modifier'+reservationrestaurant.id" class="btn btn-info btn-sm">
                      <i class="fa fa-edit"></i>
                    </button>
                    <b-modal :id="'modifier'+reservationrestaurant.id" title="Confirmation">
                      <b>
                        Voulez-vous vraiment modifier cette reservation ?
                      </b>
                      <template #modal-footer="{ ok, cancel }">
                        <p-button
                          round
                          type="info"
                          @click.native.prevent="modifierRestaurant(reservationrestaurant.id)">
                          Oui
                        </p-button>
                        <p-button
                          round
                          type="danger"
                          @click.native.prevent="cancel()">
                          Annuler
                        </p-button>
                      </template>
                    </b-modal>
                    |
                    <button v-b-modal="'supprimer'+reservationrestaurant.id" class="btn btn-danger btn-sm">
                      <i class="fa fa-trash"></i>
                    </button>
                    <b-modal :id="'supprimer' + reservationrestaurant.id" title="Confirmation">
                      <b>
                        Voulez-vous vraiment supprimer cette reservation ?
                      </b>
                      <template #modal-footer="{ ok, cancel }">
                        <p-button
                          round
                          type="info"
                          @click.native.prevent="supprimerRestaurant(reservationrestaurant.id)">
                          Oui
                        </p-button>
                        <p-button round type="danger" @click.native.prevent="cancel()">
                          Annuler
                        </p-button>
                      </template>
                    </b-modal>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
            <div v-if="selectedValue3">
              <table id="datatable">
                <thead>
                <tr>
                  <th>#</th>
                  <th>transport</th>
                  <th>evenement</th>
                  <th>date</th>
                  <th>lieuDepart</th>
                  <th>destination</th>
                  <th>nombrePax</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="reservation in reservationTransport" v-bind:key="reservation.id">
                  <td>{{ reservation.id }}</td>
                  <td>{{ reservation.transport.nom }}</td>
                  <td>{{ reservation.evenement.nom }}</td>
                  <td>{{ new Date(reservation.date).toLocaleDateString('fr', options) }}</td>
                  <td>{{ reservation.lieuDepart }}</td>
                  <td>{{ reservation.destination }}</td>
                  <td>{{ reservation.nombrePax }}</td>

                  <td>
                    <button v-b-modal="'modifier'+reservation.id" class="btn btn-info btn-sm">
                      <i class="fa fa-edit"></i>
                    </button>
                    <b-modal :id="'modifier'+reservation.id" title="Confirmation">
                      <b>
                        Voulez-vous vraiment modifier cette reservation ?
                      </b>
                      <template #modal-footer="{ ok, cancel }">
                        <p-button
                          round
                          type="info"
                          @click.native.prevent="modifierTransport(reservation.id)">
                          Oui
                        </p-button>
                        <p-button
                          round
                          type="danger"
                          @click.native.prevent="cancel()">
                          Annuler
                        </p-button>
                      </template>
                    </b-modal>
                    |
                    <button v-b-modal="'supprimer'+reservation.id" class="btn btn-danger btn-sm">
                      <i class="fa fa-trash"></i>
                    </button>
                    <b-modal :id="'supprimer' + reservation.id" title="Confirmation">
                      <b>
                        Voulez-vous vraiment supprimer cette reservation ?
                      </b>
                      <template #modal-footer="{ ok, cancel }">
                        <p-button
                          round
                          type="info"
                          @click.native.prevent="supprimerTransport(reservation.id)">
                          Oui
                        </p-button>
                        <p-button round type="danger" @click.native.prevent="cancel()">
                          Annuler
                        </p-button>
                      </template>
                    </b-modal>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </card>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import $ from "jquery";
import NotificationTemplate from "@/pages/Notifications/NotificationTemplate";
import Multiselect from "vue-multiselect";

export default {
  components(){
    Multiselect
  },
  data() {
    return {
      types: ["Réservation Hôtel", "Réservation Réstaurant", "Réservation Transport"],
      valeur: 'Réservation Hôtel',
      selectedValue1: true,
      selectedValue2: false,
      selectedValue3: false,
      reservationHotels: [],
      reservationrestaurants: [],
      reservationTransport: [],
    }
  },
  mounted() {
    this.getReservationsHotels();
    this.getReservationRestaurant();
    this.getReservationsTransport();
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
    datatable() {
      this.$nextTick(() => {
        $("#datatable").DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "filter": true,
          "autoWidth": false,
          "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
          },
          buttons: [
            "copy", "csv", "excel", "pdf", "print"
          ]
        })
      });
    },
    getReservationsHotels(){
      axios.get('reservation/hotel/liste').then((response) => {
        this.reservationHotels = response.data
        this.datatable()
      })
    },
    getReservationRestaurant(){
      axios.get("/reservation/restaurant").then(response => {
        this.reservationrestaurants = response.data;
      });
    },
    getReservationsTransport(){
      axios.get('/reservationtransports').then((response) => {
        this.reservationTransport = response.data
      })
    },
    ajouterReservation() {
      this.$router.push({path: '/reservation/ajouter'});
    },
    modifierHotel(id) {
      this.$router.push("/reservation/hotel/modifier/" + id);
    },
    modifierRestaurant(id) {
      this.$router.push("/reservation/restaurant/modifier/" + id);
    },
    modifierTransport(id) {
      this.$router.push("/reservation/transport/modifier/" + id);
    },
    supprimerHotel(id) {
      axios.delete("/reservation/hotel/supprimer/" + id, id).then(response => {
        this.$notify({
          title: 'réservation hôtel supprimé avec succès',
          text: 'réservation hôtel supprimé avec succès',
          type: 'danger',
          template: NotificationTemplate,
          icon: 'fa fa-trash',
          horizontalAlign: 'center',
        })
        this.$router.go(0);
      });
    },
    supprimerRestaurant(id) {
      axios.put("/reservation/restaurant/archiver/" + id).then(response => {
        if(response.data.message === "Reservation restaurant archivée avec succès") {
          this.$notify({
            title: 'Reservation supprimée',
            text: "Reservation archivée avec succès",
            type: 'danger',
            template: NotificationTemplate,
            icon: 'fa fa-trash',
            horizontalAlign: 'center',
          });
          this.$router.go(0);
        }
      }).catch(error => {
        error.toString();
      });
    },
    supprimerTransport(id) {
      axios.delete("/reservationtransports/delete/" + id).then(response => {
        this.$notify({
          title: 'réservation transport supprimé avec succès',
          text: 'réservation transport supprimé avec succès',
          type: 'danger',
          template: NotificationTemplate,
          icon: 'fa fa-trash',
          horizontalAlign: 'center',
        })
        this.$router.go(0);
      });
    }
  }
}
</script>

<style scoped>

</style>

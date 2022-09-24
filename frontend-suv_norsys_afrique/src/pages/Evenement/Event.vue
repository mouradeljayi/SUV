<template>
  <div class="row">
    <div class="col-12">
      <card title="Liste des événements">
        <p-button type="info" class="addbutton"
                  outline
                  @click.native.prevent="addEvent">
          Ajouter événement
        </p-button>
        <div class="table table-responsive">
          <table id="datatable">
            <thead>
              <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Date de début d'événement</th>
                <th>Date de fin d'événement</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="evenement in evenements" v-bind:key="evenement.id">
                <td>{{ evenement.id }}</td>
                <td>{{ evenement.nom }}</td>
                <td>{{ new Date(evenement.date).toLocaleDateString('fr', options) }}</td>
                <td>{{ new Date(evenement.dateFinEvenement).toLocaleDateString('fr', options) }}</td>
                <td>
                <button v-b-modal="'modifier'+evenement.id" class="btn btn-info btn-sm">
                  <i class="fa fa-edit"></i>
                </button>
                <b-modal :id="'modifier'+evenement.id" title="Confirmation">
                  <b>
                    Voulez-vous vraiment modifier cette événement ?
                  </b>
                  <template #modal-footer="{ ok, cancel }">
                    <p-button
                      round
                      type="info"
                      @click.native.prevent="modifier(evenement.id)">
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
                <button v-b-modal="'archiver'+evenement.id" class="btn btn-danger btn-sm">
                  <i class="fa fa-trash"></i>
                </button>
                <b-modal :id="'archiver' + evenement.id" title="Confirmation">
                  <b>
                    Voulez-vous vraiment archivée cette evenement ?
                  </b>
                  <template #modal-footer="{ ok, cancel }">
                    <p-button round type="info" @click.native.prevent="archiver(evenement.id)">
                      Oui
                    </p-button>
                    <p-button round type="danger" @click.native.prevent="cancel()">
                      Annuler
                    </p-button>
                  </template>
                </b-modal>
                |
                <button v-b-modal="'status'" class="btn btn-info btn-sm" v-on:click="sendInfo(evenement)">
                  <i class="fa fa-info"></i>
                </button>
              </td>
              </tr>
              <b-modal id="status" title="les informations de l'événement">
                <h5>Nom de l'événement: <b>{{nom}}</b> </h5>
                <h5>Status de l'événement: <b>{{status}}</b> </h5>
                <h5>Type de l'événement: <b>{{type}}</b> </h5>
                <h5>Description de l'événement: <b>{{description}}</b> </h5>
              </b-modal>
            </tbody>
          </table>
        </div>
      </card>
    </div>
  </div>
</template>
<script>
import "jquery/dist/jquery.min.js";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";
import axios from "axios";
import NotificationTemplate from "@/pages/Notifications/NotificationTemplate";

export default {
  data() {
    return{
      events: [],
      evenements: [],
      modalShow: false,
      test: 'this is a test',
      selectedEvent: '',
      nom: '',
      status: '',
      type: '',
      description: '',
    }
  },
  mounted() {
    this.getEvents()
    this.listEvents()
    this.sendInfo()
  },
  methods:{

    sendInfo(item) {
        this.selectedEvent = item;
        console.log(this.selectedEvent)
        this.nom = this.selectedEvent.nom
      this.status = this.selectedEvent.status.nom
      this.type = this.selectedEvent.Type.nom
      this.description = this.selectedEvent.description
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

    getEvents() {
      axios
        .get('http://localhost:98/evenement')
        .then((reponse) => {
          this.events = reponse.data
        })
    },

    listEvents(){
      axios.get("/evenement/list").then(response => {
        this.evenements = response.data
        this.datatable()
      })
    },

    modifier(id) {
      this.$router.push("event/modifier/" + id);
      this.$router.go(0);
    },

    addEvent() {
      this.$router.push({path: '/addEvent'});
      this.$router.go(0);
    },

    archiver(id) {
      axios.put("/evenement/archiver/" + id).then(response => {
        if(response.data.message === "Evenement archivée avec succès") {
          this.$notify({
            title: 'Evenement archivée',
            text: "Evenement archivée avec succès",
            type: 'danger',
            template: NotificationTemplate,
            icon: 'fa-regular fa-box-archive',
            horizontalAlign: 'center',
          });
          this.$router.go(0);
        }
      }).catch(error => {
        error.toString();
      });
      },
  }
}
</script>
<style>
</style>

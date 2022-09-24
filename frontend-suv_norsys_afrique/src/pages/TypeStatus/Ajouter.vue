<template>
  <card class="card" title="Ajouter une activité">
    <div>
      <form @submit.prevent="ajouterStatus">
        <div class="row">
          <div class="col-md-6">
            <fg-input type="text"
                      label="Nom de status"
                      placeholder="Nom de status"
                      v-model="status.nom">
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
  </card>
</template>

<script>
import axios from "axios";
import NotificationTemplate from "../Notifications/NotificationTemplate";

export default {
  data() {
    return {
      status: {
        nom: "",
      }
    };
  },
  methods: {
    ajouterStatus() {
        const status_data = {
          nom: this.status.nom,
        };
        axios.post("/type/status/ajouter", status_data).then(
          this.$notify({
            title: 'Status ajoutée',
            text: 'Status ajoutée avec succès',
            type: 'success',
            template: NotificationTemplate,
            icon: 'fa fa-check',
            horizontalAlign: 'center',
          }),
          this.$router.push('/status')
          ).catch(
            err => {
              err.toString()
              this.$notify({
                title: 'Erreur',
                text: 'Erreur lors de l\'ajout de status',
                type: 'error',
                template: NotificationTemplate,
                icon: 'fa fa-times'
              });
            });
      },
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

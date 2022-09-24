<template>
  <card class="card" title="Modifier une status">
    <div>
      <form @submit.prevent="modifierStatus(status.id)">
        <div class="row">
          <div class="col-md-6">
            <fg-input type="text"
                      label="Nom de status"
                      placeholder="Nom de status"
                      v-bind:value="status.nom"
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
      status: "",
    };
  },
  methods: {
    getStatus(id) {
      axios.get("/type/status/" + id, id).then(response => {
        this.status = response.data;
      });
    },
    modifierStatus() {
      const updatedStatus = {
        nom: this.status.nom,
      };
      axios.put("/type/status/modifier/" + this.status.id, updatedStatus).then(response => {
        console.log(response.data);
        this.$notify({
          title: 'Status modifiée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',

        });
        this.$router.push("/status");
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
    this.getStatus(this.$route.params.id);
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

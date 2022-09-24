<template>
  <card class="card" title="modifier Transport">
    <div>
      <form @submit.prevent="modifierTransport(transport.id)">
        <div class="row">
          <div class="col-md-12">
            <fg-input type="text"
                      label="Nom"
                      placeholder="Nom"
                      v-model="transport.nom">
            </fg-input>
          </div>
        </div>
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
        <div class="clearfix"></div>
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
      transport: "",
    };
  },
  methods: {
    getTransports(id) {
      axios.get("/transport/afficher/" + id, id).then(response => {
        this.transport = response.data;
      });
    },
    modifierTransport(id) {
      const updatedTransport = {
        nom: this.transport.nom,
      };
      axios.put("/transport/modifier/" + this.transport.id, updatedTransport).then(response => {
        this.$notify({
          title: 'transport modifiée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        });
        this.$router.push("/transport");
      })
    }
  },
  mounted() {
    this.getTransports(this.$route.params.id);
  }
}
</script>

<style scoped>

</style>

<template>
  <card class="card" title="Ajouter Transport">
    <div>
      <form @submit.prevent="ajouterTransport">
        <div class="row">
          <div class="col-md-12">
            <fg-input type="text"
                      label="Nom"
                      placeholder="Nom"
                      v-model="transports.nom">
            </fg-input>
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
import NotificationTemplate from "@/pages/Notifications/NotificationTemplate";


export default {
  data() {
    return {
      transports: {
        nom: ""
      }
    }
  },
  mounted() {
  },
  methods: {
    ajouterTransport() {
      const data = {
        nom: this.transports.nom
      }
      axios.post('transport/ajouter', data).then(response => {
        this.$notify({
          title: 'transport ajoutée',
          text: 'transport ajoutée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        }),
        this.$router.push("/transport")

      })
    }
  }

}
</script>

<style scoped>

</style>

<template>
  <card class="card" title="modifier Type Evenement">
    <div>
      <form @submit.prevent="modifierTypeEvenement(typeevenement.id)">
        <div class="row">
          <div class="col-md-12">
            <fg-input type="text"
                      label="Nom"
                      placeholder="Nom"
                      v-model="typeevenement.nom">
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
      typeevenement: "",
    };
  },
  methods: {
    getTypeEvenements(id) {
      axios.get("/typeevenement/afficher/" + id, id).then(response => {
        this.typeevenement = response.data;
      });
    },
    modifierTypeEvenement(id) {
      const updatedTypeEvenement = {
        nom: this.typeevenement.nom,
      };
      console.log(updatedTypeEvenement)
      axios.put("/typeevenement/modifier/" + this.typeevenement.id, updatedTypeEvenement).then(response => {
        console.log(response.data)
        this.$notify({
          title: 'type evenement modifiée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        });
        this.$router.push("/typeevenement");
      })
    }
  },
  mounted() {
    this.getTypeEvenements(this.$route.params.id);
  }
}
</script>
<style scoped>

</style>

<template>
  <card class="card" title="Ajouter Type Evenement">
    <div>
      <form @submit.prevent="ajouterTypeEvenement">
        <div class="row">
          <div class="col-md-12">
            <fg-input type="text"
                      label="Nom"
                      placeholder="Nom"
                      v-model="typeEvenements.nom">
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
        typeEvenements: {
          nom: ""
        }
      }
    },
  mounted() {
  },
    methods: {
      ajouterTypeEvenement() {
        const data = {
          nom: this.typeEvenements.nom
        }
        axios.post('typeevenement/ajouter', data).then(response => {
          this.$notify({
            title: 'Type Evenement ajoutée',
            text: 'Type Evenement ajoutée avec succès',
            type: 'success',
            template: NotificationTemplate,
            icon: 'fa fa-check',
            horizontalAlign: 'center',
          }),
          this.$router.push("/typeevenement")

        })
      }
    }

}
</script>

<style scoped>

</style>

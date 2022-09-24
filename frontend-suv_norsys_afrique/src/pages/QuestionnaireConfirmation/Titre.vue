<template>
  <card class="card" title="Ajouter titre au questionnaire de confirmation">
    <div>
      <form @submit.prevent="ajouter">
        <div class="row">
          <div class="col-md-6">
            <fg-input type="text"
                      label="Titre de questionnaire"
                      placeholder="Titre de questionnaire"
                      v-model="questionnaire.titre">
            </fg-input>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-3">
            <div class="center_buttons">
              <p-button type="success"
                        native-type="submit">
                OK
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
import NotificationTemplate from "@/pages/Notifications/NotificationTemplate";

export default {
  data() {
    return {
      questionnaire: {
        titre: "",
      }
    };
  },
  methods: {
    ajouter() {
      axios.get("/envoyerQuestionnaire").then(
        this.$notify({
          title: 'Questionnaire de confirmation envoye',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        }),
      );
      axios.post('/questionnaire/pac/liste', this.questionnaire).then(
        this.$notify({
          title: 'Questionnaire de confirmation ajoutée avec succès',
          text: 'Questionnaire de confirmation ajoutée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        }),
        this.$router.push('/listeQuestionnaire')
      ).catch(
        err => {
          err.toString()
          this.$notify({
            title: 'Erreur lors de l\'ajout de questionnaire',
            text: 'Erreur lors de l\'ajout de questionnaire',
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

</style>

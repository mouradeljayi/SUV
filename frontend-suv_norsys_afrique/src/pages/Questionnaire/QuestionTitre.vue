<template>
    <card class="card" title="Ajouter titre au questionnaire">
    <div>
      <form @submit.prevent="ajouterQuestionnaire">
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
import NotificationTemplate from "../Notifications/NotificationTemplate";
export default {
  data() {
    return {
      questionnaire: {
        titre: "",
      }
    };
  },
  methods: {

    ajouterQuestionnaire() {
        const questionnaire_data = {
          titre: this.questionnaire.titre,
        };
      axios.get("http://localhost:98/email").then(
        this.$notify({
          title: 'Questionnaire envoye',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
          }),
      );
      axios.post('/questionnaire/activite/ajouter', questionnaire_data).then(
        this.$notify({
          title: 'Questionnaire ajoutée',
          text: 'Questionnaire ajoutée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        }),
        this.$router.push('/Questionnaire')
      ).catch(
        err => {
          err.toString()
          this.$notify({
            title: 'Erreur',
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
.center_buttons{
  display: grid;
  grid-auto-flow: column;
  grid-gap: 10px;
}
</style>

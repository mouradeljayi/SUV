<template>
  <card class="card" title="Modifier Profile">
    <div v-for="utilisateur in utilisateurs" v-bind:key="utilisateur.id">
    <div v-if="utilisateur.email === currentUser">
      <form @submit.prevent="modifierUtilisateur(utilisateur.id)">
        <div class="row">
          <div class="col-md-3">
            <fg-input type="text"
                      label="Nom"
                      placeholder="Donnez votre nom"
                      v-model="utilisateur.nom">
            </fg-input>
          </div>
          <div class="col-md-3">
            <fg-input type="text"
                      label="Prenom"
                      placeholder="Donnez votre prenom"
                      v-model="utilisateur.prenom">
            </fg-input>
          </div>
          <div class="col-md-6">
            <fg-input type="email"
                      label="Email"
                      placeholder="Donnez votre email"
                      v-model="utilisateur.email">
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <fg-input type="date"
                      label="Date Naissance"
                      placeholder="Donnez la date de naissance"
                      v-model="utilisateur.dateNaissance">
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <fg-input type="text"
                      label="Pays"
                      placeholder="Donnez le pays"
                      v-model="utilisateur.pays">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="text"
                      label="Ville"
                      placeholder="Donnez la ville"
                      v-model="utilisateur.ville">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="text"
                      label="Code Postal"
                      placeholder="Donnez le code postal"
                      v-model="utilisateur.codePostal">
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <fg-input type="twxt"
                      label="Adresse"
                      placeholder="Donnez votre adresse"
                      v-model="utilisateur.adresse">
            </fg-input>
          </div>
          <div class="col-md-6">
            <fg-input type="text"
                      label="Telephone"
                      placeholder="Donnez le numéro de telephone"
                      v-model="utilisateur.telephone">
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
      </form>
      </div>
    </div>
  </card>
</template>
<script>
import axios from "axios";
import jwtDecode from "jwt-decode";
import NotificationTemplate from "../Notifications/NotificationTemplate";

export default {
  data() {
    let user = [];
    return {
      user,
      utilisateurs: [],
      currentUser : "",
      show: false,
    };
  },
  methods: {
    listUtilisateurs() {
      axios.get("/utilisateurs").then(response => {
        this.utilisateurs = response.data;
      });
    },

    getCurrentUser() {
      this.currentUser = jwtDecode(localStorage.getItem("token")).username;
    },

    modifierUtilisateur(id) {
      for(let i=0; i<this.utilisateurs.length; i++){
        this.user.push(this.utilisateurs[i])
        if(this.user[i].email == jwtDecode(localStorage.getItem('token')).username){
            const resultat = {
              utilisateur : this.user[i]
            };
            const updatedUtilisateur = {
              nom: resultat.utilisateur.nom,
              prenom: resultat.utilisateur.prenom,
              email: resultat.utilisateur.email,
              dateNaissance:  resultat.utilisateur.dateNaissance,
              ville:  resultat.utilisateur.ville,
              pays:  resultat.utilisateur.pays,
              codePostal:  resultat.utilisateur.codePostal,
              adresse:  resultat.utilisateur.adresse,
              telephone:  resultat.utilisateur.telephone,
            };      
            axios.put("/utilisateurs/edit/" + resultat.utilisateur.id, updatedUtilisateur).then(response => {
              this.$notify({
                title: 'Profile modifiée avec succès',
                type: 'success',
                template: NotificationTemplate,
                icon: 'fa fa-check',
                horizontalAlign: 'center',
              });
              this.$router.go(0);
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
      }
    }
  },
  mounted() {
    this.listUtilisateurs()
    this.getCurrentUser()
  }
};
</script>
<style>
</style>

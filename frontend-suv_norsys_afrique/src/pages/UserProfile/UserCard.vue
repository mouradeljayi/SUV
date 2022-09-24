<template>
  <card class="card-user">
    <div slot="image">
       <img src="@/assets/img/logo-Norsys.jpg" alt="..."> 
    </div>
    <div>
      <div class="author">
         <img class="avatar border-white" src="@/assets/img/faces/profile.png" alt="..."> 
         <h4 class="title">
         <div v-for="utilisateur in utilisateurs" v-bind:key="utilisateur.id">
          <div v-if="utilisateur.email === currentUser">
          <h5>
            <small>{{utilisateur.nom}} {{utilisateur.prenom}}</small>
            <br>
            <small>{{utilisateur.email}}</small>
            <br>
            <small> {{new Date(utilisateur.dateNaissance).toLocaleDateString('fr', options)}}</small>
          </h5>
         </div>
         </div>
         </h4>
      </div>
    </div>
  </card>
</template>
<script>
import axios from "axios";
import jwtDecode from "jwt-decode";

export default {
  data() {
    return {
      details: [
        
      ],
      utilisateurs : [],
      currentUser : "",
    };
  },
  methods: {
    getCurrentUser() {
      this.currentUser = jwtDecode(localStorage.getItem("token")).username;
    },

    listUtilisateurs() {
      axios.get("/utilisateurs").then(response => {
        this.utilisateurs = response.data;
      });
    },

    getClasses(index) {
      var remainder = index % 3;
      if (remainder === 0) {
        return "col-lg-3 offset-lg-1";
      } else if (remainder === 2) {
        return "col-lg-4";
      } else {
        return "col-lg-3";
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

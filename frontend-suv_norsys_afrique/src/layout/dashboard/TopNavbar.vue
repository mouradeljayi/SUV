<template>
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">

      <button class="navbar-toggler navbar-burger"
              type="button"
              @click="toggleSidebar"
              :aria-expanded="$sidebar.showSidebar"
              aria-label="Toggle navigation">
        <span class="navbar-toggler-bar"></span>
        <span class="navbar-toggler-bar"></span>
        <span class="navbar-toggler-bar"></span>
      </button>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
          </li>
          <li class="nav-item">
            <drop-down class="nav-item"
                     title-classes="nav-link"
                     icon="ti-user"
                       v-bind:title="currentUser"
            >
            <a class="dropdown-item" href="/profile">Mon Profile</a>
            <a class="dropdown-item" @click.prevent="logout">Se déconnecter</a>
          </drop-down>
          </li>
        </ul>
      </div>
    </div></nav>
</template>
<script>
import jwtDecode from "jwt-decode";
import axios from "axios";

export default {
  computed: {
    routeName() {
      const { name } = this.$route;
      return this.capitalizeFirstLetter(name);
    }
  },
  data() {
    return {
      activeNotifications: false,
      currentUser: "",
    };
  },
  mounted() {
    this.getCurrentUser()
  },
  methods: {
    logout() {
      localStorage.clear()
      this.$router.push("/login")
    },
    getCurrentUser() {
      this.currentUser = jwtDecode(localStorage.getItem("token")).username;
    },
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    toggleNotificationDropDown() {
      this.activeNotifications = !this.activeNotifications;
    },
    closeDropDown() {
      this.activeNotifications = false;
    },
    toggleSidebar() {
      this.$sidebar.displaySidebar(!this.$sidebar.showSidebar);
    },
    hideSidebar() {
      this.$sidebar.displaySidebar(false);
    }
  }
};
</script>
<style>
</style>

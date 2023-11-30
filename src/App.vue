<template>
  <v-app>
    <v-app-bar app class="" color="white">
      <h3 class="text-h5">Whistleblower 1.0</h3>
      <v-spacer></v-spacer>
      <div class="d-flex align-center">
        <router-link to="/">
          <v-img
            alt="Condivision Logo"
            src="https://banqueting.condivision.cloud/fl_app/registerForm/logo.png"
            width="150"
          />
        </router-link>
      </div>

      <v-spacer></v-spacer>
      <v-toolbar-items>
        <PrivacyDialog :dialog="privacyDialog" />

        <v-btn :loading="loadingBtn" @click="handleModal" icon>
          <v-icon>vpn_key</v-icon>
        </v-btn>
      </v-toolbar-items>
    </v-app-bar>

    <v-main>
      <router-view />
    </v-main>

    <v-snackbar
      v-model="snackbar.state"
      :timeout="snackbar.timeout"
      :top="snackbar.y === 'top'"
      :color="snackbar.color"
    >
      {{ snackbar.text }}
      <v-btn depressed @click="snackbar = false">
        Chiudi
      </v-btn>
    </v-snackbar>
    <Modal />
  </v-app>
</template>

<script>
import PrivacyDialog from "./components/PrivacyDialog.vue";
import Modal from "@/components/Modal";
import EventBus from "@/eventBus.js";
import { endpoint } from "@/plugins/endpoint";
import axios from "axios";

export default {
  name: "App",
  components: {
    PrivacyDialog,
    Modal,
  },
  data: () => ({
    privacyDialog: false,
    loadingBtn: false,
    dialog: false,
    formSubmit: false,
    btnToggle: false,
    loading: false,
    code: "",
    formData: new FormData(),
    searchSecretCode: "",
    codeExist: false,
    snackbar: {
      color: "success",
      state: false,
      y: "top",
      x: null,
      mode: "",
      timeout: 6000,
      text: "Il modulo è stato inviato con successo.",
    },
  }),
  computed: {
    isLanding() {
      if (location.hash !== "#/") {
        return false;
      }
      return true;
    },
  },
  methods: {
    handleDialogToggle() {
      this.dialog = !this.dialog;
    },
    handleSnackbar(color, state, text) {
      this.snackbar = Object.assign(
        {},
        {
          color,
          state,
          text,
          y: "top",
          x: null,
          mode: "",
          timeout: 6000,
        }
      );
    },
    async handleModal() {
      this.loadingBtn = true;
      let formData = new FormData();
      formData.append("checkSession", true);

      try {
        const response = await axios.post(`${endpoint}/api.php`, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        console.log("response-check-session", response);
        if (response.data.status === "OK") {
          this.$router.push({
            path: "/formlist",
          });
        } else {
          EventBus.$emit("modal", true);
        }
        this.loadingBtn = false;
      } catch (error) {
        EventBus.$emit("snackbar", {
          color: "error",
          state: true,
          text: "Errore di rete!",
        });
        console.log(error);
      }
    },
  },
  mounted() {
    EventBus.$on("snackbar", (payload) => {
      this.handleSnackbar(payload.color, payload.state, payload.text);
    });
  },
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td,
th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
</style>

<template>
  <v-app>
    <v-toolbar app dark color="#3581b5">
      <!-- <v-toolbar-side-icon></v-toolbar-side-icon> -->
      <v-toolbar-title class="headline text-uppercase">
        <router-link to="/"><span >Città di Bitetto</span></router-link>
        
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <!-- <v-btn
        class="hidden-sm-and-up"
        color="warning"
        dark
        small
        absolute
        bottom
        right
        fab
        @click="handleDialogToggle"
      >
        <v-icon>vpn_key</v-icon>
      </v-btn> -->
      
      
      <v-toolbar-items>
        
        <!-- <v-text-field
          :loading="loading"
          prepend-icon="vpn_key"
          color="white"
          :clearable="true"
          label="Inserisci il tuo Codice"
          v-model="searchSecretCode"
        ></v-text-field> -->
        
        <v-btn :loading="loadingBtn" @click="handleModal" icon>
          <v-icon>vpn_key</v-icon>
        </v-btn>
      </v-toolbar-items>      
    </v-toolbar>

    <v-content>
        <!-- <Landing/> -->
        <!-- <v-container fluid>
      
          <v-layout v-if="!codeExist" wrap>
            <v-flex xs12>
              <Form @form-submit="handleFormSubmit" @mail-sent="handleMailSent" v-if="formSubmit === false"/>
              <ThankYouPage :code="code" v-if="formSubmit === true"/>
            </v-flex>
            
          </v-layout>
      

      <transition name="fade">
        <v-layout v-if="codeExist" wrap>
          <v-flex md8>
            <UpdatedForm :updatedForm="updatedForm" @form-submit="handleFormSubmit" @mail-sent="handleMailSent" v-if="formSubmit === false"/>
          </v-flex>
          <v-flex md4>
            <Header :header="header" v-if="formSubmit === false"/>
            <Comments :formId="updatedForm.id" @form-submit="handleFormSubmit" @mail-sent="handleMailSent" v-if="formSubmit === false"/>
          </v-flex>
        </v-layout>
      </transition>
        </v-container> -->
      <router-view/>
    </v-content>
    <v-snackbar
      v-model="snackbar.state"
      :timeout="snackbar.timeout"
      :top="snackbar.y === 'top'"
      :color="snackbar.color"
    >
    {{ snackbar.text }}
      <v-btn
        flat
        @click="snackbar = false"
      >
        Chiudi
      </v-btn>
    </v-snackbar>
    <Modal />
  </v-app>
</template>

<script>
// import Form from "./components/Form";
// import UpdatedForm from "./components/UpdatedForm";
// import ThankYouPage from "./components/ThankYouPage";
// import Header from "./components/Header";
// import Comments from "./components/Comments";
import Modal from "@/components/Modal";
import EventBus from "@/eventBus.js";
import axios from "axios";

export default {
  name: "App",
  components: {
    Modal
  },
  // components: {
  //   Form,
  //   UpdatedForm,
  //   ThankYouPage,
  //   Header,
  //   Comments
  // },
  data() {
    return {
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
        text: "Il modulo è stato inviato con successo."
      },
      endpoint:
        location.hostname === "localhost"
          ? "http://www.comune.bitetto.ba.it/whistleblower2/"
          : ""
    };
  },
  computed: {
    isLanding() {
      if (location.hash !== "#/") {
        return false;
      }
      return true;
    }
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
          timeout: 6000
        }
      );
    },
    async handleModal() {
      this.loadingBtn = true;
      let formData = new FormData();
      formData.append("checkSession", true);

      try {
        const response = await axios.post(this.endpoint + "api.php", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        });
        console.log("response-check-session", response);
        if (response.data.status === "OK") {
          this.$router.push({
            path: "/formlist"
          });
        } else {
          EventBus.$emit("modal", true);
        }
        this.loadingBtn = false;
      } catch (error) {
        EventBus.$emit("snackbar", {
          color: "error",
          state: true,
          text: "Errore di rete!"
        });
        console.log(error);
      }
    },
    async handleCheckSession() {}
  },
  mounted() {
    EventBus.$on("snackbar", payload => {
      this.handleSnackbar(payload.color, payload.state, payload.text);
    });
  }
};
</script>

<style scoped>
a {
  color: white;
  text-decoration: none;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>

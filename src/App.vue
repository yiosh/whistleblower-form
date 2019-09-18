<template>
  <v-app>
    <v-toolbar app dark color="#3581b5">
      <!-- <v-toolbar-side-icon></v-toolbar-side-icon> -->
      <v-toolbar-title class="headline text-uppercase">
        <span>Città di Bitetto</span>
        
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn
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
      </v-btn>
      <v-toolbar-items class="hidden-sm-and-down">
        <v-btn flat v-show="!btnToggle" @click="handleToggle">Hai già effettuato una segnalazione?</v-btn>
        <v-text-field
          v-show="btnToggle"
          :loading="loading"
          prepend-icon="vpn_key"
          color="white"
          :clearable="true"
          label="Inserisci il tuo Codice"
          v-model="searchSecretCode"
        ></v-text-field>
        <v-btn v-show="btnToggle" @click="handleSearchForm" icon>
          <v-icon>send</v-icon>
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
  </v-app>
</template>

<script>
// import Form from "./components/Form";
// import UpdatedForm from "./components/UpdatedForm";
// import ThankYouPage from "./components/ThankYouPage";
// import Header from "./components/Header";
// import Comments from "./components/Comments";
import EventBus from "@/eventBus.js";
import axios from "axios";

export default {
  name: "App",
  // components: {
  //   Form,
  //   UpdatedForm,
  //   ThankYouPage,
  //   Header,
  //   Comments
  // },
  data() {
    return {
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
      }
    };
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
    handleSearchForm() {
      this.loading = true;
      this.formData.append("fetchForm", true);
      this.formData.append("secretCode", this.searchSecretCode);

      let vm = this;
      let endpoint =
        location.hostname === "localhost"
          ? "http://www.comune.bitetto.ba.it/whistleblower/"
          : "";

      axios
        .post(endpoint + "api.php", this.formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          if (response.data != false) {
            let updatedForm = {};
            console.log("Fetch form response: ", response);
            updatedForm.nome = response.data.nome;
            updatedForm.autoreFatto = response.data.autore_fatto;
            updatedForm.azioniValore = response.data.azioni_valore.split(", ");
            updatedForm.cognome = response.data.cognome;
            updatedForm.dataA = response.data.data_a;
            updatedForm.dataDa = response.data.data_da;
            updatedForm.descrizioneFatto = response.data.descrizione_fatto;
            updatedForm.email = response.data.email;
            updatedForm.id = response.data.id;
            updatedForm.altriEventualiSoggetti = response.data.eventuali_soggetti.split(
              ","
            );
            updatedForm.luogoFatto = response.data.luogo_fatto.split(", ");
            updatedForm.qualificaProfessionale =
              response.data.qualifica_professionale;
            updatedForm.secretCode = response.data.secret_code;
            updatedForm.sedeServizio = response.data.sede_servizio;
            updatedForm.telefono = response.data.telefono;

            let header = {};
            header.createdAt = response.data.created_at;
            header.updatedAt = response.data.updated_at;
            header.expiresAt = response.data.expires_at;

            if (location.hash !== "#/result") {
              vm.$router.push({
                name: "result",
                params: {
                  header,
                  updatedForm
                }
              });
            } else {
              console.log("twf");
              vm.$router.push({ path: "/" });
            }
            this.searchSecretCode = "";
            this.btnToggle = false;
          } else {
            this.handleSnackbar("error", true, "Nessun modulo trovato!");
          }
          this.loading = false;
        });
    },
    handleToggle() {
      this.btnToggle = true;
    }
  },
  mounted() {
    EventBus.$on("snackbar", payload => {
      this.handleSnackbar(payload.color, payload.state, payload.text);
    });
  }
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
</style>

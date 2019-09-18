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
        <v-container fluid>
      <transition name="fade">
          <v-layout v-if="!codeExist" wrap>
            <v-flex xs12>
              <Form @form-submit="handleFormSubmit" @mail-sent="handleMailSent" v-if="formSubmit === false"/>
              <ThankYouPage :code="code" v-if="formSubmit === true"/>
            </v-flex>
            
          </v-layout>
      </transition>

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
        </v-container>
      
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
    <v-dialog
      v-model="dialog"
    >
      <v-card>
        <v-card-title
          class="headline grey lighten-2"
          primary-title
        >
          Hai già effettuato una segnalazione?
        </v-card-title>

        <v-card-text>
          <v-text-field
            :loading="loading"
            prepend-icon="vpn_key"
            label="Inserisci il tuo Codice"
            v-model="searchSecretCode"
          ></v-text-field>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="success" @click="handleSearchForm">
            Invia
          </v-btn>
          <v-btn
            color="primary"
            flat
            @click="dialog = false"
          >
            Chiudi
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-app>
</template>

<script>
import Form from "./components/Form";
import UpdatedForm from "./components/UpdatedForm";
import ThankYouPage from "./components/ThankYouPage";
import Header from "./components/Header";
import Comments from "./components/Comments";
import axios from "axios";

export default {
  name: "App",
  components: {
    Form,
    UpdatedForm,
    ThankYouPage,
    Header,
    Comments
  },
  data() {
    return {
      dialog: false,
      formSubmit: false,
      btnToggle: false,
      loading: false,
      code: "",
      header: {
        context: "Whistleblower",
        createdAt: "",
        updatedAt: "",
        expiresAt: ""
      },
      updatedForm: {
        autoreFatto: "",
        azioniValore: [],
        cognome: "",
        dataA: "0000-00-00",
        dataDa: "0000-00-00",
        descrizioneFatto: "",
        email: "",
        altriEventualiSoggetti: [],
        eventualliAllegati: "81",
        id: "81",
        luogoFatto: "null, ",
        nome: "",
        qualificaProfessionale: "",
        secretCode: "MTU1Nzg1MDk4Mg",
        sedeServizio: "",
        telefono: ""
      },
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
    handleFormSubmit() {
      this.snackbar.state = true;
      this.formSubmit = true;
    },
    handleMailSent(code) {
      this.code = code;
      console.log("mailsent");
      console.log("Code: ", code);
    },
    handleSearchForm() {
      this.loading = true;
      this.formData.append("fetchForm", true);
      this.formData.append("secretCode", this.searchSecretCode);

      axios
        .post("api.php", this.formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          if (response.data != false) {
            this.loading = false;
            console.log("Fetch form response: ", response);
            this.updatedForm.nome = response.data.nome;
            this.updatedForm.autoreFatto = response.data.autore_fatto;
            this.updatedForm.azioniValore = response.data.azioni_valore.split(
              ", "
            );
            this.updatedForm.cognome = response.data.cognome;
            this.updatedForm.dataA = response.data.data_a;
            this.updatedForm.dataDa = response.data.data_da;
            this.updatedForm.descrizioneFatto = response.data.descrizione_fatto;
            this.updatedForm.email = response.data.email;
            this.updatedForm.id = response.data.id;
            this.updatedForm.altriEventualiSoggetti = response.data.eventuali_soggetti.split(
              ","
            );
            this.updatedForm.luogoFatto = response.data.luogo_fatto.split(", ");
            this.updatedForm.qualificaProfessionale =
              response.data.qualifica_professionale;
            this.updatedForm.secretCode = response.data.secret_code;
            this.updatedForm.sedeServizio = response.data.sede_servizio;
            this.updatedForm.telefono = response.data.telefono;

            this.header.createdAt = response.data.created_at;
            this.header.updatedAt = response.data.updated_at;
            this.header.expiresAt = response.data.expires_at;

            this.formSubmit = false;
            if (this.codeExist) {
              this.codeExist = false;
            }
            this.codeExist = true;
            if (this.dialog) {
              this.dialog = false;
            }
          } else {
            this.snackbar.text = "Nessun modulo trovato!";
            this.snackbar.color = "error";
            this.snackbar.state = true;
            this.loading = false;
            // this.snackbar.text = "Il modulo è stato inviato con successo.";
            // this.snackbar.color = "success";
          }
        });
    },
    handleToggle() {
      this.btnToggle = true;
    }
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

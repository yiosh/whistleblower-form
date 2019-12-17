<template>
  <v-container>
    <v-layout  wrap>
      <v-flex xs12>
        <v-toolbar>
          <v-toolbar-title>Modello per la Segnalazione</v-toolbar-title>
        </v-toolbar>
        
        <v-form enctype="multipart/form-data" @submit.prevent="onSubmit">
          <v-stepper v-model="e1" vertical>
            <v-stepper-step editable color="#3581b5" :complete="e1 > 1" step="1">Info</v-stepper-step>

            <v-stepper-content step="1">
              <v-card class="mb-3" flat>
                <v-card-text style="text-align: left;">
                  Contrastare la corruzione e l'uso improprio del potere pubblico è un dovere civico al quale ognuno può concorrere.
                  Proprio per questo, il legislatore ha previsto forme specifiche di tutela per il segnalante, non contemplando la possibilità dell'invio di segnalazioni in forma anonima.
                  <br>
                  <br>
                  In ragione di ciò, la forma assolutamente privilegiata di segnalazioni - cui sarà assicurata una trattazione con carattere di priorità - è la segnalazione c.d. confidenziale ossia quella nella quale il segnalante rileva le sue generalità che comunque saranno trattate con le garanzie previste dalla legge (riservatezza, divieto di accesso, tutela a fronte di atti discriminatori eventualmente subiti…).
                  <br>
                  <br>
                  Le segnalazioni effettuate, invece, in forma anonima (ossia senza indicare le proprie generalità) saranno prese in considerazione solo in casi peculiari e, comunque, non saranno trattate ai sensi dell'art. 54-bis del D.lgs. 165/2001 e s.m.i. Tuttavia, le segnalazioni, anche se inviate in forma anonima in prima istanza, potranno essere successivamente integrate con le generalità del segnalante ai fini di acquisire ogni forma di tutela legale, oltre alla priorità di gestione.
                  <br>
                  <br>
                  Tutte le segnalazioni, nel rispetto della tutela della riservatezza dell'identità del segnalante, potranno essere inviate ad altre istituzioni (autorità giudiziaria, dipartimento della funzione pubblica, corte dei conti, etc.).
                </v-card-text>
                <v-card-actions>
                  <v-btn color="#3581b5" dark @click="e1 = 2">Continua</v-btn>
                </v-card-actions>
              </v-card>
            </v-stepper-content>

            <v-stepper-step color="#3581b5" editable :complete="e1 > 2" step="2">Dati Segnalante
              <!-- <small>Summarize if needed</small> -->
            </v-stepper-step>

            <v-stepper-content step="2">
              <v-form ref="personalinfo">
                <v-container grid-list-md>
                  <v-layout row wrap>
                    <v-flex xs12>
                      <v-switch
                        :label="`Anonimo? ${datiSegnalante.anonimo === false ? 'No' : 'Sì'}`"
                        v-model="datiSegnalante.anonimo"
                      ></v-switch>
                    </v-flex>

                    <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                      <v-text-field
                        v-model="datiSegnalante.nome"
                        :rules="[v => !!v || 'Questo campo è obbligatorio']"
                        label="Nome del segnalante"
                        required
                      ></v-text-field>
                    </v-flex>

                    <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                      <v-text-field
                        v-model="datiSegnalante.cognome"
                        :rules="[v => !!v || 'Questo campo è obbligatorio']"
                        label="Cognome del segnalante"
                        required
                      ></v-text-field>
                    </v-flex>

                    <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                      <v-layout row wrap>
                        <v-flex xs11>
                          <v-text-field
                            v-model="datiSegnalante.qualifica"
                            label="Qualifica o posizione professionale"
                            required
                          ></v-text-field>
                        </v-flex>
                        <v-flex xs1>
                          <v-tooltip bottom>
                            <span slot="activator">
                              <v-icon style="cursor: pointer">help_outline</v-icon>
                            </span>
                            <span>Qualora il segnalante rivesta la qualifica di pubblico ufficiale, l'invio della presente segnalazione non lo esonera dall'obbligo di denunciare alla competente Autorità giudiziaria i fatti penalmente rilevante e le ipotesi di danno erariale</span>
                          </v-tooltip>
                        </v-flex>
                      </v-layout>
                    </v-flex>

                    <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                      <v-text-field
                        v-model="datiSegnalante.sedeServizio"
                        label="Sede di servizio"
                        required
                      ></v-text-field>
                    </v-flex>

                    <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                      <v-text-field v-model="datiSegnalante.telefono" :rules="[v => !!v || 'Questo campo è obbligatorio']" label="Telefono" required></v-text-field>
                    </v-flex>

                    <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                      <v-text-field 
                        v-model="datiSegnalante.email" 
                        :rules="[
                          v => !!v || 'Questo campo è obbligatorio',
                          v => /.+@.+/.test(v) || 'L\'email deve essere valida'
                        ]" 
                        label="Email"
                        required
                      ></v-text-field>
                    </v-flex>

                    <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                      <v-checkbox
                        v-model="checkbox"
                        :rules="[v => !!v || 'Devi accettare di continuare!']"
                        label="Autorizzo il trattamento dei miei dati ai fini della gestione di questa segnalazione."
                        required
                      ></v-checkbox>
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-form>
              <!-- <v-card color="grey lighten-1" class="mb-5" height="200px"></v-card> -->
              <v-card-actions>
                <v-btn color="#3581b5" dark @click="validateInfo">Continua</v-btn>
                <!-- <v-btn color="#3581b5" dark @click="e1 = 3">Continua</v-btn> -->
                <v-btn @click="e1 = 1" flat>Indietro</v-btn>
              </v-card-actions>
            </v-stepper-content>

            <v-stepper-step color="#3581b5" editable :complete="e1 > 3" step="3">Dati Segnalazione</v-stepper-step>

            <v-stepper-content step="3">
              <!-- <v-form v-model="datiSegnalante.valid"> -->
              <v-container fluid grid-list-md>
                <v-layout row wrap>
                  <v-flex xs12 style="text-align: left">
                    <label>
                      <strong>Data/Periodo in cui si è verificato il fatto:</strong>
                    </label>
                  </v-flex>
                  <v-flex xs12 md6>
                    <v-menu
                      :close-on-content-click="false"
                      v-model="datiSegnalazione.menu1"
                      :nudge-right="40"
                      lazy
                      transition="scale-transition"
                      offset-y
                      full-width
                      min-width="290px"
                    >
                      <v-text-field
                        slot="activator"
                        v-model="dateDaFormatted"
                        label="Da"
                        append-icon="event"
                        readonly
                      ></v-text-field>
                      <v-date-picker
                        locale="it-it"
                        v-model="datiSegnalazione.dateDa"
                        @input="dateChanged"
                      ></v-date-picker>
                    </v-menu>
                  </v-flex>
                  <v-flex xs12 md6>
                    <v-menu
                      :close-on-content-click="false"
                      v-model="datiSegnalazione.menu2"
                      lazy
                      transition="scale-transition"
                      offset-y
                      full-width
                      min-width="290px"
                    >
                      <v-text-field
                        slot="activator"
                        v-model="dateAFormatted"
                        label="A"
                        append-icon="event"
                        readonly
                      ></v-text-field>
                      <v-date-picker
                        locale="it-it"
                        v-model="datiSegnalazione.dateA"
                        @input="datiSegnalazione.menu2 = false"
                      ></v-date-picker>
                    </v-menu>
                  </v-flex>
                  <v-flex xs12 style="text-align: left">
                    <label>
                      <strong>Luogo fisico in cui si è verificato il fatto:</strong>
                    </label>
                  </v-flex>
                  <v-flex xs12 md4>
                    <v-radio-group v-model="datiSegnalazione.luogoFatto.selected">
                      <v-radio
                        v-for="option in datiSegnalazione.luogoFatto.options"
                        :key="option.name"
                        :label="option.name"
                        :value="option.name"
                      ></v-radio>
                    </v-radio-group>
                  </v-flex>
                  <v-flex xs12 md8>
                    <v-textarea
                      v-if="datiSegnalazione.luogoFatto.selected"
                      name="input-7-1"
                      label="Luogo o indirizzo della struttura"
                      v-model="datiSegnalazione.luogoFatto.value"
                    ></v-textarea>
                  </v-flex>
                  <v-flex xs12 style="text-align: left">
                    <label>
                      <strong>Ritengo che le azioni od omissioni commesse o tentate siano:</strong>
                    </label>

                    <v-tooltip bottom>
                      <span slot="activator">
                        <v-icon style="cursor: pointer">help_outline</v-icon>
                      </span>
                      <span>La segnalazione non riguarda rimostranze di carattere personale del segnalante o richieste che attengono alla disciplina del rapporto di lavoro o ai rapporti col superiore gerarchico o colleghi, per le quali ocorre fare riferimento al servizio competente per il personale e al Comitato Unico di Garanzia</span>
                    </v-tooltip>

                    <v-checkbox
                      v-for="option in datiSegnalazione.azioniValore.options"
                      v-model="datiSegnalazione.azioniValore.selected"
                      :label="option"
                      :value="option"
                      :key="option"
                    ></v-checkbox>
                    <v-layout row wrap>
                      <v-flex xs12 md3>
                        <v-checkbox
                          v-model="datiSegnalazione.azioniValore.altroChecked"
                          label="Altro"
                          :value="datiSegnalazione.azioniValore.altroChecked"
                          key="Altro"
                        ></v-checkbox>
                      </v-flex>
                      <v-flex xs12 md9>
                        <v-textarea
                          v-if="datiSegnalazione.azioniValore.altroChecked"
                          label="(Specificare)"
                          v-model="datiSegnalazione.azioniValore.altroValue"
                        ></v-textarea>
                      </v-flex>
                    </v-layout>
                    <v-flex xs12 md9>
                      <v-textarea
                      outline
                        label="Descrizione del fatto (Condotta ed evento)"
                        v-model="datiSegnalazione.descrizioneFatto"
                      ></v-textarea>
                    </v-flex>
                    <v-flex xs12>
                      <v-layout row wrap>
                        <v-flex xs11>
                          <v-combobox
                            v-model="datiSegnalazione.autori"
                            :items="datiSegnalazione.autori"
                            hide-selected
                            label="Autore/i del fatto"
                            multiple
                            clearable
                            small-chips
                          ></v-combobox>
                        </v-flex>
                        <v-flex xs1>
                          <v-tooltip bottom>
                            <span slot="activator">
                              <v-icon style="cursor: pointer">help_outline</v-icon>
                            </span>
                            <span>Indicare i dati anagrafici se conosciuti e, in caso contrario, ogni altro elemento idoneo all'identificazione</span>
                          </v-tooltip>
                        </v-flex>
                      </v-layout>
                    </v-flex>
                    <v-flex xs12>
                      <v-layout row wrap>
                        <v-flex xs11>
                          <v-combobox
                            v-model="datiSegnalazione.altriEventualiSoggeti"
                            :items="datiSegnalazione.altriEventualiSoggeti"
                            hide-selected
                            label="Altri eventuali soggetti a conoscenza del fatto e/o in grado di riferire sul medesimo"
                            multiple
                            clearable
                            small-chips
                          ></v-combobox>
                        </v-flex>
                        <v-flex xs1>
                          <v-tooltip bottom>
                            <span slot="activator">
                              <v-icon style="cursor: pointer">help_outline</v-icon>
                            </span>
                            <span>Indicare i dati anagrafici se conosciuti e, in caso contrario, ogni altro elemento idoneo all'identificazione</span>
                          </v-tooltip>
                        </v-flex>
                      </v-layout>
                    </v-flex>
                    <v-flex xs12>
                      <label>
                        <strong>Eventuali allegati a sostegno della segnalazione</strong>
                      </label>
                      <v-btn color="#3581b5" dark @click.native="openFileDialog">Caricare
                        <v-icon right dark>cloud_upload</v-icon>
                      </v-btn>
                      <input
                        type="file"
                        style="display:none"
                        multiple
                        id="file-upload"
                        @change="onFileChange"
                      >
                      <p v-for="file in datiSegnalazione.fileList" :key="file.name">
                        <v-icon>attach_file</v-icon>
                        {{ file.name }}
                        <v-btn flat icon color="red" @click="removeFile(file.name)">
                          <v-icon>close</v-icon>
                        </v-btn>
                      </p>
                    </v-flex>
                  </v-flex>
                </v-layout>
              </v-container>
              <v-card-actions style="display: block">
                <!-- <v-layout row class="mb-2">
                  <v-checkbox
                    v-model="acceptPrivacy"
                    label="Allow spaces"></v-checkbox>
                </v-layout> -->

                <v-layout row>
                  <v-btn color="success" type="submit" dark>Invia</v-btn>
                  <v-btn @click="e1 = 2" flat>Indietro</v-btn>
                </v-layout>
              </v-card-actions>
            </v-stepper-content>
          </v-stepper>
        </v-form>
      </v-flex>
    </v-layout>
    <v-snackbar
      v-model="snackbar.state"
      :timeout="snackbar.timeout"
      :top="snackbar.y === 'top'"
      :color="snackbar.color"
    >
    {{ snackbar.text }}
      <v-btn
        flat
        @click="snackbar = false">
        Chiudi
      </v-btn>
    </v-snackbar>
  </v-container>
</template>

<script>
import EventBus from "@/eventBus.js";
import axios from "axios";
import lodash from "lodash";
// import VueRecaptcha from 'vue-recaptcha';

export default {
  // components: { VueRecaptcha },
  data: () => ({
    acceptPrivacy: false,
    checkbox: false,
    endpoint:
      location.hostname === "localhost"
        ? "http://www.comune.bitetto.ba.it/whistleblower2/"
        : "",
    color: "success",
    snackbar: {
      color: "success",
      state: false,
      y: "top",
      x: null,
      mode: "",
      timeout: 6000,
      text: "Il modulo è stato inviato con successo."
    },
    y: "top",
    x: null,
    mode: "",
    timeout: 6000,
    text: "Il modulo è stato inviato con successo.",
    formData: new FormData(),
    file: "",
    e1: 1,
    code: "",
    datiSegnalante: {
      anonimo: false,
      nome: "",
      cognome: "",
      qualifica: "",
      sedeServizio: "",
      telefono: "",
      email: "",
      valid: ""
    },
    datiSegnalazione: {
      menu1: false,
      menu2: false,
      dateDa: null,
      dateA: null,
      luogoFatto: {
        selected: null,
        options: [
          {
            name: "Ufficio",
            text: "Indicare denominazione e indirizzo della struttura"
          },
          {
            name: "All'esterno dell'ufficio",
            text: "Indicare luogo ed indirizzo"
          }
        ],
        value: ""
      },
      azioniValore: {
        selected: [],
        options: [
          "Penalmente rilevanti",
          "Poste in esere in violazione dei Codici di comportamento o di altre disposizioni sanzionabili in via disciplinare",
          "Suscettibili di arrecare un pregiudizio patrimoniale all'amministrazione di appartenenza o ad altro ente pubblico",
          "Suscettibili di arrecare un pregiudizio alla immagine dell'amministrazione"
        ],
        altroChecked: false,
        altroValue: ""
      },
      formId: null,
      descrizioneFatto: "",
      autori: [],
      altriEventualiSoggeti: [],
      eventualiAllegati: [],
      fileList: []
    }
  }),
  computed: {
    dateDaFormatted() {
      return this.formatDate(this.datiSegnalazione.dateDa);
    },
    dateAFormatted() {
      return this.formatDate(this.datiSegnalazione.dateA);
    }
  },
  methods: {
    async onSubmit() {
      // (optional) Wait until recaptcha has been loaded.
      await this.$recaptchaLoaded();
 
      // Execute reCAPTCHA with action "login".
      const token = await this.$recaptcha('login');
 
      // Do stuff with the received token.
      this.onCaptchaVerified(token);
    },
    validateInfo() {
      if (this.$refs.personalinfo.validate()) {
        this.e1 = 3;
      }

      console.log("refs", this.$refs.personalinfo);
    },
    dateChanged() {
      this.datiSegnalazione.menu1 = false;
      this.datiSegnalazione.dateA = this.datiSegnalazione.dateDa;
    },
    formatDate(date) {
      if (!date) return null;

      const [year, month, day] = date.split("-");
      return `${day}/${month}/${year}`;
    },
    openFileDialog() {
      document.getElementById("file-upload").click();
    },
    removeFile(name) {
      this.datiSegnalazione.fileList = lodash.dropWhile(
        this.datiSegnalazione.fileList,
        file => file.name == name
      );
      // this.datiSegnalazione.fileList = fileList;
    },
    onFileChange(e) {
      const files = e.target.files || e.dataTransfer.files;
      console.log("Files", files);
      if (files.length === 1) {
        if (
          lodash.findIndex(this.datiSegnalazione.fileList, file => {
            return file.name == files[0].name;
          }) === -1
        ) {
          this.datiSegnalazione.fileList.push(files[0]);
        }
      } else {
        for (let i = 0; i < files.length; i++) {
          if (
            lodash.findIndex(this.datiSegnalazione.fileList, file => {
              return file.name == files[i].name;
            }) === -1
          ) {
            this.datiSegnalazione.fileList.push(files[i]);
          }
        }
      }
    },
    handleFileUpload(e) {
      this.file = e.target.files;
    },
    
    onCaptchaExpired: function () {
      this.$refs.recaptcha.reset();
    },
    onCaptchaVerified(recaptchaToken) {
      console.log(recaptchaToken)
      this.formData.append("insertForm", true);
      this.formData.append("token", recaptchaToken);
      this.formData.append("nome", this.datiSegnalante.nome);
      this.formData.append("cognome", this.datiSegnalante.cognome);
      this.formData.append(
        "qualificaProfessionale",
        this.datiSegnalante.qualifica
      );
      this.formData.append("sedeServizio", this.datiSegnalante.sedeServizio);
      this.formData.append("telefono", this.datiSegnalante.telefono);
      this.formData.append("email", this.datiSegnalante.email);
      this.formData.append("dataDa", this.datiSegnalazione.dateDa);
      this.formData.append("dataA", this.datiSegnalazione.dateA);
      this.formData.append(
        "luogoFatto",
        this.datiSegnalazione.luogoFatto.selected +
          ", " +
          this.datiSegnalazione.luogoFatto.value
      );

      let selectedStr = "";
      if (this.datiSegnalazione.azioniValore.selected.length > 1) {
        this.datiSegnalazione.azioniValore.selected.forEach((value, index) => {
          if (index + 1 == this.datiSegnalazione.azioniValore.selected.length) {
            selectedStr += value;
          } else {
            selectedStr += value + ", ";
          }
        });
      } else {
        selectedStr += this.datiSegnalazione.azioniValore.selected[0];
      }

      if (this.datiSegnalazione.azioniValore.altroChecked) {
        selectedStr += this.datiSegnalazione.azioniValore.altroValue;
      }

      this.formData.append("azioniValore", selectedStr);
      this.formData.append(
        "descrizioneFatto",
        this.datiSegnalazione.descrizioneFatto
      );
      this.formData.append("autoreFatto", this.datiSegnalazione.autori);
      this.formData.append(
        "eventualiSoggetti",
        this.datiSegnalazione.altriEventualiSoggeti
      );

      this.datiSegnalazione.fileList.forEach((file, index) => {
        console.log("file", file);
        this.formData.append("file" + index, file, file.name);
      });

      const vm = this;

      axios
        .post(this.endpoint + "api.php", this.formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          if (response.data.id) {
            this.formId = response.data.id;
            vm.sendMail(response.data.id);
            return response.data.id;
          } else {
            EventBus.$emit("snackbar", {
              color: "error",
              state: true,
              text: "Si è verificato un errore durante l'invio del modulo. Riprova"
            });
          }
          console.log("response", response);
        })
        .catch(error => {
          EventBus.$emit("snackbar", {
            color: "error",
            state: true,
            text: "Errore di rete"
          });
          console.log(error);
        });
    },
    insertCode(id, secretCode) {
      const vm = this;
      this.formData = new FormData();
      this.formData.append("insertCode", true);
      this.formData.append("id", id);
      this.formData.append("secretCode", secretCode);

      axios
        .post(this.endpoint + "api.php", vm.formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          this.$router.push({
            name: "thankyou",
            params: {
              code: response.data.code
            }
          });
          console.log("insertCode response", response);
        })
        .catch(error => {
          console.log(error);
          EventBus.$emit("snackbar", {
            color: "error",
            state: true,
            text: "Errore di rete!"
          });
        });
    },
    sendMail(id) {
      const vm = this;

      axios
        .post(this.endpoint + "mailer.php")
        .then(response => {
          console.log("Mail response", response);
          let code = response.data.code;
          vm.code = code;
          vm.insertCode(id, code);
          return true;
        })
        .catch(error => {
          EventBus.$emit("snackbar", {
            color: "error",
            state: true,
            text: "Errore di rete"
          });
          console.log(error);
        });
    }
  }
};
</script>

<style>
</style>

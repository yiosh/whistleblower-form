<template>
  <v-container>
    <v-layout  wrap>
      <v-flex xs12>
        <v-toolbar>
          <v-toolbar-title>Modello per la Segnalazione</v-toolbar-title>
        </v-toolbar>
        <v-form enctype="multipart/form-data" @submit.prevent="formSubmit">
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
                      label="Nome del segnalante"
                      disabled
                    ></v-text-field>
                  </v-flex>

                  <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                    <v-text-field
                      v-model="datiSegnalante.cognome"
                      label="Cognome del segnalante"
                      disabled
                    ></v-text-field>
                  </v-flex>

                  <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                    <v-layout row wrap>
                      <v-flex xs11>
                        <v-text-field
                          v-model="datiSegnalante.qualifica"
                          label="Qualifica o posizione professionale"
                          disabled
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
                      disabled
                    ></v-text-field>
                  </v-flex>

                  <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                    <v-text-field v-model="datiSegnalante.telefono" label="Telefono" disabled></v-text-field>
                  </v-flex>

                  <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                    <v-text-field v-model="datiSegnalante.email" label="Email" disabled></v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
              <!-- </v-form> -->
              <!-- <v-card color="grey lighten-1" class="mb-5" height="200px"></v-card> -->
              <v-card-actions>
                <v-btn color="#3581b5" dark @click="e1 = 3">Continua</v-btn>
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
                        disabled
                      ></v-text-field>
                      <v-date-picker
                        locale="it-it"
                        v-model="datiSegnalazione.dateDa"
                      ></v-date-picker>
                        <!-- @input="dateChanged" -->
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
                        disabled
                      ></v-text-field>
                      <v-date-picker
                        locale="it-it"
                        v-model="datiSegnalazione.dateA"
                      ></v-date-picker>
                        <!-- @input="datiSegnalazione.menu2 = false" -->
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
                        disabled
                      ></v-radio>
                    </v-radio-group>
                  </v-flex>
                  <v-flex xs12 md8>
                    <v-textarea
                      v-if="datiSegnalazione.luogoFatto.selected"
                      name="input-7-1"
                      label="Luogo o indirizzo della struttura"
                      v-model="datiSegnalazione.luogoFatto.value"
                      disabled
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
                      disabled
                    ></v-checkbox>
                    <v-layout row wrap>
                      <v-flex xs12 md3>
                        <v-checkbox
                          v-model="datiSegnalazione.azioniValore.altroChecked"
                          label="Altro"
                          :value="datiSegnalazione.azioniValore.altroChecked"
                          key="Altro"
                          disabled
                        ></v-checkbox>
                      </v-flex>
                      <v-flex xs12 md9>
                        <v-textarea
                          v-if="datiSegnalazione.azioniValore.altroChecked"
                          label="(Specificare)"
                          v-model="datiSegnalazione.azioniValore.altroValue"
                          disabled
                        ></v-textarea>
                      </v-flex>
                    </v-layout>
                    <v-flex xs12 md9>
                      <v-textarea
                        outline
                        label="Descrizione del fatto (Condotta ed evento)"
                        v-model="datiSegnalazione.descrizioneFatto"
                        disabled
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
                            disabled
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
                            v-model="datiSegnalazione.altriEventualiSoggetti"
                            :items="datiSegnalazione.altriEventualiSoggetti"
                            hide-selected
                            label="Altri eventuali soggetti a conoscenza del fatto e/o in grado di riferire sul medesimo"
                            multiple
                            clearable
                            small-chips
                            disabled
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
                      <!-- <v-btn color="#3581b5" dark @click.native="openFileDialog">Caricare
                        <v-icon right dark>cloud_upload</v-icon>
                      </v-btn> -->
                      <!-- <input
                        type="file"
                        style="display:none"
                        multiple
                        id="file-upload"
                        @change="onFileChange"
                      > -->
                      <p 
                        v-for="file in datiSegnalazione.fileList" 
                        :key="file.file"
                      >
                        <a
                          style="text-decoration: none;"
                          :href="file.path + '/' +  file.file" 
                          download 
                        >
                          <v-icon>save_alt</v-icon>
                          {{ file.file }}
                        </a>
                      </p>
                    </v-flex>
                  </v-flex>
                </v-layout>
              </v-container>
              <v-card-actions>
                <!-- <v-btn color="success" type="submit" dark>Invia</v-btn> -->
                <v-btn @click="e1 = 2" flat>Indietro</v-btn>
              </v-card-actions>
            </v-stepper-content>
          </v-stepper>
        </v-form>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from "axios";
import lodash from "lodash";

export default {
  props: ["updatedForm"],
  data: () => ({
    color: "success",
    snackbar: false,
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
      altriEventualiSoggetti: [],
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
    formSubmit() {
      this.formData.append("updateForm", true);
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
        .post("api.php", this.formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          console.log("saved successfully");
          // response = JSON.parse(response.data);
          console.log("response", response.data);

          // this.formId = response.data.id;
          // vm.sendMail();
          return response.data.id;
        });
    },
    insertCode(id, secretCode) {
      console.log("id", id);
      console.log("secretCode", secretCode);

      const vm = this;
      this.formData = new FormData();
      this.formData.append("insertCode", true);
      this.formData.append("id", id);
      this.formData.append("secretCode", secretCode);

      axios
        .post("api.php", vm.formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          console.log("fetch Comments response", response.data);
        });
    },
    sendMail() {
      const vm = this;

      axios
        .post("mailer.php")
        .then(response => {
          console.log("Mail response", response.data.code);
          let code = response.data.code;
          vm.code = code;
          return true;
        })
        .then(() => {
          // console.log("fcode", this.code);
          vm.insertCode(vm.formId, vm.code);
          vm.$emit("mail-sent", vm.code);
          vm.$emit("form-submit");
        });
    }
  },
  mounted() {
    if (this.updatedForm.nome) {
      this.datiSegnalante.nome = atob(this.updatedForm.nome);
    } else {
      this.datiSegnalante.anonimo = true;
    }

    if (this.updatedForm.cognome) {
      this.datiSegnalante.cognome = atob(this.updatedForm.cognome);
    }

    if (this.updatedForm.qualificaProfessionale) {
      this.datiSegnalante.qualifica = this.updatedForm.qualificaProfessionale;
    }

    if (this.updatedForm.sedeServizio) {
      this.datiSegnalante.sedeServizio = this.updatedForm.sedeServizio;
    }

    if (this.updatedForm.telefono) {
      this.datiSegnalante.telefono = atob(this.updatedForm.telefono);
    }

    if (this.updatedForm.email) {
      this.datiSegnalante.email = atob(this.updatedForm.email);
    }

    if (this.updatedForm.autoreFatto) {
      this.datiSegnalazione.autori.push(this.updatedForm.autoreFatto);
    }

    if (this.updatedForm.dataDa) {
      this.datiSegnalazione.dateDa = this.updatedForm.dataDa;
    }

    if (this.updatedForm.dataA) {
      this.datiSegnalazione.dateA = this.updatedForm.dataA;
    }

    if (this.updatedForm.luogoFatto) {
      this.datiSegnalazione.luogoFatto.selected = this.updatedForm.luogoFatto[0];
      this.datiSegnalazione.luogoFatto.value = this.updatedForm.luogoFatto[1];
    }

    if (this.updatedForm.azioniValore) {
      this.datiSegnalazione.azioniValore.selected = this.updatedForm.azioniValore;
    }

    if (this.updatedForm.altriEventualiSoggetti) {
      // if (this.updatedForm.altriEventualiSoggetti.length > 1) {
      //   this.updatedForm.altriEventualiSoggetti.forEach(name => {
      //     this.datiSegnalazione.altriEventualiSoggetti.push(name);
      //   });
      // } else {
      //   this.datiSegnalazione.altriEventualiSoggetti = this.updatedForm.altriEventualiSoggetti;
      // }
      this.datiSegnalazione.altriEventualiSoggetti = this.updatedForm.altriEventualiSoggetti;
    }

    if (this.updatedForm.descrizioneFatto) {
      this.datiSegnalazione.descrizioneFatto = this.updatedForm.descrizioneFatto;
    }

    if (this.updatedForm.autori) {
      this.datiSegnalazione.autori = this.updatedForm.autori;
    }

    if (this.updatedForm.fileList) {
      this.datiSegnalazione.fileList = this.updatedForm.fileList;
    }
  }
};
</script>

<style>
</style>

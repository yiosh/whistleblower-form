<template>
  <v-container>
    <v-layout text-xs-center wrap>
      <v-flex xs12>
        <v-toolbar>
          <v-toolbar-title>Modello per la segnalazione di condotte illecite</v-toolbar-title>
        </v-toolbar>
        <v-stepper v-model="e1" vertical>
          <v-stepper-step editable color="#3581b5" :complete="e1 > 1" step="1">Info</v-stepper-step>

          <v-stepper-content step="1">
            <v-card class="mb-3" flat>
              <v-card-text>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit suscipit molestiae itaque eum error dolorum provident vitae accusantium enim a obcaecati dignissimos totam necessitatibus odio iste qui doloremque, officia expedita sint aut odit illo eius amet. Ratione ipsum, quo dolore minus aliquam porro iste molestias accusantium fuga tenetur nihil placeat, dolores perspiciatis quisquam similique quia. Voluptate reprehenderit laudantium commodi! Quisquam, nihil sit eum vel possimus quis ducimus iure illum velit tenetur consequatur doloremque voluptatibus expedita tempore sequi pariatur similique ex. Ad nemo ab necessitatibus nulla qui ipsa laudantium eos quas debitis placeat doloremque dolorum, accusamus atque facere id? Repellat sint corrupti blanditiis. Ut amet possimus soluta minima voluptatum velit ullam alias. Laudantium voluptatum dolore, quos quam amet autem vitae, quidem harum fuga nam libero aliquam optio eaque voluptas non iste temporibus corrupti. Facilis incidunt, perspiciatis voluptate totam vero tenetur esse quaerat officia saepe beatae debitis itaque amet rerum excepturi exercitationem laborum? Dolores ut et laborum adipisci, nesciunt cumque est inventore ea explicabo repudiandae animi atque doloribus, ab, perspiciatis unde cum id velit omnis quidem amet voluptates molestias minima iure. Blanditiis.</v-card-text>
            </v-card>
            <v-btn color="#3581b5" dark @click="e1 = 2">Continua</v-btn>
          </v-stepper-content>

          <v-stepper-step color="#3581b5" editable :complete="e1 > 2" step="2">Dati Segnalante
            <!-- <small>Summarize if needed</small> -->
          </v-stepper-step>

          <v-stepper-content step="2">
            <v-form v-model="datiSegnalante.valid">
              <v-container>
                <v-layout row wrap>
                  <v-flex xs12>
                    <v-switch
                      :label="`Anonimo? ${datiSegnalante.anonimo === false ? 'No' : 'Sì'}`"
                      v-model="datiSegnalante.anonimo"
                    ></v-switch>
                  </v-flex>

                  <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                    <v-text-field
                      v-model="datiSegnalante.firstname"
                      label="Nome del segnalante"
                      required
                    ></v-text-field>
                  </v-flex>

                  <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                    <v-text-field
                      v-model="datiSegnalante.lastname"
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
                    <v-text-field v-model="datiSegnalante.telefono" label="Telefono" required></v-text-field>
                  </v-flex>

                  <v-flex v-if="datiSegnalante.anonimo === false" xs12 md6>
                    <v-text-field v-model="datiSegnalante.email" label="Email" required></v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-form>
            <!-- <v-card color="grey lighten-1" class="mb-5" height="200px"></v-card> -->
            <v-btn color="#3581b5" dark @click="e1 = 3">Continua</v-btn>
            <v-btn @click="e1 = 1" flat>Indietro</v-btn>
          </v-stepper-content>

          <v-stepper-step color="#3581b5" editable :complete="e1 > 3" step="3">Dati Segnalazione</v-stepper-step>

          <v-stepper-content step="3">
            <v-form v-model="datiSegnalante.valid">
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
                      v-model="datiSegnalante.menu1"
                      :nudge-right="40"
                      lazy
                      transition="scale-transition"
                      offset-y
                      full-width
                      min-width="290px"
                    >
                      <v-text-field
                        slot="activator"
                        v-model="datiSegnalante.dateDa"
                        label="Da"
                        append-icon="event"
                        readonly
                      ></v-text-field>
                      <v-date-picker v-model="datiSegnalante.dateDa" @input="dateChanged"></v-date-picker>
                    </v-menu>
                  </v-flex>
                  <v-flex xs12 md6>
                    <v-menu
                      :close-on-content-click="false"
                      v-model="datiSegnalante.menu2"
                      lazy
                      transition="scale-transition"
                      offset-y
                      full-width
                      min-width="290px"
                    >
                      <v-text-field
                        slot="activator"
                        v-model="datiSegnalante.dateA"
                        label="A"
                        append-icon="event"
                        readonly
                      ></v-text-field>
                      <v-date-picker
                        v-model="datiSegnalante.dateA"
                        @input="datiSegnalante.menu2 = false"
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
                        label="Descrizione del fatto (Condotta ed evento)"
                        v-model="datiSegnalazione.azioniValore.descrizioneFatto"
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
                            v-model="datiSegnalazione.altriSoggeti"
                            :items="datiSegnalazione.altriSoggeti"
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
                      <v-btn color="#3581b5" dark @click.native="openFileDialog">Upload
                        <v-icon right dark>cloud_upload</v-icon>
                      </v-btn>
                      <input
                        type="file"
                        id="file-upload"
                        style="display:none"
                        @change="onFileChange"
                      >
                      <!-- <v-btn type="file">hello</v-btn>
                      <upload-btn :fileChangedCallback="fileChanged"></upload-btn>-->
                      <p>{{ datiSegnalazione.fileList.name }}</p>
                    </v-flex>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-form>

            <v-btn color="success" dark>Invia</v-btn>
            <v-btn @click="e1 = 2" flat>Indietro</v-btn>
          </v-stepper-content>
        </v-stepper>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import UploadButton from "vuetify-upload-button";
export default {
  components: {
    "upload-btn": UploadButton
  },
  data: () => ({
    e1: 1,
    formData: new FormData(),
    cognome: "",
    datiSegnalante: {
      anonimo: false,
      menu1: false,
      menu2: false,
      nome: "",
      cognome: "",
      qualifica: "",
      sedeServizio: "",
      telefono: "",
      email: "",
      dateDa: null,
      dateA: null,
      valid: ""
    },
    datiSegnalazione: {
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
      descrizioneFatto: "",
      autori: [],
      altriSoggeti: [],
      eventualiAllegati: [],
      fileList: []
    }
  }),
  methods: {
    dateChanged() {
      this.datiSegnalante.menu1 = false;
      this.datiSegnalante.dateA = this.datiSegnalante.dateDa;
    },
    fileChanged(file) {
      // handle file here. File will be an object.
      // If multiple prop is true, it will return an object array of files.
      this.datiSegnalazione.fileList.push(file);
      console.log(file);
    },
    openFileDialog() {
      document.getElementById("file-upload").click();
    },
    onFileChange(e) {
      const files = e.target.files || e.dataTransfer.files;
      if (files.length > 0) {
        for (var i = 0; i < files.length; i++) {
          this.formData.append("file", files[i], files[i].name);
        }
      }
    },
    uploadFile() {
      console.log("worked");
      // var self = this;
      // axios
      //   .post("URL", self.formData)
      //   .then(function(response) {
      //     console.log(response);
      //   })
      //   .catch(function(error) {
      //     console.log(error);
      //   });
    }
  },
  computed: {
    // anonimous() {
    //   if (this.) {
    //   }
    //   return
    // }
  }
};
</script>

<style>
</style>

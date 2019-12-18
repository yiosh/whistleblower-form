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

                    <v-flex v-if="datiSegnalante.anonimo === false" xs12>
                      <v-dialog v-model="privacyDialog" width="500">
                        <template v-slot:activator="{ on }">
                          <v-checkbox
                            v-on="on"
                            v-model="checkbox"
                            :rules="[v => !!v || 'Devi accettare di continuare!']"
                            label="Autorizzo il trattamento dei miei dati ai fini della gestione di questa segnalazione."
                            required
                          ></v-checkbox>
                        </template>

                        <v-card>
                          <v-card-title class="headline grey lighten-2" primary-title>
                            Informativa Privacy
                          </v-card-title>

                          <v-card-text>
                            <h3>
                              Whistleblower Informativa sulla Protezione dei Dati Personali
                            </h3>
                            <strong
                              >(ai sensi dell’art. 13 del Regolamento Europeo
                              2016/679)</strong
                            >
                            <p>
                              Il Comune di Bitetto prima di acquisire i Suoi dati personali,
                              per finalità di gestione del whistleblowing ai sensi della legge
                              179/2017, La invita a leggere attentamente l’informativa in tema
                              di protezione dei dati personali.
                            </p>
                            <h4>I. Titolare del Trattamento e DPO</h4>
                            <strong>
                              In questa sezione le indichiamo quali sono i nostri riferimenti
                            </strong>

                            <table style="width:100%">
                              <tr>
                                <th>Titolare</th>
                                <td>
                                  Il Comune di Bitetto, con sede legale in Piazza Aldo Moro 1
                                  - 70020 Bitetto (BA), rappresentata dal Sindaco pro-tempore,
                                  Avv. Fiorenza Pascazio, è contattabile all’indirizzo PEC
                                  protocollo.bitetto@pec.egovba.it
                                </td>
                              </tr>
                              <tr>
                                <th>DPO</th>
                                <td>
                                  Contatto del Data Protection Officer (DPO): csipa@pec.it
                                </td>
                              </tr>
                            </table>

                            <br />

                            <h4>II. Tipologie di dati personali</h4>
                            <strong>
                              In questa sezione le indichiamo quali tipologie di dati Le
                              chiediamo
                            </strong>

                            <table style="width:100%">
                              <tr>
                                <th>Tipologia dati</th>
                                <th>Dettaglio dati</th>
                                
                              </tr>
                              <tr>
                                <td>
                                  Dati acquisiti direttamente dall’interessato
                                </td>
                                <td>
                                  <strong>Dati Comuni:</strong> dati anagrafici (nome, cognome, indirizzo, luogo e data di nascita), identificativi documento identità (numero patente/C.I./passaporto), dati di contatto (mail, contatti telefonici).
                                </td>
                              </tr>
                            </table>
                            <p>
                              I predetti dati saranno trattati con supporti informatici e
                              cartacei in modo da garantire idonee misure di sicurezza e
                              riservatezza.
                            </p>

                            <h4>III. Finalità del Trattamento</h4>
                            <strong
                              >
                              In questa sezione le indichiamo lo scopo del trattamento
                              effettuato sui Suoi dati
                              </strong
                            >
                            <table style="width:100%">
                              <tr>
                                <th>Finalità</th>
                                <th>Natura del conferimento</th>
                                <th>Base giuridica</th>
                              </tr>
                              <tr>
                                <td>
                                  <em>a)</em> Gestione del procedimento di whistleblowing
                                </td>
                                <td>
                                  <strong>Obbligatoria</strong>
                                </td>
                                <td>
                                  <strong>Legale</strong> ai sensi della L. 179/2017
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <em>b)</em> Gestione del procedimento disciplinare fondato in tutto o in parte sul whistleblowing
                                </td>
                                <td>
                                  <strong>Facoltativa</strong>
                                </td>
                                <td>
                                  <strong>Consenso</strong> ai sensi dell’art. 1, comma 3, L. 179/2017
                                </td>
                              </tr>
                            </table>
                            <br>
                            <strong>Dati personali acquisiti direttamente dall’interessato:</strong>
                            <ol>
                              <li><em>Comuni:</em> dati anagrafici (nome, cognome, indirizzo, data di nascita/morte, cittadinanza, stato civile, professione), codice di identificazione fiscale (di dipendenti e/o cittadini), identificativi documento identità (numero patente/C.I./passaporto), dati di contatto (mail, contatti telefonici), coordinate bancarie, dati economico-finanziari, reddituali, targa veicolo, credenziali, codice identificazione personale (CID).</li>
                              <li><em>Particolari:</em> dati idonei a rivelare l'appartenenza a partiti, sindacati, associazioni/organizzazioni a carattere religioso o filosofico o origini razziali/etniche, ceppi linguistici, dati idonei a rilevare comportamento, stato di salute, dati comportamentali /psicologici, appartenenza a categorie protette.</li>
                              <li><em>Giudiziari:</em> dati in materia di casellario giudiziale, di anagrafe delle sanzioni amministrative dipendenti da reato e dei relativi carichi pendenti, o la qualità di imputato o di indagato, liberazione condizionale, divieto/obbligo di soggiorno, misure alternative alla detenzione.</li>
                            </ol>

                            <strong>Altri dati personali:</strong>
                            <ol>
                              <li>Dati relativi alla gestione del rapporto di lavoro, dati multimediali (audio/video), dati di profilazione, dati di valutazione dei dipendenti, provvedimenti disciplinari.</li>
                            </ol>

                            <strong>Dati acquisiti in modo automatico durante la navigazione:</strong>
                            <ol>
                              <li>Indirizzo IP, il tipo di browser utilizzato, l’ISP, il sistema operativo, altri dati forniti in modo automatico durante la navigazione.</li>
                            </ol>

                            <p>Il conferimento dei dati necessari al perseguimento delle finalità sub a) ha natura “obbligatoria” e il Suo eventuale rifiuto comporterà l’impossibilità per il Comune di Bitetto di dar seguito alla segnalazione da Lei avanzata.</p>

                            <p>Il conferimento dei dati necessari al perseguimento delle finalità sub b) ha natura “facoltativa” e il Suo eventuale rifiuto comporterà, ai sensi dell’art. 1, comma 3, L. 179/2017, l’inutilizzabilità della segnalazione nell’ambito del procedimento disciplinare, eventualmente avviato, fondato in tutto o in parte sulla segnalazione stessa.</p>

                            <h4>IV. I soggetti destinatari dei dati</h4>
                            <strong>In questa sezione Le indichiamo chi tratterà i Suoi dati e a chi saranno comunicati</strong>

                            <p>Per il perseguimento delle finalità suddette i dati personali potranno essere comunicati ai seguenti soggetti non riconducibili al <em>Comune di Bitetto</em>, ovvero all’Autorità Giudiziaria o ad altre Autorità esterne, secondo le modalità richieste dalla vigente normativa.</p>

                            <h4>V. Conservazione dei dati</h4>
                            <strong>In questa sezione Le indichiamo per quanto tempo conserveremo i Suoi dati</strong>

                            <p>Per tutto il periodo necessario allo svolgimento degli eventuali procedimenti scaturenti dalla gestione della segnalazione (disciplinare, penale, contabile).</p>

                            <h4>VI. Diritti degli Interessati</h4>
                            <strong>In questa sezione Le indichiamo quali diritti Le garantiamo</strong>

                            <p>Il Regolamento UE 679/2016 (artt. da 15 a 23) conferisce agli interessati l’esercizio di specifici diritti. In particolare, in relazione al trattamento dei Suoi dati personali, ha diritto di chiedere al Comune di Bitetto l’accesso, la rettifica, la cancellazione, la limitazione, l’opposizione e la portabilità; inoltre può proporre reclamo, nei confronti dell’Autorità di Controllo, che in Italia è il Garante per la Protezione dei Dati Personali.</p>

                            <p>In qualsiasi momento, potrà chiedere di esercitare i Suoi diritti al Comune di Bitetto, che potrà contattare all’indirizzo mail whistleblowing@comune.bitetto.ba.it ovvero rivolgendosi al Data Protection Officer, che potrà contattare all’indirizzo mail: info@csipa.it</p>
                          
                          </v-card-text>

                          <v-divider></v-divider>

                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" flat @click="privacyDialog = false">
                              Accetto
                            </v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>


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
                <v-layout row class="mb-2">
                  <vue-recaptcha @verify="verify" sitekey="6LfDWcgUAAAAAO0FOGodn3C55_PgbKM5QjyHpBQH"></vue-recaptcha>
                </v-layout>

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
import VueRecaptcha from 'vue-recaptcha';

export default {
  components: { VueRecaptcha },
  data: () => ({
    privacyDialog: false,
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
          `Suscettibili di arrecare un pregiudizio alla immagine dell'amministrazione`
        ],
        altroChecked: false,
        altroValue: ""
      },
      formId: null,
      descrizioneFatto: "",
      autori: [],
      altriEventualiSoggeti: [],
      eventualiAllegati: [],
      fileList: [],
      captchaToken: null
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
    verify(token) {
      this.captchaToken = token;
      console.log(token)
    },
    onSubmit() {
      // Do stuff with the received token.
      this.onCaptchaVerified(this.captchaToken);
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
            selectedStr += value + ",";
          }
        });
      } else {
        selectedStr += this.datiSegnalazione.azioniValore.selected[0];
      }

      if (this.datiSegnalazione.azioniValore.altroChecked) {
        selectedStr += this.datiSegnalazione.azioniValore.altroValue;
      }
      console.log('selectedStr', selectedStr)

      this.formData.append("azioniValore", encodeURI(selectedStr));
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

<style scoped>
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

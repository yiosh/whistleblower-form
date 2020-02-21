<template>
  <v-app>
    <v-toolbar id="main-toolbar" height="100%" app dark color="#3581b5">
      <v-toolbar-title class="headline text-uppercase">
        <a href="https://www.comune.bitetto.ba.it">
          <v-layout style="justify-content: center; align-items: center;">
              <img src="@/assets/logo.png" alt="avatar" class="mr-2">
            <!-- <v-avatar
              class="mr-2"
              size="38"
              color="grey lighten-4"
            >
            </v-avatar> -->
            <span>Città di Bitetto</span>
          </v-layout>
        </a>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-items>
        <v-dialog v-model="privacyDialog" width="500">
          <template v-slot:activator="{ on }">
            <v-btn flat dark v-on="on">
              Privacy
            </v-btn>
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

        <v-btn :loading="loadingBtn" @click="handleModal" icon>
          <v-icon>vpn_key</v-icon>
        </v-btn>
      </v-toolbar-items>
    </v-toolbar>

    <v-content>
      <router-view />
    </v-content>
    <v-snackbar
      v-model="snackbar.state"
      :timeout="snackbar.timeout"
      :top="snackbar.y === 'top'"
      :color="snackbar.color"
    >
      {{ snackbar.text }}
      <v-btn flat @click="snackbar = false">
        Chiudi
      </v-btn>
    </v-snackbar>
    <Modal />
  </v-app>
</template>

<script>
import Modal from "@/components/Modal";
import EventBus from "@/eventBus.js";
import { endpoint } from "@/plugins/endpoint";
import axios from "axios";

export default {
  name: "App",
  components: {
    Modal
  },
  data() {
    return {
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
        text: "Il modulo è stato inviato con successo."
      }
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
        const response = await axios.post(`${endpoint}/api.php`, formData, {
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
    }
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

#main-toolbar .v-toolbar__content {
  height: 100% !important;
}
</style>

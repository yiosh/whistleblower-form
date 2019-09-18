<template>
  <v-container>
    <v-layout text-xs-center wrap>
      <v-flex xs12>
        <v-toolbar>
          <v-toolbar-title>Segnalazione</v-toolbar-title>
        </v-toolbar>
        <v-card>
          <v-list two-line>
            <template v-for="(item, index) in items">            
              <v-list-tile
                :key="item.title"
              >
                <v-list-tile-action>
                  <v-icon>{{ item.icon }}</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                  <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                  <v-list-tile-sub-title>
                    {{ item.subtitle }}
                  </v-list-tile-sub-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-divider
                v-if="index + 1 < items.length"
                :key="index"
              ></v-divider>
            </template>
          </v-list>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  props: ["header"],
  data() {
    return {
      items: [
        {
          icon: "inbox",
          title: "Contesto",
          subtitle: "14-05-2019 12:12"
        },
        {
          icon: "query_builder",
          title: "Data di creazione",
          subtitle: "14-05-2019 12:05"
        },
        {
          icon: "restore",
          title: "Ultimo aggiornamento",
          subtitle: "14-05-2019 12:04"
        },
        {
          icon: "hourglass_full",
          title: "Data di scadenza",
          subtitle: "14-05-2019 12:04"
        }
      ]
    };
  },
  mounted() {
    this.items[0].subtitle = this.header.context;

    if (this.header.createdAt) {
      this.items[1].subtitle = this.header.createdAt;
    }

    if (this.header.updatedAt) {
      this.items[2].subtitle = this.header.updatedAt;
    }

    if (this.header.expiresAt) {
      this.items[3].subtitle = this.header.expiresAt;
    }
  }
};
</script>

<style>
</style>

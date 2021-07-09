<template>
  <v-container class="mb-9">
    <v-card
      max-width="500px"
      class="centerx"
      v-if="!hasSecret() && !$route.params.hash"
    >
      <v-card-title class="px-6 primary white--text"
        >Titok lekérdezése</v-card-title
      >
      <v-form
        @submit.prevent="save"
        v-if="!submitted"
        ref="secretform"
        lazy-validation
        validate-on-blur
      >
        <v-card-text class="pt-8 px-6">
          <v-text-field
            label="Hash"
            :rules="[rules.required]"
            prepend-inner-icon="fas fa-pen"
            filled
            rounded
            v-model="get_hash"
          ></v-text-field>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions class="text-center justify-center pa-5">
          <v-btn type="submit" color="secondary"
            ><v-icon small class="mr-2">fas fa-paper-plane</v-icon>Küldés</v-btn
          ></v-card-actions
        >
      </v-form>
    </v-card>
    <v-card max-width="500px" class="centerx" v-if="hasSecret()">
      <v-card-title class="px-6 primary white--text">A titok</v-card-title>

      <v-card-text class="pt-8 px-6 getted_secret">
        <div class="mb-2"><span>Szöveg:</span> {{ secret.secret }}</div>
        <div class="my-2"><span>Lejárat:</span> {{ secret.date }}</div>
        <div class="my-2">
          <span>Maximum megtekintés:</span> {{ secret.expireAfterViews }}
        </div>
        <div><span>Megtekintések száma:</span> {{ secret.views }}</div>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { axiosInstance } from "@/main";
export default {
  name: "GetSecret",
  data: () => ({
    submitted: false,
    secret: {},
    rules: {
      required: true,
    },
    get_hash: "",
  }),
  components: {},
  created() {
    if (this.$route.params.hash) {
      this.get_hash = this.$route.params.hash;
      this.get();
    }
  },
  methods: {
    save() {
      this.rules = {
        required: (v) => !!v || "Mező kitöltése kötelező",
      };

      if (this.$refs.secretform.validate()) {
        console.log("save");
        this.get();
      }
    },
    get() {
      const this_ = this;
      axiosInstance
        .post(
          "/get_secret.php",
          {
            hash: this_.get_hash,
          },
          { withCredentials: false }
        )
        .then(function (response) {
          let r =
            typeof response === "object" &&
            typeof response.data !== "undefined" &&
            typeof response.data === "object"
              ? response.data
              : {};
          console.log("r status", r, response);
          if (r.status === "OK") {
            this_.$root.set_alert("success", "Sikeres lekérés");
            this_.secret = Object.assign({}, r);
            this_.error = false;
          } else if (r.status === "ERROR") {
            this_.$root.set_alert("error", r.message);
            this_.error = true;
          } else if (response.status === "ERROR") {
            this_.$root.set_alert("error", response.message);
          }
        })
        .catch(function (error) {
          console.log("error", error);
          this_.error = true;
          this_.$root.set_alert("error", "Sikertelen lekérés");
        });
    },
    hasSecret() {
      return (
        typeof this.secret === "object" &&
        typeof this.secret.secret !== "undefined" &&
        typeof this.secret.secret === "string" &&
        this.secret.secret.length > 0
      );
    },
  },
};
</script>

<style lang="scss" scoped>
.getted_secret {
  span {
    width: 200px;
    display: inline-block;
    font-weight: bold;
  }
}
</style>
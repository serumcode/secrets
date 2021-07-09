  <template>
  <v-container class="mb-9">
    <v-card max-width="500px" class="centerx" v-if="hash === ''">
      <v-card-title class="px-6 primary white--text"
        >Titok hozzáadása</v-card-title
      >

      <v-form
        @submit.prevent="save"
        v-if="!submitted"
        ref="secretform"
        lazy-validation
        validate-on-blur
      >
        <v-card-text class="pt-8 px-6">
          <v-textarea
            prepend-inner-icon="fas fa-pen"
            filled
            label="Titok"
            placeholder="Írj egy titkot"
            rounded
            v-model="secret"
            :rules="[rules.required, rules.min5]"
          >
          </v-textarea>
          <v-text-field
            label="Maximum megtekintés"
            :rules="[rules.required]"
            prepend-inner-icon="fas fa-eye"
            filled
            rounded
            v-model="expireAfterViews"
          ></v-text-field>
          <v-select
            v-model="expireAfter"
            rounded
            filled
            :items="expired_list"
            item-text="text"
            item-value="value"
            label="Lajárat (percben)"
            return-object
            :rules="[rules.required]"
            prepend-inner-icon="fas fa-clock"
          ></v-select>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions class="text-center justify-center pa-5">
          <v-btn type="submit" color="secondary"
            ><v-icon small class="mr-2">fas fa-paper-plane</v-icon>Küldés</v-btn
          ></v-card-actions
        >
      </v-form>
    </v-card>
    <v-card max-width="500px" class="centerx" v-if="hash !== ''">
      <v-card-title class="px-6 primary white--text">Hash kód</v-card-title>
      <v-alert class="ma-5 mb-2" dense icon="far fa-smile-beam" type="success">
        Ezzel a kóddal nézheted a titkodat. Vagy a lekérdezés menüpontban vagy a
        .../get_secret/[hash kódod] url címen.
      </v-alert>
      <v-card-text class="pt-5 text-center font-weight-bold">{{
        hash
      }}</v-card-text>
      <v-divider></v-divider>
      <v-card-actions class="py-4 px-5">
        <v-btn color="primary" @click="resetsecret()"
          ><v-icon class="mr-2">fas fa-cloud-upload-alt</v-icon>Új titok</v-btn
        >
        <v-spacer></v-spacer>
        <v-btn color="secondary" :to="'/get_secret/' + hash"
          ><v-icon class="mr-2">fas fa-cloud-download-alt</v-icon
          >Megnézem</v-btn
        >
      </v-card-actions>
    </v-card>
  </v-container>
</template>
<script>
import { axiosInstance } from "@/main";
export default {
  name: "CreateSecret",
  data: () => ({
    expireAfter: { text: "5 perc", value: 5 },
    expired_list: [
      { text: "5 perc", value: 5 },
      { text: "1 nap", value: 1440 },
      { text: "Végtelen", value: 0 },
    ],
    submitted: false,
    secret: "",
    hash: "",
    expireAfterViews: 10,
    rules: {
      required: true,
      min5: true,
    },
  }),
  components: {},
  methods: {
    save() {
      this.rules = {
        required: (v) => !!v || "Mező kitöltése kötelező",
        min5: (v) => (v && v.length >= 5) || "Minimum 5 karakter",
      };

      if (this.$refs.secretform.validate()) {
        console.log("save", process.env);
        const this_ = this,
          o = {
            expireAfter: this.expireAfter.value,
            expireAfterViews: this.expireAfterViews,
            secret: this.secret,
            date: new Date(),
          };
        axiosInstance
          .post(
            //"https://serumcode.com/secrets/backend/api/controller/secret/create.php",
            "/create.php",
            o, {withCredentials: false}
          )
          .then(function (response) {
            let r =
              typeof response === "object" &&
              typeof response.data === "object"
                ? response.data
                : {};
            //console.log('r status', r, o)
            if (r.status === "OK") {
              this_.$root.set_alert("success", "Sikeres elküldés");
              this_.hash = r.hash;
            } else if (r.status === "ERROR") {
              this_.$root.set_alert("error", r.message);
            }
          })
          .catch(function (error) {
            this_.$root.set_alert("error", "Sikertelen mentés." + error);
          });
      }
    },
    resetsecret() {
      this.secret = "";
      this.hash = "";
      this.submitted = false;
    },
  },
};
</script>
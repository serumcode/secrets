
 <template>
  <div>
    <v-app-bar
      color="var(--primary)"
      dense
      fixed
      flat
      :ripple="false"
      dark
      style="max-height: 48px"
    >
      <div class="navi">
        <v-app-bar-nav-icon
          @click="drawer = !drawer"
          class="d-md-none d-inline-flex"
          aria-label="Menü"
        ></v-app-bar-nav-icon>
        
        <v-btn
          text
          v-for="(item, i) in items"
          :key="i"
          tile
          :to="'/' + item.url"
          class="d-none d-md-inline-flex"
          @click="$root.clickednav = true"
        >
        <v-icon class="mr-2">{{item.icon}}</v-icon>
          {{ item.name }}
        </v-btn>
      </div>
    </v-app-bar>
    <v-navigation-drawer
      v-model="drawer"
      class="primary2 uppercase"
      style="z-index: 10"
      fixed
      temporary
      clipped
    >
      <v-list nav dense>
        <v-list-item-group active-class="primary white--text">
          
          <v-list-item v-for="(n, i) in items" :to="'/' + n.url" :key="i">
            <v-list-item-title>{{ n.name }}</v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
    <v-dialog>
      <v-card> </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  name: "Navigation",
  data: () => ({
    drawer: false,
    items: [
      { name: "Titok hozzáadása", url: "" ,icon:'fas fa-cloud-upload-alt'},
      { name: "Lekérdezés", url: "get_secret", icon: 'fas fa-cloud-download-alt' },
    ],
  }),
  components: {},
};
</script>
   
   

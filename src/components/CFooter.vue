   <template>
   <v-footer class="primary" dark
      
      :padless="true"
    >
      <v-card
        flat
        tile
        width="100%"
        class="primary text-center"
      >
   
          
        

        <v-divider></v-divider>

        <v-card-text class="white--text" color="primary">
          {{ new Date().getFullYear() }} — <strong class="uppercase">Titkos titok</strong> — created by  <strong><a class="mr-2 white--text" href="https://serumcode.com">serumcode</a></strong>
        </v-card-text>
      </v-card>
    </v-footer>
</template>

<script>
export default {
  name: "CFooter",
  data: () => ({
    
  }),
  methods:{
      new_tab(url) {
            window.open(url, '_blank');
        }
  },
  components: {},
};
</script>
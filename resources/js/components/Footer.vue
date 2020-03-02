<template>
  <footer class="footer">
    <button v-if="isLogin" class="button button--link" @click="logout">Logout</button>
    <RouterLink v-else class="button button--link" to="/login">
      Login / Register
    </RouterLink>
  </footer>
</template>

<script type="text/javascript">
    amzn_assoc_ad_type = "link_enhancement_widget";
    amzn_assoc_tracking_id = "siwakes-22";
    amzn_assoc_linkid = "04bbf71bebcc4c19aa7e9c6f5349985f";
    amzn_assoc_placement = "";
    amzn_assoc_marketplace = "amazon";
    amzn_assoc_region = "JP";
</script>
<script src="//ws-fe.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&Operation=GetScript&ID=OneJS&WS=1&MarketPlace=JP"></script>

<script>
import { mapState, mapGetters } from 'vuex'

export default {
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus
    }),
    ...mapGetters({
      isLogin: 'auth/check'
    })
  },
  methods: {
    async logout () {
      await this.$store.dispatch('auth/logout')

      if (this.apiStatus) {
        this.$router.push('/login')
      }
    }
  }
}

</script>
<template>
  <div>
    <p v-if="attempting">Twitterでログインしています。</p>

    <template v-else>
      <p>Twitterでのログインに失敗しました。</p>
      <p>{{ failedMessage }}</p>
    </template>
  </div>
</template>

<script>
import { mapMutations } from 'vuex'

export default {
  middleware: 'guest',

  data () {
    return {
      failedMessage: null
    }
  },

  computed: {
    attempting () {
      return !this.failedMessage
    }
  },

  methods: mapMutations([
    'setToken',
    'setUser'
  ]),

  async mounted () {
    try {
      //this.$store.dispatch('auth/register', this.registerForm)
      //authストアのtwloginを呼び出す
      //const getToken = await this.$store.dispatch('api/requestToken')
      //const callbakData = await this.$store.dispatch('auth/twlogin')
      
      //await this.$store.dispatch('auth/twlogin')
      //const callbackData = await this.axios.get('/oauth/twitter/callback', { params: this.$route.query })

      //this.setToken({ token: callbackData.token })
      //this.setUser({ user: callbackData.user })
      
      //$user = Socialite::driver('github')->userFromToken($token);
      
      //token読み込み
      const callbackData = await this.$http.get('oauth/twitter/callback',{ params: this.$route.query })
      //authストアでtokenをstateにset
      await this.$store.dispatch('auth/twlogin', callbackData)
      
      this.$router.replace('/')
    } catch (error) {
      this.failedMessage = error.message
    }
  }
}
</script>
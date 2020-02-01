<template>
  <div class="container--small">
    <div class="panel" >
        <div class="panel">
            <form class="form"  @submit.prevent="login">
                <div>
                    <button class="btn btn-block btn-social btn-twitter">
                        <span class="fa fa-twitter"></span><div style="font-size:22px">Sign in With Twitter</div>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
</div>
</template>

<script>
export default {
    data () {
        return {
            tab: 1,
            loginForm: {
                email: '',
                password: ''
            },registerForm: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }
        }
    } ,computed: {
        apiStatus () {
            return this.$store.state.auth.apiStatus
        }, loginErrors () {
            return this.$store.state.auth.loginErrorMessages
        }, registerErrors () {
            return this.$store.state.auth.registerErrorMessages
        }
    }, methods: {
        
        async login(){
            if (this.apiStatus) {
                // リダイレクトページに移動する
                this.$router.push('/oauth/twitter')
            }
        }
        ,clearError () {
            this.$store.commit('auth/setLoginErrorMessages', null)
            this.$store.commit('auth/setRegisterErrorMessages', null)
        }
    }
}
</script>
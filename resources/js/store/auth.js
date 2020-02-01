import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'
const inBrowser = typeof window !== 'undefined'
import Cookies from 'js-cookie';

const state = {
  user: null,
  apiStatus: null,
  loginErrorMessages: null,
  registerErrorMessages: null
}

const getters = {
  check: state => !! state.user,
  username: state => state.user ? state.user.name : ''
}

const mutations = {
  setUser (state, user) {
    state.user = user
  },
  setApiStatus (state, status) {
    state.apiStatus = status
  },
  setLoginErrorMessages (state, messages) {
    state.loginErrorMessages = messages
  },
  setRegisterErrorMessages (state, messages) {
    state.registerErrorMessages = messages
  },
  setToken (state,  token ) {
    state.token = token
    
    // Store token in cookies
    if (inBrowser) {
      if (token) {
        Cookies.set('token', token, { expires: 30 })
      } else {
        Cookies.remove('token')
      }
    }
  }
}

const actions = {
  // 会員登録
  async register (context, $data) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/register', $data)

    if (response.status === CREATED) {
      context.commit('setApiStatus', true)
      context.commit('setUser', response.data)
      return false
    }

    context.commit('setApiStatus', false)
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit('setRegisterErrorMessages', response.data.errors)
    } else {
      context.commit('error/setCode', response.status, { root: true })
    }
  },

  // ログイン
  async login (context, $data) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/login', $data)

    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', response.data)
      return false
    }

    context.commit('setApiStatus', false)
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit('setLoginErrorMessages', response.data.errors)
    } else {
      context.commit('error/setCode', response.status, { root: true })
    }
  },

  // ログアウト
  async logout (context) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/logout')

    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', null)
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },

  // ログインユーザーチェック
  async currentUser (context) {
    context.commit('setApiStatus', null)
    const response = await axios.get('/api/user')
    const user = response.data || null

    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', user)
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  //twitterログイン
  async twlogin (context, callbackData){
    context.commit('setApiStatus', null)
    
    const token = callbackData.config.params || null
    
    
    if (callbackData.status === 200) {
      context.commit('setApiStatus', true)
      context.commit('setToken', token)
      
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', callbackData.status, { root: true })
  },async twset(context,$data){
    console.log($data)
  },
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
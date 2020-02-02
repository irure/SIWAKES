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
    
    //タスクをデータベースに保存
  },async postTask(context,$data){
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/task',$data);
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
    
    //タスク一覧をデータベースから取得
  },async getTask(context){
    context.commit('setApiStatus', null)
    const response = await axios.get('/api/task')
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
    
    //タスクを削除
  },async deleteTask(context,id){
    context.commit('setApiStatus', null)
    const response = await axios.delete('/api/task/'+id)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
    
    //タスクを更新
  },async updateTask(context,data){
    context.commit('setApiStatus', null)
    console.log(data)
    const response = await axios.put('/api/task/'+data.id+'/'+data.task)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
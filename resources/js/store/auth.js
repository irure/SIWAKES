import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'
const inBrowser = typeof window !== 'undefined'
import Cookies from 'js-cookie';

const state = {
  user: null,
  apiStatus: null,
  loginErrorMessages: null,
  registerErrorMessages: null,
  part:null
}

const getters = {
  check: state => !! state.user,
  username: state => state.user ? state.user.name : '',
  part: state => state.user ? state.user.part : ''
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
  },
  setPart (state,  part ) {
    state.part = part
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
    const response = await axios.put('/api/task/'+data.id+'/task/'+data.task)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
    
  //時間を更新
  },async updateHowlong(context,data){
    context.commit('setApiStatus', null)
    console.log(data)
    const response = await axios.put('/api/task/'+data.id+'/howlong/'+data.howlong)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //回数を更新
  async updateHowtimes(context,data){
    context.commit('setApiStatus', null)
    console.log(data)
    const response = await axios.put('/api/task/'+data.id+'/howtimes/'+data.howtimes)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //担当を更新
  async updateCharge(context,data){
    context.commit('setApiStatus', null)
    console.log(data)
    const response = await axios.put('/api/task/'+data.id+'/charge/'+data.charge)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //担当2を更新
  async updateCharge2(context,data){
    context.commit('setApiStatus', null)
    console.log(data)
    const response = await axios.put('/api/task/'+data.id+'/charge2/'+data.charge2)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //担当一覧を取得
  async getCharge(context){
    context.commit('setApiStatus', null)
    const response = await axios.get('/api/charge')
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //担当一覧の担当を更新
  async updateChargeList(context,data){
    context.commit('setApiStatus', null)
    console.log(data)
    const response = await axios.put('/api/charge/'+data.charge_id+'/'+data.charge)
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //グラフデータを取得
  async getGraph(context){
    context.commit('setApiStatus', null)
    const response = await axios.get('/api/getgraph')
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //グラフデータ2を取得
  async getGraph2(context){
    context.commit('setApiStatus', null)
    const response = await axios.get('/api/getgraph2')
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //星の数をDBに保存
  async setRating(context,rating){
    const response = await axios.post('/api/setRating',rating)
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //星の数2をDBに保存
  async setRating2(context,rating2){
    const response = await axios.post('/api/setRating2',rating2)
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //星の数をDBから取得
  async getRating(context){
    const response = await axios.get('/api/getRating')
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //星の数2をDBから取得
  async getRating2(context){
    const response = await axios.get('/api/getRating2')
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //テキストを取得
  async getText(context){
    const response = await axios.get('/api/getText')
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //テキスト2を取得
  async getText2(context){
    const response = await axios.get('/api/getText2')
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //Twitterに投稿
  async postTwitter(context,data){
    const response = await axios.post('/api/postTwitter',data)
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //Part情報を取得
  async getPart(context){
    const response = await axios.get('/api/getPart')
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //Partを0に設定
  async setPartFalse(context){
    const response = await axios.post('/api/setPartFalse')
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setPart', 0)
      return response.data
    }
    
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  
  //Partを1に設定
  async setPart(context){
    const response = await axios.post('/api/setPart')
    console.log(response.data)
    
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setPart', 1)
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
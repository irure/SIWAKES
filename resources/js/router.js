import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import Tasks from './pages/Tasks.vue'
import Login from './pages/Login.vue'
import SystemError from './pages/errors/System.vue'
import Redirect from './pages/oauth/twitter/Redirect.vue'
import Callback from './pages/oauth/twitter/Callback.vue'

import store from './store'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/',
    component: Tasks
  },
  {
    path: '/login',
    component: Login,
    beforeEnter (to, from, next) {
      if (store.getters['auth/check']) {
        next('/')
      } else {
        next()
      }
    }
  },{
    path: '/500',
    component: SystemError
  },{
    path: '/oauth/twitter',
    component: Redirect
  },{
    path: '/oauth/twitter/Callback',
    component: Callback
  },
  
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
    mode: 'history',
    routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router
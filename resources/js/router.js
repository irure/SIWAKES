import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import Tasks from './pages/Tasks.vue'
import Tasks2 from './pages/Tasks2.vue'
import Login from './pages/Login.vue'
import Charge from './pages/Charge.vue'
import Graph from './pages/Graph.vue'
import Graph2 from './pages/Graph2.vue'
import SystemError from './pages/errors/System.vue'
import Redirect from './pages/oauth/twitter/Redirect.vue'

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
    path: '/charge',
    component: Charge
  },{
    path: '/graph',
    component: Graph,
    name:'VueChartKick'
  },{
    path: '/Tasks2',
    component: Tasks2
  },{
    path: '/graph2',
    component: Graph2,
    name:'VueChartKick'
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
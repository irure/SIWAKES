<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <router-link to="/" tag="button">タスク一覧</router-link>
                    <router-link to="/graph" tag="button">グラフ</router-link>
                    <router-link to="/charge" tag="button">担当者変更</router-link>
                </div>
                <div class="card-header">
                    <pie-chart :data="chartData" :colors ="colors" download = "graph"></pie-chart>
                </div>
                <div>
                    満足度は：<star-rating :star-size="30" v-model="rating" @rating-selected ="setRating"></star-rating>
                </div>
                <button v-on:click="openModal">完成</button>
                <div id="overlay" v-show="showContent">
                    <div id="mordal">
                        <p>これがモーダルウィンドウです。</p>
                        <p><button v-on:click="closeModal">close</button></p>
                        <img src="graph">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                active_task: null,
                charges:[],
                chartData: [['Jan', 44], ['Feb', 27], ['Mar', 60],],
                rating: 0,
                colors: ["lightskyblue", "gainsboro", "lightpink"],
                showContent: false,
            }
        },
        methods:{
            getChargeList(){
                this.$store.dispatch('auth/getCharge').then((result)=>{
                    this.charges = result
                })
            },
            getGraphData(){
                this.$store.dispatch('auth/getGraph').then((result)=>{
                    //this.chartData = result
                })
            },
            setRating: function(rating){
                this.rating= rating;
            },
            openModal: function(){
                this.showContent = true
            },
            closeModal: function(){
                this.showContent = false
            }
        },
        mounted() {
            this.getGraphData()
            console.log('Component mounted.')
        }
    }
</script>
<style>
#overlay{
  /*　要素を重ねた時の順番　*/
  z-index:1;

  /*　画面全体を覆う設定　*/
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background-color:rgba(0,0,0,0.5);

  /*　画面の中央に要素を表示させる設定　*/
  display: flex;
  align-items: center;
  justify-content: center;
}

#mordal{
  z-index:2;
  width:50%;
  padding: 1em;
  background:#fff;
}
</style>
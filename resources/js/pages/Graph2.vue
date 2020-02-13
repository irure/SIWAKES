<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel toppanel" style="padding:5px;">
                    <router-link to="/" tag="button"class="button" @click.native="setPartFalse"><<1回目に戻る</router-link>
                </div>
                <div class="panel toppanel">
                    <router-link to="/Tasks2" tag="button"class="button">タスク一覧</router-link>
                    <router-link to="/graph2" tag="button"class="button sbutton">グラフ</router-link>
                </div>
                <div class="panel">
                    <ul class="tab" style="justify-content:center;">
                        <li class="tab__item":class="{'tab__item--active': tab === 1 }"@click="tab = 1">1回目のグラフ</li>
                        <li class="tab__item" :class="{'tab__item--active': tab === 2 }" @click="tab = 2">2回目のグラフ</li>
                    </ul>
                    <div class="card-header" v-show="tab === 1">
                        <pie-chart :data="chartData" :colors ="colors" download = "graph" title="1回目" donut=true></pie-chart>
                        <div>
                        1回目の満足度は：<star-rating :star-size="30" v-model="rating" @rating-selected ="setRating" :read-only = true class="star-rating"></star-rating><br>
                        </div>
                    </div>
                    
                    <div class="card-header" v-show="tab === 2">
                        <pie-chart :data="chartData2" :colors ="colors" download = "graph2" title="2回目" donut=true></pie-chart>
                        <div>
                        2回目の満足度は：<star-rating :star-size="30" v-model="rating2" @rating-selected ="setRating2" class="star-rating"></star-rating><br>
                        </div>
                        <button v-on:click="openModal">これで完成！</button>
                    
                    <div id="overlay" v-show="showContent">
                        <div id="mordal">
                            <p><button v-on:click="closeModal" style="float:left;">戻る</button></p><br>
                            <p>お疲れ様です！以下の内容でツイートしますか？</p>
                            <div class="form-group">
                                <textarea class="form-control" type="text" v-model="text" cols="40" rows="10" style="resize: none;background-color:floralwhite;color:#333;font-size:14px;"></textarea>
                                <div class="text-danger" v-if="errors.text" v-text="errors.text"></div>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="file" accept="image/*" @change="onFileChange"><br>
                                <label>ダウンロードしたグラフを追加できます</label><br>
                                <div class="text-danger" v-if="errors.image" v-text="errors.image"></div>
                            </div>
                        <p><button v-on:click="postTwitter" style="text-align:center;"class="tweet">ツイートして完了</button></p>
                    </div>
                    </div>
                    
                    
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
                tab: 2,
                charges:[],
                chartData: [],
                chartData2: [],
                rating: 0,
                rating2:0,
                colors: ["lightskyblue", "gainsboro", "lightpink"],
                showContent: false,
                text: '',
                image: '',
                imageFile: null,
                errors: {
                    text: '',
                    image: ''
                }
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
                    this.chartData = result
                })
            },
            getGraphData2(){
                this.$store.dispatch('auth/getGraph2').then((result)=>{
                    this.chartData2 = result
                })
            },
            getRating(){
                this.$store.dispatch('auth/getRating').then((result)=>{
                    this.rating = result
                })
            },
            getRating2(){
                this.$store.dispatch('auth/getRating2').then((result)=>{
                    this.rating2 = result
                })
            },
            setRating: function(rating){
                this.rating= rating
                this.$store.dispatch('auth/setRating',{rating:rating})
            },
            setRating2: function(rating2){
                this.rating2= rating2
                this.$store.dispatch('auth/setRating2',{rating2:rating2})
            },
            openModal: function(){
                this.showContent = true
                
                this.$store.dispatch('auth/getText2').then((result)=>{
                    this.text = result
                })
            },
            closeModal: function(){
                this.showContent = false
            },
            finishGraph(){
                this.showContent=false
                this.$router.replace('/Tasks2')
            },
            onFileChange(e) {
                // 選択された画像を変数で保持する
                this.imageFile = e.target.files[0];
            },
            postTwitter(){
                this.showContent = false
                // 画像をアップロード
                const url = '/share';
                let formData = new FormData();
                formData.append('text', this.text);
                if(this.imageFile)formData.append('image', this.imageFile);
                
                this.$store.dispatch('auth/postTwitter',formData)
                alert("Tweetしました")
                this.showContent2=true
                
            },
            getPart(){
                this.$store.dispatch('auth/getPart').then((result)=>{
                    if(result){
                        this.part = result
                    }else{
                        this.$router.replace('/')
                    }
                })
            },
            setPartFalse(){
                this.$store.dispatch('auth/setPartFalse')
                this.$router.replace('/')
            }
        },
        mounted() {
            this.getPart()
            this.getGraphData()
            this.getGraphData2()
            this.getRating()
            this.getRating2()
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
  width:500px;
  padding: 1em;
  background:cornsilk;
  border-radius:6px;
}
.tweet{
    background-color:#2795e9;
    color:#fff;
}
</style>
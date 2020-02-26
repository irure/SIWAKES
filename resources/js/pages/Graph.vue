<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel toppanel">
                    <router-link to="/" tag="button"class="button">タスク一覧</router-link>
                    <router-link to="/graph" tag="button"class="button sbutton">グラフ</router-link>
                    <router-link to="/charge" tag="button"class="button">担当者変更</router-link>
                </div>
                <div class="panel">
                    <div class="card-header">
                        <pie-chart :data="chartData" :colors ="colors" download = "graph" title="1回目" donut=true></pie-chart>
                    </div>
                    <div>
                        満足度は：<star-rating :star-size="30" v-model="rating" @rating-selected ="setRating" class="star-rating"></star-rating><br>
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
                                <input class="form-control" type="file" accept="image/*" @change="onFileChange2"><br>
                                <label>ダウンロードしたグラフなどを追加できます</label><br>
                                <div class="text-danger" v-if="errors.image" v-text="errors.image"></div>
                            </div>
                        <p><button v-on:click="finishGraph" style="float:left;">ツイートせず1回目の仕分けを完了</button></p>
                        <p><button v-on:click="postTwitter" style="float:right; text-align:center;"class="tweet">ツイートして1回目の仕分けを完了</button></p>
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
                charges:[],
                chartData: [],
                rating: 0,
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
        computed:{
            partStatus(){
                return this.$store.state.auth.part
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
            setRating: function(rating){
                this.rating= rating
                this.$store.dispatch('auth/setRating',{rating:rating})
            },
            openModal: function(){
                this.showContent = true
                
                this.$store.dispatch('auth/getText').then((result)=>{
                    this.text = result
                })
            },
            closeModal: function(){
                this.showContent = false
            },
            async finishGraph(){
                this.showContent=false
                await this.$store.dispatch('auth/setPart')
                await this.$router.replace('/Tasks2')
            },
            onFileChange(e) {
                // 選択された画像を変数で保持する
                this.imageFile = e.target.files[0];
            },
            onFileChange2(e) {
                // 選択された画像を変数で保持する
                this.imageFile2 = e.target.files[0];
            },
            async postTwitter(){
                this.showContent = false
                // 画像をアップロード
                let formData = new FormData();
                formData.append('text', this.text);
                if(this.imageFile)formData.append('image', this.imageFile);
                if(this.imageFile2)formData.append('image2', this.imageFile2);
                
                this.$store.dispatch('auth/postTwitter',formData)
                await this.$store.dispatch('auth/setPart')
                alert("Tweetしました")
                await this.$router.replace('/Tasks2')
            },
            getRating(){
                this.$store.dispatch('auth/getRating').then((result)=>{
                    this.rating = result
                })
            },
            async getPart(){
                if(this.partStatus){
                    await this.$router.replace('/Tasks2')
                }else{
                    
                }
            },
        },
        mounted() {
            this.getPart()
            this.getGraphData()
            this.getRating()
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


.tweet{
    background-color:#2795e9;
    color:#fff;
}
</style>
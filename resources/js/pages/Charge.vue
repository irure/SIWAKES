<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel toppanel">
                    <router-link to="/" tag="button" class="button">タスク一覧</router-link>
                    <router-link to="/graph" tag="button" class="button">グラフ</router-link>
                    <router-link to="/charge" tag="button" class="button sbutton">担当者変更</router-link>
                </div>
                <div class="panel">
                    <div class="card" v-for="charge in charges">
                        <div class="card-header">
                            担当{{charge.charge_id}}:<input type="text" class="form-control" id="charge" v-model="charge.charge" @blur="updateChargeList(charge.id)" style="width:6rem;" required>
                        </div>
                    </div>
                    ※担当１は<label class="fuchidori" style="color:lightskyblue;">青</label>、２は<label class="fuchidori" style="color:gainsboro;">灰色</label>、３は<label class="fuchidori" style="color:lightpink;">ピンク色</label>でグラフに描画されます
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
            updateChargeList(id){
                let data = {charge:this.charges.filter((v)=>{return v.id === id})[0].charge}
                if(data.charge){
                    this.$store.dispatch('auth/updateChargeList',{charge_id:id,charge:data.charge}).then(()=>{
                    this.getChargeList()
                })}
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
            this.getChargeList()
            console.log('Component mounted.')
        }
    }
</script>
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
                            担当{{charge.charge_id}}:<input type="text" class="form-control" id="charge" v-model="charge.charge" @blur="updateChargeList(charge.id)" style="width:7em;">
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
                this.$store.dispatch('auth/updateChargeList',{charge_id:id,charge:data.charge}).then(()=>{
                    this.getChargeList()
                })
            },
            getPart(){
                this.$store.dispatch('auth/getPart').then((result)=>{
                    if(result){
                        this.$router.replace('/Tasks2')
                    }else{
                        this.part = result
                    }
                })
            },
        },
        mounted() {
            this.getPart()
            this.getChargeList()
            console.log('Component mounted.')
        }
    }
</script>
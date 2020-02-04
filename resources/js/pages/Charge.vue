<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <router-link to="/" tag="button">タスク一覧</router-link>
                    <router-link to="/foo" tag="button">グラフ</router-link>
                    <router-link to="/charge" tag="button">担当者変更</router-link>
                </div>
                <div class="card" v-for="charge in charges">
                    <div class="card-header">
                        <input type="text" class="form-control" id="charge" v-model="charge.charge" @blur="updateChargeList(charge.id)">
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
                this.$store.dispatch('auth/updateChargeList',{id:id,charge:data.charge}).then(()=>{
                    this.getChargeList()
                })
            },
        },
        mounted() {
            this.getChargeList()
            console.log('Component mounted.')
        }
    }
</script>
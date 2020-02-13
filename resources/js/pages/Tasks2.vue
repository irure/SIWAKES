<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel toppanel" style="padding:5px;">
                    <router-link to="/" tag="button"class="button" @click.native="setPartFalse"><<1回目に戻る</router-link>
                </div>
                <div class="panel toppanel">
                    <router-link to="/Tasks2" tag="button"class="button sbutton">タスク一覧</router-link>
                    <router-link to="/graph2" tag="button"class="button">グラフ</router-link>
                </div>
                <div class="panel table-responsive">
                    <table class="table-striped" align="center">
                        <tr>
                            <td>タスク名</td><td>1回/分</td><td>1週間/回</td><td>担当者</td><td></td><td>担当2</td>
                        </tr>
                        <tr class="card" v-for="task in tasks">
                            <td>{{task.task}}</td>
                            <td>{{task.howlong}}分</td>
                            <td>{{task.howtimes}}回</td>
                            <td>{{task.charge}}</td>
                            <td>⇒</td>
                            <td><select class="form-control" v-model="task.charge2" @blur="updateCharge2(task.id)">
                                <option v-for="charge in charges">
                                    {{ charge.charge }}
                                </option>
                            </select></td>
                            </tr>
                        </table>
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
                tasks:[],
                taskForm:{
                    task:'',
                },
                times:[1,2,3,4,5,6,7],
                charges:[]
            }
        },
        methods:{
            getTaskList(){
                this.$store.dispatch('auth/getTask').then((result)=>{
                    this.tasks = result
                })
            },
            updateCharge2(id){
                let data = {charge2:this.tasks.filter((v)=>{return v.id === id})[0].charge2}
                this.$store.dispatch('auth/updateCharge2',{id:id,charge2:data.charge2}).then(()=>{
                    this.getTaskList()
                })
            },
            getChargeList(){
                this.$store.dispatch('auth/getCharge').then((result)=>{
                    this.charges = result
                })
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
            this.getTaskList()
            this.getChargeList()
            console.log('Component mounted.')
        }
    }
</script>
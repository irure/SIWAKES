<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel toppanel" style="padding:5px;">
                    <button tag="button"class="button" v-on:click="setPartFalse"><<1回目に戻る</button>
                </div>
                <div class="panel toppanel">
                    <router-link to="/Tasks2" tag="button"class="button sbutton">タスク一覧</router-link>
                    <router-link to="/graph2" tag="button"class="button">グラフ</router-link>
                </div>
                <div class="panel table-responsive">
                    <table class="table-striped" align="center">
                        <tr>
                            <td>タスク名</td><td v-if=" isLarge === true ">1回/分</td><td v-if=" isLarge === true ">1週間/回</td><td v-if=" isLarge === false ">時間</td><td>担当者</td><td></td><td>担当2</td>
                        </tr>
                        <tr class="card" v-for="task in tasks">
                            <td>{{task.task}}</td>
                            <td v-if=" isLarge === true ">{{task.howlong}}分</td>
                            <td v-if=" isLarge === true ">{{task.howtimes}}回</td>
                            <td v-if=" isLarge === false ">{{task.howlong*task.howtimes}}分</td>
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
        computed:{
            partStatus(){
                return this.$store.state.auth.part
            },
            isLarge() {
                if(window.matchMedia('(min-width: 600px)').matches)
                {
                    return true;
                } else {
                    return false;
                }
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
            async getPart(){
                if(await this.partStatus){
                }else{
                    await this.$router.replace('/')
                }
            },
            async setPartFalse(){
                await this.$store.dispatch('auth/setPartFalse')
                await this.$router.replace('/')
            }
        },
        
        mounted() {
            this.$store.watch((state, getters) => getters.setPart,)
            this.getPart()
            this.getTaskList()
            this.getChargeList()
            console.log('Component mounted.')
        }
    }
</script>